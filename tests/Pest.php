<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

/*
|--------------------------------------------------------------------------
| Test Case
|--------------------------------------------------------------------------
|
| The closure you provide to your test functions is always bound to a specific PHPUnit test
| case class. By default, that class is "PHPUnit\Framework\TestCase". Of course, you may
| need to change it using the "pest()" function to bind different classes or traits.
|
*/

pest()->extend(TestCase::class)
    ->use(RefreshDatabase::class)
    ->in('Feature');

/*
|--------------------------------------------------------------------------
| Expectations
|--------------------------------------------------------------------------
|
| When you're writing tests, you often need to check that values meet certain conditions. The
| "expect()" function gives you access to a set of "expectations" methods that you can use
| to assert different things. Of course, you may extend the Expectation API at any time.
|
*/

expect()->extend('toBeOne', function () {
    return $this->toBe(1);
});

/*
|--------------------------------------------------------------------------
| Functions
|--------------------------------------------------------------------------
|
| While Pest is very powerful out-of-the-box, you may have some testing code specific to your
| project that you don't want to repeat in every file. Here you can also expose helpers as
| global functions to help you to reduce the number of lines of code in your test files.
|
*/

function something()
{
    // ..
}

/**
 * The booth owns these tables, so this app has no migrations for them.
 * Build the columns the slideshow reads.
 */
function createBoothTables(): void
{
    Schema::create('photoshoot_themes', function (Blueprint $table) {
        $table->id();
        $table->string('theme_name');
        $table->text('description')->nullable();
        $table->text('prompt_prefix');
        $table->boolean('is_active')->default(true);
        $table->timestamps();
    });

    Schema::create('generated_images', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('photo_session_id');
        $table->foreignId('theme_id');
        $table->text('final_prompt_used');
        $table->string('generation_status')->default('success');
        $table->string('generated_photo_path')->nullable();
        $table->boolean('is_deleted')->default(false);
        $table->timestamp('created_at')->nullable();
    });
}
