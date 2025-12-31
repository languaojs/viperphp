<?php

namespace System\Console;

class Kernel
{
    protected array $commands = [];

    public function registerCommand(Command $command)
    {
        $this->commands[$command->getName()] = $command;
    }

    public function handle($argv)
    {
        $commandName = $argv[1] ?? null;

        if (!$commandName || $commandName === 'list') {
            $this->listCommands();
            return;
        }

        if (!isset($this->commands[$commandName])) {
            echo "Command '{$commandName}' not found.\n";
            return;
        }

        // Pass everything after the command name as arguments
        $this->commands[$commandName]->execute(array_slice($argv, 2));
    }

    protected function listCommands()
    {
        echo "Viper Framework - Craft Tool\n";
        echo "Usage: php craft [command] [args]\n\n";
        foreach ($this->commands as $name => $cmd) {
            echo sprintf(" %-20s %s\n", $name, $cmd->getDescription());
        }
    }
}