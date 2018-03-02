<?php

namespace JoeSweeny\Schedule;

use PHPUnit\Framework\TestCase;

class CronTest extends TestCase
{
    public function test_cron_expressions()
    {
        $this->assertEquals('* * * * *', (new Cron)->getExpression());
        $this->assertEquals('0 * * * *', (new Cron)->hourly()->getExpression());
        $this->assertEquals('0 0 * * *', (new Cron)->daily()->getExpression());
        $this->assertEquals('0 0 * * 0', (new Cron)->weekly()->getExpression());
        $this->assertEquals('0 0 1 * *', (new Cron)->monthly()->getExpression());
        $this->assertEquals('50 10 * * *', (new Cron)->dailyAt('10:50')->getExpression());
        $this->assertEquals('0 0 * * 1', (new Cron)->mondays()->getExpression());
        $this->assertEquals('0 0 * * 2', (new Cron)->tuesdays()->getExpression());
        $this->assertEquals('0 0 * * 3', (new Cron)->wednesdays()->getExpression());
        $this->assertEquals('0 0 * * 4', (new Cron)->thursdays()->getExpression());
        $this->assertEquals('0 0 * * 5', (new Cron)->fridays()->getExpression());
        $this->assertEquals('0 0 * * 6', (new Cron)->saturdays()->getExpression());
        $this->assertEquals('0 0 * * 0', (new Cron)->sundays()->getExpression());
        $this->assertEquals('0 9 * * 1', (new Cron)->mondays()->at('09:00')->getExpression());
    }
}
