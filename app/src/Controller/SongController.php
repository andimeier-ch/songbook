<?php

namespace App\Controller;

use App\Repository\SongRepository;
use App\Service\MarkdownWithMetaParser;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class SongController extends AbstractController {
    private MarkdownWithMetaParser $markdownWithMetaParser;

    public function __construct(MarkdownWithMetaParser $markdownParserService) {
        $this->markdownWithMetaParser = $markdownParserService;
    }

    #[Route('/song/{name}', name: 'show_song')]
    public function showSong(string $name): Response {
        $songDirectory = SongRepository::getSongDirectory();
        $filePath = $songDirectory . $name . '.md';

        ['meta' => $meta, 'html' => $content] = $this->markdownWithMetaParser->parseFile($filePath);

        return $this->render('song/show.html.twig', [
            'title' => $meta['title'] ?? null,
            'artist' => $meta['artist'] ?? null,
            'copyright' => $meta['copyright'] ?? null,
            'content' => $content,
        ]);
    }

    #[Route('/songs', name: 'song_list')]
    public function listSongs(): Response {
        $songRepository = new SongRepository();
        $songs = $songRepository->listSongs();

        return $this->render('song/list.html.twig', ['songs' => $songs]);
    }
}
