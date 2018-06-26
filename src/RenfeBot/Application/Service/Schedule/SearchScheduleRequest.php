<?php

namespace RenfeBot\Application\Service\Schedule;

final class SearchScheduleRequest
{
    private $origin;
    private $destination;
    private $date;

    public function __construct(string $anOrigin, string $aDestination, \DateTimeImmutable $aDate)
    {
        $this->origin      = $anOrigin;
        $this->destination = $aDestination;
        $this->date        = $aDate->format('Y-m-d H:i:s');
    }

    public function origin(): string
    {
        return $this->origin;
    }

    public function destination(): string
    {
        return $this->destination;
    }

    public function date(): \DateTimeImmutable
    {
        return \DateTimeImmutable::createFromFormat('Y-m-d H:i:s', $this->date);
    }
}
