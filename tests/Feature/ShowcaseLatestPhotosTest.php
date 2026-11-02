<?php

use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;

beforeEach(function () {
    config([
        'slideshow.theme_photos_folder_id' => null,
        'slideshow.latest_photos_folder' => 'https://drive.google.com/drive/folders/booth-folder?usp=sharing',
        'slideshow.latest_photos_limit' => 10,
        'services.google_drive.api_key' => 'test-key',
    ]);
});

test('the latest generated slide shows the newest photos from the booth folder', function () {
    Http::fake([
        'www.googleapis.com/drive/v3/files*' => Http::response(['files' => [
            ['id' => 'newest-id', 'name' => 'IMG_0002.png'],
            ['id' => 'older-id', 'name' => 'IMG_0001.png'],
        ]]),
    ]);

    $this->get('/')
        ->assertOk()
        ->assertSeeInOrder([
            'rv-photo-stack-left',
            'https://drive.google.com/thumbnail?id=newest-id&amp;sz=w1000',
            'rv-photo-stack-right',
            'https://drive.google.com/thumbnail?id=older-id&amp;sz=w1000',
        ], false)
        ->assertDontSee('New photos from the booth will appear here.');

    Http::assertSent(fn (Request $request): bool => $request['q'] === "'booth-folder' in parents and mimeType contains 'image/' and trashed = false"
        && $request['orderBy'] === 'createdTime desc'
        && $request['pageSize'] === 10);
});

test('the latest generated slide says photos are coming when the folder has none', function () {
    config(['slideshow.latest_photos_folder' => null]);
    Http::fake();

    $this->get('/')
        ->assertOk()
        ->assertSee('New photos from the booth will appear here.');

    Http::assertNothingSent();
});

test('a folder that is not a drive id or link is never sent to google', function () {
    config(['slideshow.latest_photos_folder' => "x' or name contains '"]);
    Http::fake();

    $this->get('/')->assertOk();

    Http::assertNothingSent();
});
