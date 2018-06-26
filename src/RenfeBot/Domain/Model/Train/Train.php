<?php

namespace RenfeBot\Domain\Model\Train;

final class Train
{
    private $type; //Regional - MD
    private $code; // Num.

    public function __construct(string $aType, int $aCode)
    {
        $this->type = $aType;
        $this->code = $aCode;
    }

    public function type(): string
    {
        return $this->type;
    }

    public function code(): int
    {
        return $this->code;
    }
}
