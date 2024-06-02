<?php

namespace App\Repository;

use App\Service\MarkdownWithMetaParser;

class SongRepository {
    public function listSongs(): array {
        $files = glob(self::getSongDirectory() . '/*.md');
        $songs = [];

        foreach ($files as $file) {
            $content = file_get_contents($file);

            if ($content === false) {
                continue;
            }

            $metaData = MarkdownWithMetaParser::getMetaData($content);

            $songs[] = [
                'fileName' => pathinfo($file, PATHINFO_FILENAME),
                'title' => $metaData['title'] ?? null,
            ];
        }

        return $songs;
    }

    public static function getSongDirectory(): string {
        return dirname(__DIR__, 2) . '/content/songs/';
    }
}
