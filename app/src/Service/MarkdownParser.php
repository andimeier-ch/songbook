<?php


namespace App\Service;


use Exception;
use League\CommonMark\CommonMarkConverter;
use Symfony\Component\Yaml\Yaml;

class MarkdownParser {
    private $parser;

    public function __construct() {
        $this->parser = new CommonMarkConverter();
    }

    private function parseMarkdown(string $markdown): string {
        return $this->parser->convert($markdown);
    }

    private function parseYaml(string $yaml): array {
        return Yaml::parse($yaml);
    }

    private function separateFrontMatterFromMarkdown(string $content): array {
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

    public function parseFile(string $filePath): array {
        try {
            $content = file_get_contents($filePath);
        } catch (Exception $e) {
            return [
                'meta' => null,
                'html' => 'Song not found',
            ];
        }

        ['meta' => $meta, 'markdown' => $markdown] = $this->separateFrontMatterFromMarkdown($content);

        $metaArray = $meta ? $this->parseYaml($meta) : [];
        $html = $this->parseMarkdown($markdown);

        return [
            'meta' => $metaArray,
            'html' => $html,
        ];
    }
}
