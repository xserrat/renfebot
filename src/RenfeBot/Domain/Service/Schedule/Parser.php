<?php

namespace RenfeBot\Domain\Service\Schedule;

interface Parser
{
    public function __invoke(string $origin, string $destination, \DateTimeImmutable $aDate): array;
}
