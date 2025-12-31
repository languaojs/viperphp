<?php

namespace System\Console;

abstract class Command
{
    protected string $name;
    protected string $description;

    abstract public function execute($args);

    public function getName(): string { return $this->name; }
    public function getDescription(): string { return $this->description; }
}