<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Photo Source
    |--------------------------------------------------------------------------
    |
    | The database connection holding the booth's generated_images table, and
    | the booth app's public URL. Photo paths stored by the booth are relative
    | to its public disk, so they are served from "{booth_url}/storage/...".
    |
    */

    'connection' => env('SLIDESHOW_DB_CONNECTION', 'rupavue'),

    'booth_url' => env('SLIDESHOW_BOOTH_URL', 'https://ai-photo-booth-.test'),

    'photo_limit' => (int) env('SLIDESHOW_PHOTO_LIMIT', 20),

    /*
    |--------------------------------------------------------------------------
    | Theme Photos
    |--------------------------------------------------------------------------
    |
    | The "Themes Available" slide shows every image in this Google Drive
    | folder, and the "Latest Generated" slide shows the newest images in a
    | second folder. Each folder may be set as its ID or its share link. Share
    | them as "Anyone with the link" and set the API key in
    | services.google_drive. File lists are cached for the given number of
    | seconds, so new photos appear after at most that long.
    |
    */

    'theme_photos_folder_id' => env('SLIDESHOW_THEME_PHOTOS_FOLDER_ID'),

    'theme_photos_cache_seconds' => (int) env('SLIDESHOW_THEME_PHOTOS_CACHE_SECONDS', 300),

    'latest_photos_folder' => env('SLIDESHOW_LATEST_PHOTOS_FOLDER'),

    'latest_photos_limit' => (int) env('SLIDESHOW_LATEST_PHOTOS_LIMIT', 10),

    // Kept short because the screen checks this folder every few seconds.
    'latest_photos_cache_seconds' => (int) env('SLIDESHOW_LATEST_PHOTOS_CACHE_SECONDS', 5),

    /*
    |--------------------------------------------------------------------------
    | Timing
    |--------------------------------------------------------------------------
    |
    | How long each slide stays on screen, and how often the screen checks the
    | booth for newly generated photos (both in seconds).
    |
    */

    'slide_seconds' => (int) env('SLIDESHOW_SLIDE_SECONDS', 10),

    'refresh_seconds' => (int) env('SLIDESHOW_REFRESH_SECONDS', 15),

    /*
    |--------------------------------------------------------------------------
    | New Photo Pop-up
    |--------------------------------------------------------------------------
    |
    | The showcase pops up each photo added to the latest photos folder after
    | the page loaded, then adds it to the "Latest Generated" stacks. This is
    | how often it checks the folder and how long each pop-up stays on screen
    | (both in seconds).
    |
    */

    'new_photo_check_seconds' => (int) env('SLIDESHOW_NEW_PHOTO_CHECK_SECONDS', 5),

    'new_photo_seconds' => (int) env('SLIDESHOW_NEW_PHOTO_SECONDS', 10),

    /*
    |--------------------------------------------------------------------------
    | Description Slides
    |--------------------------------------------------------------------------
    |
    | The slides that introduce RupaVue between the photos. Each slide has an
    | eyebrow, a title, a body and optional numbered steps. Edit freely.
    |
    */

    'description_slides' => [
        [
            'eyebrow' => 'Welcome to RupaVue',
            'title' => 'Step in. Strike a pose. Become someone new.',
            'body' => 'RupaVue is an AI photo booth that turns one quick snapshot into a cinematic portrait — in seconds.',
            'steps' => [],
        ],
        [
            'eyebrow' => 'How it works',
            'title' => 'Five steps to your AI portrait',
            'body' => '',
            'steps' => [
                'Snap your photo at the booth',
                'Pick a scene from our themes',
                'Choose a frame',
                'Our AI creates your portrait',
                'Scan the QR code to take it home',
            ],
        ],
        [
            'eyebrow' => 'Take it home',
            'title' => 'Download it. Print it. Share it.',
            'body' => 'Scan your personal QR code to download your photo, or print a copy on the spot to keep.',
            'steps' => [],
        ],
    ],

];
