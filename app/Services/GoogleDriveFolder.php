<?php

namespace App\Services;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

/**
 * Lists the images in a publicly shared Google Drive folder, so the
 * showcase can display whatever photos the team drops into it.
 */
class GoogleDriveFolder
{
    private const FILES_ENDPOINT = 'https://www.googleapis.com/drive/v3/files';

    public const BY_NAME = 'name';

    public const NEWEST_FIRST = 'createdTime desc';

    /**
     * The folder's images. The folder may be given as its ID or as a share
     * link. If Drive is not configured or cannot be reached an empty list is
     * returned, and the failure is not cached so the next request tries again.
     *
     * @return list<array{id: string, name: string, url: string}>
     */
    public function images(
        ?string $folder,
        int $cacheSeconds,
        string $orderBy = self::BY_NAME,
        int $limit = 1000,
    ): array {
        return $this->tryImages($folder, $cacheSeconds, $orderBy, $limit) ?? [];
    }

    /**
     * Like images(), but returns null when Drive is not configured or cannot
     * be reached, so callers can tell a failure apart from an empty folder.
     *
     * @return list<array{id: string, name: string, url: string}>|null
     */
    public function tryImages(
        ?string $folder,
        int $cacheSeconds,
        string $orderBy = self::BY_NAME,
        int $limit = 1000,
    ): ?array {
        $folderId = $this->folderId($folder);
        $apiKey = config('services.google_drive.api_key');

        if (! $folderId || ! $apiKey) {
            return null;
        }

        try {
            return Cache::remember(
                "google-drive-folder.{$folderId}.{$orderBy}.{$limit}",
                $cacheSeconds,
                fn (): array => $this->fetchImages($folderId, $apiKey, $orderBy, $limit),
            );
        } catch (ConnectionException|RequestException $exception) {
            report($exception);

            return null;
        }
    }

    /**
     * Accepts a bare folder ID or a link such as
     * https://drive.google.com/drive/folders/{id}?usp=sharing.
     */
    private function folderId(?string $folder): ?string
    {
        $folder = trim((string) $folder);

        if (preg_match('#/folders/([A-Za-z0-9_-]+)#', $folder, $matches)
            || preg_match('#[?&]id=([A-Za-z0-9_-]+)#', $folder, $matches)) {
            return $matches[1];
        }

        return preg_match('/^[A-Za-z0-9_-]+$/', $folder) ? $folder : null;
    }

    /**
     * @return list<array{id: string, name: string, url: string}>
     *
     * @throws ConnectionException
     * @throws RequestException
     */
    private function fetchImages(string $folderId, string $apiKey, string $orderBy, int $limit): array
    {
        $files = Http::timeout(10)
            ->get(self::FILES_ENDPOINT, [
                'q' => "'{$folderId}' in parents and mimeType contains 'image/' and trashed = false",
                'fields' => 'files(id,name)',
                'orderBy' => $orderBy,
                'pageSize' => min($limit, 1000),
                'key' => $apiKey,
            ])
            ->throw()
            ->json('files', []);

        return array_map(fn (array $file): array => [
            'id' => $file['id'],
            'name' => $file['name'],
            'url' => 'https://drive.google.com/thumbnail?id='.urlencode($file['id']).'&sz=w1000',
        ], $files);
    }
}
