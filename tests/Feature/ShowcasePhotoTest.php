<?php

use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;

beforeEach(function () {
    config([
        'slideshow.theme_photos_folder_id' => null,
        'slideshow.latest_photos_folder' => 'booth-folder',
        'slideshow.latest_photos_limit' => 10,
        'services.google_drive.api_key' => 'test-key',
    ]);
});

test('the newest photos in the booth folder are returned newest first', function () {
    Http::fake([
        'www.googleapis.com/drive/v3/files*' => Http::response(['files' => [
            ['id' => 'newest-id', 'name' => 'IMG_0002.png'],
            ['id' => 'older-id', 'name' => 'IMG_0001.png'],
        ]]),
    ]);

    $this->getJson(route('showcase.photos'))
        ->assertOk()
        ->assertExactJson(['photos' => [
            ['id' => 'newest-id', 'url' => 'https://drive.google.com/thumbnail?id=newest-id&sz=w1000'],
            ['id' => 'older-id', 'url' => 'https://drive.google.com/thumbnail?id=older-id&sz=w1000'],
        ]]);

    Http::assertSent(fn (Request $request): bool => $request['orderBy'] === 'createdTime desc'
        && $request['pageSize'] === 10);
});

test('the folder is checked again once the short cache expires', function () {
    config(['slideshow.latest_photos_cache_seconds' => 5]);
    Http::fake(['www.googleapis.com/*' => Http::response(['files' => []])]);

    $this->getJson(route('showcase.photos'))->assertOk();
    $this->getJson(route('showcase.photos'))->assertOk();
    $this->travel(6)->seconds();
    $this->getJson(route('showcase.photos'))->assertOk();

    Http::assertSentCount(2);
});

test('an unreachable google drive is reported as unavailable', function () {
    Http::fake(['www.googleapis.com/*' => Http::response([], 500)]);

    $this->getJson(route('showcase.photos'))
        ->assertServiceUnavailable()
        ->assertExactJson(['photos' => []]);
});

test('a missing booth folder is reported as unavailable', function () {
    config(['slideshow.latest_photos_folder' => null]);
    Http::fake();

    $this->getJson(route('showcase.photos'))->assertServiceUnavailable();

    Http::assertNothingSent();
});

test('the showcase includes the new photo pop-up', function () {
    Http::fake(['www.googleapis.com/*' => Http::response(['files' => []])]);

    $this->get('/')
        ->assertOk()
        ->assertSee(route('showcase.photos'));
});
