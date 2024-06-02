<?php


namespace App\Service;


use Exception;
use League\CommonMark\CommonMarkConverter;
use Symfony\Component\Yaml\Yaml;

class MarkdownParser {
    private CommonMarkConverter $parser;

    public function __construct() {
        $this->parser = new CommonMarkConverter();
    }

    public function parse(string $markdown): string {
        $html = null;

        try {
            $html = $this->parser->convert($markdown);
        } catch (Exception $e) {
            $html = 'Song can not be parsed: ' . $e->getMessage();
        }

        return $html;
    }
}
