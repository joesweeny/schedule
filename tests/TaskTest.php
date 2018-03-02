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
        $this->assertEquals("task:run '-no interfaction' '-vvv'", $task->execute());

        $task = new Task('task:run', ['--message' => 'Run this task']);

        $this->assertEquals("task:run --message='Run this task'", $task->execute());

        $task = new Task('task:run', ['-f', '1984-03-12 12:00:00']);

        $this->assertEquals("task:run '-f' '1984-03-12 12:00:00'", $task->execute());
    }

    public function test_is_due()
    {
        $this->assertTrue((new Task('task:run', ['-no interfaction', '-vvv']))->isDue());

        $task = new Task('task:run', ['-no interfaction', '-vvv']);

        $this->assertTrue($task->isDue());
    }
}
