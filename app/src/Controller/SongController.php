<?php

namespace App\Controller;

use App\Service\MarkdownParser;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class SongController extends AbstractController {
    private $markdownParser;

    public function __construct(MarkdownParser $markdownParserService) {
        $this->markdownParser = $markdownParserService;
    }

    #[Route('/song/{name}', name: 'song')]
    public function showSong(string $name): Response {
        $projectRoot = dirname(__DIR__, 2);
        $songDirectory = $projectRoot . '/content/songs/';
        $filePath = $songDirectory . $name . '.md';

        ['meta' => $meta, 'html' => $content] = $this->markdownParser->parseFile($filePath);

        return $this->render('song/index.html.twig', [
            'controller_name' => 'SongController',
            'title' => $meta['title'] ?? null,
            'content' => $content,
        ]);
    }
}
