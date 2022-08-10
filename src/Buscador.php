<?php

namespace Folb\BuscadorDeCursos;

use GuzzleHttp\ClientInterface;
use Symfony\Component\DomCrawler\Crawler;

class Buscador
{
    /**
     * @var Crawler
     */
    private Crawler $crawler;
    /**
     * @var ClientInterface
     */
    private ClientInterface $httpClient;

    /**
     * @param ClientInterface $httpClient
     * @param Crawler $crawler
     */
    public function __construct(ClientInterface $httpClient, Crawler $crawler)
    {
        $this->crawler = $crawler;
        $this->httpClient = $httpClient;
    }

    public function buscar(string $url): array
    {
        $resposta = $this->httpClient
            ->request('GET', $url);
        $this->crawler->addHtmlContent(content: $resposta->getBody());

        $elementosCursos = $this->crawler->filter('span.card-curso__nome');
        $cursos = [];

        foreach ($elementosCursos as $elementosCurso) {
            $cursos[] = $elementosCurso->textContent;
        }

        return $cursos;
    }
}
