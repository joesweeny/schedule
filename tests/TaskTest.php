<?php

namespace JoeSweeny\Schedule;

use PHPUnit\Framework\TestCase;

class TaskTest extends TestCase
{
    public function test_task_construction()
    {
        $task = new Task('task:run', ['-no interfaction', '-vvv']);

        $this->assertEquals('task:run', $task->getCommand());
        $this->assertEquals(['-no interfaction', '-vvv'], $task->getArguments());
        $this->assertEquals('task:run -no interfaction -vvv', $task->execute());
    }

    public function test_cron_expressions()
    {
        $this->assertEquals('* * * * *', (new Task('task:run'))->getExpression());
        $this->assertEquals('0 * * * *', (new Task('task:run'))->hourly()->getExpression());
        $this->assertEquals('0 0 * * *', (new Task('task:run'))->daily()->getExpression());
        $this->assertEquals('0 0 * * 0', (new Task('task:run'))->weekly()->getExpression());
        $this->assertEquals('0 0 1 * *', (new Task('task:run'))->monthly()->getExpression());
        $this->assertEquals('50 10 * * *', (new Task('task:run'))->dailyAt('10:50')->getExpression());
        $this->assertEquals('0 0 * * 1', (new Task('task:run'))->mondays()->getExpression());
        $this->assertEquals('0 0 * * 2', (new Task('task:run'))->tuesdays()->getExpression());
        $this->assertEquals('0 0 * * 3', (new Task('task:run'))->wednesdays()->getExpression());
        $this->assertEquals('0 0 * * 4', (new Task('task:run'))->thursdays()->getExpression());
        $this->assertEquals('0 0 * * 5', (new Task('task:run'))->fridays()->getExpression());
        $this->assertEquals('0 0 * * 6', (new Task('task:run'))->saturdays()->getExpression());
        $this->assertEquals('0 0 * * 0', (new Task('task:run'))->sundays()->getExpression());
        $this->assertEquals('0 9 * * 1', (new Task('tasl:run'))->mondays()->at('09:00')->getExpression());
    }

    public function test_is_due()
    {
        $this->assertTrue((new Task('task:run', ['-no interfaction', '-vvv']))->isDue());

        $task = new Task('task:run', ['-no interfaction', '-vvv']);

        $this->assertTrue($task->isDue());
    }
}
