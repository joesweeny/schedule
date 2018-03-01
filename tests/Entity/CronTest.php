<?php

namespace JoeSweeny\Schedule\Entity;

use PHPUnit\Framework\TestCase;

class CronTest extends TestCase
{
    public function test_expressions()
    {
        $cron = new Cron;

        $this->assertEquals('* * * * *', $cron->getExpression());
        $this->assertEquals('0 * * * *', $cron->hourly()->getExpression());
        $this->assertEquals('0 0 * * *', $cron->daily()->getExpression());
        $this->assertEquals('0 0 1 * *', $cron->monthly()->getExpression());
    }
}
