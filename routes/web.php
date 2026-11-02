<?php

use App\Http\Controllers\ShowcasePhotoController;
use App\Services\GoogleDriveFolder;
use Illuminate\Support\Facades\Route;

Route::get('/', function (GoogleDriveFolder $driveFolder) {
    return view('showcase.index', [
        'themePhotos' => $driveFolder->images(
            config('slideshow.theme_photos_folder_id'),
            config('slideshow.theme_photos_cache_seconds'),
        ),
        'latestPhotos' => $driveFolder->images(
            config('slideshow.latest_photos_folder'),
            config('slideshow.latest_photos_cache_seconds'),
            GoogleDriveFolder::NEWEST_FIRST,
            config('slideshow.latest_photos_limit'),
        ),
    ]);
});

Route::get('/showcase/photos', ShowcasePhotoController::class)->name('showcase.photos');
