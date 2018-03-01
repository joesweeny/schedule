<?php

namespace JoeSweeny\Schedule;

use Cron\CronExpression;

class Task
{
    /**
     * The cron expression describing the Task frequency
     *
     * @var string
     */
    protected $expression = '* * * * *';

    /**
     * @var string
     */
    private $command;

    /**
     * @var array
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

    public function getExpression(): string
    {
        return $this->expression;
    }

    public function execute(): string
    {
        return trim($this->command . ' ' . implode(' ', $this->arguments));
    }

    public function hourly(): self
    {
        $this->expression = '0 * * * *';

        return $this;
    }

    public function daily(): self
    {
        $this->expression = '0 0 * * *';

        return $this;
    }

    public function weekly(): self
    {
        $this->expression = '0 0 * * 0';

        return $this;
    }

    public function monthly(): self
    {
        $this->expression = '0 0 1 * *';

        return $this;
    }

    /**
     * @param string $time
     *  Time task to run at in format HH:MM i.e. '10:35'
     * @return Task
     */
    public function dailyAt(string $time): self
    {
        $time = explode(':', $time);

        return $this->injectionIntoExpression(2, (int) $time[0])
            ->injectionIntoExpression(1, count($time) === 2 ? (int) $time[1] : '0');
    }

    /**
     * @param string $time
     *  At a specific time in format HH:MM i.e. '08:00'
     * @return Task
     */
    public function at(string $time): self
    {
        $this->dailyAt($time);

        return $this;
    }

    public function mondays(): self
    {
        return $this->injectionIntoExpression(5, '1')->midnight();
    }

    public function tuesdays(): self
    {
        return $this->injectionIntoExpression(5, '2')->midnight();
    }

    public function wednesdays(): self
    {
        return $this->injectionIntoExpression(5, '3')->midnight();
    }

    public function thursdays(): self
    {
        return $this->injectionIntoExpression(5, '4')->midnight();
    }

    public function fridays(): self
    {
        return $this->injectionIntoExpression(5, '5')->midnight();
    }

    public function saturdays(): self
    {
        return $this->injectionIntoExpression(5, '6')->midnight();
    }

    public function sundays(): self
    {
        return $this->injectionIntoExpression(5, '0')->midnight();
    }

    private function midnight(): self
    {
        return $this->injectionIntoExpression(1, '0')
            ->injectionIntoExpression(2, '0');
    }

    private function injectionIntoExpression($position, $value)
    {
        $breakdown = explode(' ', $this->expression);

        $breakdown[$position - 1] = $value;

        $this->expression = implode(' ', $breakdown);

        return $this;
    }
}
