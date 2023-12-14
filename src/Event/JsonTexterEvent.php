<?php

namespace App\Event;

use Symfony\Contracts\EventDispatcher\Event;

class JsonTexterEvent extends Event
{
    public const NAME = 'JsonTexterEvent';
    private $text;

    public function __construct(string $text)
    {
        $this->text = $text;
    }

    public function getText(): string
    {
        return $this->text;
    }
}
