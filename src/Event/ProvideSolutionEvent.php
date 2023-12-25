<?php

namespace App\Event;

use App\Entity\Composer;
use Symfony\Contracts\EventDispatcher\Event;

class ProvideSolutionEvent extends Event
{
    public const NAME = 'ProvideSolutionEvent';
    private Composer $composer;

    public function __construct(Composer $composer)
    {
        $this->composer = $composer;
    }



    /**
     * Get the value of composer
     */
    public function getComposer()
    {
        return $this->composer;
    }
}
