<?php


namespace App\Service;


use League\CommonMark\CommonMarkConverter;

class MarkdownParser {
    private $parser;

    public function __construct() {
        $this->parser = new CommonMarkConverter();
    }

    public function parse(string $markdown): string {
        return $this->parser->convert($markdown);
    }

    public function parseFile(string $filePath): string {
        $markdown = file_get_contents($filePath);
        return $this->parse($markdown);
    }
}
