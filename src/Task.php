<?php

namespace JoeSweeny\Schedule;

use Cron\CronExpression;

class Task extends Cron
{
    /**
     * @var string
     *  The text representation of the command used to execute via the terminal i.e. 'user:create'
     */
    private $command;

    /**
     * @var array
     *  Additional arguments may be required to execute the command, to be provided as individual
     *  array elements ['--first_name=Joe', '--last_name=Sweeny']
     */
    private $arguments;

    public function __construct(string $command, array $arguments = [])
    {
        $this->command = $command;
        $this->arguments = $arguments;
    }

    public function getCommand(): string
    {
        return $this->command;
    }

    public function getArguments(): array
    {
        return $this->arguments;
    }

    public function isDue(): bool
    {
        return CronExpression::factory($this->expression)->isDue();
    }

    public function nextRunDate(): \DateTime
    {
        return CronExpression::factory($this->expression)->getNextRunDate();
    }

    public function execute(): string
    {
        return trim($this->command . ' ' . $this->formatArguments());
    }

    private function formatArguments(): string
    {
        $arguments = '';

        foreach ($this->arguments as $key => $value) {
            if (is_int($key)) {
                $arguments .= "'{$value}' ";
                continue;
            }

            $arguments .= "{$key}='{$value}' ";
        }

        return $arguments;
    }
}
