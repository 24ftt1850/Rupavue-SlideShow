<?php

use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;

beforeEach(function () {
    config([
        'slideshow.theme_photos_folder_id' => 'themes-folder',
        'slideshow.latest_photos_folder' => null,
        'services.google_drive.api_key' => 'test-key',
    ]);
});

test('the themes slide shows the images in the google drive folder', function () {
    Http::fake([
        'www.googleapis.com/drive/v3/files*' => Http::response(['files' => [
            ['id' => 'anime-id', 'name' => 'anime.jpg'],
            ['id' => 'warrior-id', 'name' => 'warrior.jpg'],
        ]]),
    ]);

    $this->get('/')
        ->assertOk()
        ->assertSee('https://drive.google.com/thumbnail?id=anime-id&amp;sz=w1000', false)
        ->assertSee('https://drive.google.com/thumbnail?id=warrior-id&amp;sz=w1000', false);

    Http::assertSent(fn (Request $request): bool => $request['q'] === "'themes-folder' in parents and mimeType contains 'image/' and trashed = false"
        && $request['key'] === 'test-key');
});

test('the folder listing is cached between page loads', function () {
    Http::fake(['www.googleapis.com/*' => Http::response(['files' => []])]);

    $this->get('/')->assertOk();
    $this->get('/')->assertOk();

    Http::assertSentCount(1);
});

test('the showcase still loads when google drive cannot be reached', function () {
    Http::fake(['www.googleapis.com/*' => Http::response([], 403)]);

    $this->get('/')
        ->assertOk()
        ->assertDontSee('drive.google.com/thumbnail');
});

test('google drive is not called until the folder and api key are set', function () {
    config(['services.google_drive.api_key' => null]);
    Http::fake();

    $this->get('/')->assertOk();

    Http::assertNothingSent();
});
