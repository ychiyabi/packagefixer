<?php

namespace App\Event;

use Symfony\Contracts\EventDispatcher\Event;

class JsonTexterEvent extends Event
{
    public const NAME = 'JsonTexterEvent';
    private $text;
    private $php;
    private $os;
    private int $composer;

    public function __construct(string $text, $os, $php)
    {
        $this->text = $text;
        $this->os = $os;
        $this->php = $php;
    }

    public function getText(): string
    {
        return $this->text;
    }


    /**
     * Get the value of os
     */
    public function getOs()
    {
        return $this->os;
    }

    /**
     * Get the value of php
     */
    public function getPhp()
    {
        return $this->php;
    }

    /**
     * Get the value of composer
     */
    public function getComposer()
    {
        return $this->composer;
    }

    /**
     * Set the value of composer
     *
     * @return  self
     */
    public function setComposer($composer)
    {
        $this->composer = $composer;

        return $this;
    }
}
