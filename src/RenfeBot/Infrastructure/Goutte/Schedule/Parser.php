<?php

namespace RenfeBot\Infrastructure\Goutte\Schedule;

use RenfeBot\Domain\Model\Train\Train;
use RenfeBot\Infrastructure\Goutte\ClientFactory;
use RenfeBot\Domain\Service\Schedule\Parser as ParserContract;
use Symfony\Component\DomCrawler\Crawler;

final class Parser implements ParserContract
{
    private const BASE_URL = 'http://horarios.renfe.com/HIRRenfeWeb/buscar.do';

    private $client;

    public function __construct(ClientFactory $aClientFactory)
    {
        $this->client = $aClientFactory->build();
    }

    public function __invoke(string $origin, string $destination, \DateTimeImmutable $aDate): array
    {
        //?O=BARCE&D=79303&ID=s&AF=2018&MF=3&DF=09&SF=5'
        $queryString = \http_build_query([
            'O' => 'BARCE',
            'D' => '79303',
            'ID' => 's',
            'AF' => 2018,
            'MF' => 3,
            'DF' => '10',
            'SF' => 5
        ]);

        $url = self::BASE_URL . '?' . $queryString;
        $crawler = $this->client->request('GET', $url);
        if (0 === $crawler->filter('form[name="form_horarios"]')->count())
        {
            return [];
        }

        $table = $crawler->filter('.txt_borde1');

        $allScheduleRows = $table->filter('tbody')->filter('tr');

        $travel = [];

        $result = $allScheduleRows->each(function(Crawler $currentRow) use (&$travel) {
            $columns = $currentRow->children();

            $result = $columns->each(function(Crawler $currentColumn, $colNum) {
                if (0 === $colNum)
                {
                    $rawTrain = trim($currentColumn->filter('a')->text());

                    preg_match('/([0-9]+)\s+([A-Z]+)/', $rawTrain, $matches);

                    [,$trainCode, $trainType] = $matches;
                    $train = new Train($trainType, $trainCode);

                    return $train;
                }
                elseif (1 === $colNum)
                {
                    $departAt = \DateTimeImmutable::createFromFormat('H.i', $currentColumn->text());
                    return $departAt;
                }
                elseif (2 === $colNum)
                {
                    $arrivalAt = \DateTimeImmutable::createFromFormat('H.i', $currentColumn->text());
                    return $arrivalAt;
                }
                elseif (3 === $colNum)
                {
                    $duration = $currentColumn->text();
                    return $duration;
                }
            });

            $travel[] =  ['train' => $result[0], 'depart_at' => $result[1], 'arrival_at' => $result[2], 'duration' => $result[3]];
        });


        dump($result);die;

    }
}
