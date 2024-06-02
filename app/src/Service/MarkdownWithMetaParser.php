<?php

namespace App\Service;

use Exception;
use Symfony\Component\Yaml\Yaml;

class MarkdownWithMetaParser {
    private MarkdownParser $markdownParser;

    public function __construct() {
        $this->markdownParser = new MarkdownParser();
    }

    public function parseFile(string $filePath): array {
        try {
            $content = file_get_contents($filePath);
        } catch (Exception $e) {
            return [
                'meta' => null,
                'html' => 'This Song does not exist',
            ];
        }

        ['meta' => $meta, 'markdown' => $markdown] = self::separateMetaFromMarkdown($content);

        $metaArray = $meta ? Yaml::parse($meta) : [];
        $html = $this->markdownParser->parse($markdown);

        return [
            'meta' => $metaArray,
            'html' => $html,
        ];
    }

    public static function separateMetaFromMarkdown(string $content): array {
        preg_match('/^-{3}(.*?)-{3}(.*)/s', $content, $matches);

        $meta = null;
        $markdown = null;

        if ($matches) {
            $meta = $matches[1];
            $markdown = $matches[2];
        } else {
            $markdown = $content;
        }

        return [
            'meta' => $meta,
            'markdown' => $markdown,
        ];
    }

    public static function getMetaData($content): array {
        $meta = self::separateMetaFromMarkdown($content)['meta'];
        return Yaml::parse($meta);
    }
}
