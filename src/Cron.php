<?php

namespace JoeSweeny\Schedule;

class Cron
{
    /**
     * The cron expression describing the Task frequency
     *
     * @var string
     */
    protected $expression = '* * * * *';

    public function getExpression(): string
    {
        return $this->expression;
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
     * @return self
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
     * @return self
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

    private function injectionIntoExpression($position, $value): self
    {
        $breakdown = explode(' ', $this->expression);

        $breakdown[$position - 1] = $value;

        $this->expression = implode(' ', $breakdown);

        return $this;
    }
}
