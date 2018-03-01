<?php

namespace JoeSweeny\Schedule\Entity;

class Cron
{
    /**
     * The cron expression describing the Command frequency
     *
     * @var string
     */
    protected $expression = '* * * * * *';

    public function getExpression(): string
    {
        return $this->expression;
    }

    public function hourly(): Cron
    {
        $this->expression = '0 * * * *';

        return $this;
    }

    public function daily(): Cron
    {
        $this->expression = '0 0 * * * *';

        return $this;
    }

    public function monthly(): Cron
    {
        $this->expression = '0 0 1 * *';

        return $this;
    }
}
