<?php

namespace App\Models;

use Database\Factories\PhotoshootThemeFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * A booth theme (the scene the AI renders the guest into). Read-only here.
 *
 * @property int $id
 * @property string $theme_name
 * @property string|null $description
 * @property bool $is_active
 */
class PhotoshootTheme extends Model
{
    /** @use HasFactory<PhotoshootThemeFactory> */
    use HasFactory;

    protected $guarded = ['id'];

    public function getConnectionName(): ?string
    {
        return config('slideshow.connection');
    }

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }
}
