<?php

namespace RenfeBot\Application\Service\Schedule;

use RenfeBot\Domain\Service\Schedule\Parser;

final class SearchSchedule
{
    private $parser;

    public function __construct(Parser $aParser)
    {
        $this->parser = $aParser;
    }

    public function __invoke(SearchScheduleRequest $aRequest)
    {
        $schedule = $this->parser->__invoke($aRequest->origin(), $aRequest->destination(), $aRequest->date());
    }
}
