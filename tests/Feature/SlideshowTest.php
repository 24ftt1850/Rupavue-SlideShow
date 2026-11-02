<?php

use App\Models\GeneratedImage;
use App\Models\PhotoshootTheme;
use Livewire\Livewire;

beforeEach(function () {
    config(['slideshow.booth_url' => 'https://booth.test']);
});

test('the home page shows the slideshow', function () {
    createBoothTables();

    $this->get(route('home'))
        ->assertOk()
        ->assertSee('Welcome to RupaVue');
});

test('the latest successful photos are shown newest first with their theme', function () {
    createBoothTables();
    $theme = PhotoshootTheme::factory()->create(['theme_name' => 'Seoul Winter']);
    $older = GeneratedImage::factory()->for($theme, 'theme')->create(['generated_photo_path' => 'photobooth/older.png']);
    $newer = GeneratedImage::factory()->for($theme, 'theme')->create(['generated_photo_path' => 'photobooth/newer.png']);

    $photos = Livewire::test('pages::slideshow')->get('photos');

    expect($photos)->toHaveCount(2)
        ->and($photos[0])->toMatchArray([
            'id' => $newer->id,
            'url' => 'https://booth.test/storage/photobooth/newer.png',
            'theme' => 'Seoul Winter',
        ])
        ->and($photos[1]['id'])->toBe($older->id);
});

test('photos that cannot be shown are left out', function (Closure $makeHiddenPhoto) {
    createBoothTables();
    $makeHiddenPhoto();

    expect(Livewire::test('pages::slideshow')->get('photos'))->toBeEmpty();
})->with([
    'failed generation' => fn () => fn () => GeneratedImage::factory()->failed()->create(),
    'deleted by retention' => fn () => fn () => GeneratedImage::factory()->deleted()->create(),
    'no photo file' => fn () => fn () => GeneratedImage::factory()->create(['generated_photo_path' => null]),
]);

test('only the configured number of photos is shown', function () {
    createBoothTables();
    config(['slideshow.photo_limit' => 2]);
    GeneratedImage::factory()->count(3)->recycle(PhotoshootTheme::factory()->create())->create();

    expect(Livewire::test('pages::slideshow')->get('photos'))->toHaveCount(2);
});

test('a photo stored as a full url is used as is', function () {
    createBoothTables();
    GeneratedImage::factory()->create(['generated_photo_path' => 'https://cdn.example.com/photo.png']);

    expect(Livewire::test('pages::slideshow')->get('photos.0.url'))->toBe('https://cdn.example.com/photo.png');
});

test('polling picks up photos generated after the page loaded', function () {
    createBoothTables();
    $slideshow = Livewire::test('pages::slideshow');
    $photo = GeneratedImage::factory()->create();

    $slideshow->call('loadPhotos');

    expect($slideshow->get('photos.0.id'))->toBe($photo->id);
});

test('only active themes are listed', function () {
    createBoothTables();
    PhotoshootTheme::factory()->create(['theme_name' => 'Street Racing']);
    PhotoshootTheme::factory()->inactive()->create(['theme_name' => 'Malay Warrior']);

    Livewire::test('pages::slideshow')->assertSet('themeNames', ['Street Racing']);
});

test('the slideshow still loads when the booth database is unreachable', function () {
    $this->get(route('home'))
        ->assertOk()
        ->assertSee('Welcome to RupaVue');
});
