<?php

namespace App\Http\Controllers;

use App\Services\GoogleDriveFolder;
use Illuminate\Http\JsonResponse;

class ShowcasePhotoController extends Controller
{
    /**
     * The newest photos in the booth's Google Drive folder, newest first.
     * Polled by the showcase screen so it can pop up any photo added after
     * the page loaded. If Drive is not set up or unreachable a 503 is
     * returned, so the screen keeps its last known photos rather than
     * treating every photo as new once Drive is back.
     */
    public function __invoke(GoogleDriveFolder $driveFolder): JsonResponse
    {
        $photos = $driveFolder->tryImages(
            config('slideshow.latest_photos_folder'),
            config('slideshow.latest_photos_cache_seconds'),
            GoogleDriveFolder::NEWEST_FIRST,
            config('slideshow.latest_photos_limit'),
        );

        if ($photos === null) {
            return response()->json(['photos' => []], 503);
        }

        return response()->json(['photos' => array_map(fn (array $photo): array => [
            'id' => $photo['id'],
            'url' => $photo['url'],
        ], $photos)]);
    }
}
