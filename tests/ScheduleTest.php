<?php

namespace JoeSweeny\Schedule;

use PHPUnit\Framework\TestCase;

class ScheduleTest extends TestCase
{
    public function test_tasks_can_be_added_to_schedule()
    {
        $schedule = new Schedule;

        $schedule->addTask(new Task('new:task1'))
            ->addTask(new Task('new:task2'))
            ->addTask(new Task('new:task3'));

        $this->assertCount(3, $schedule->getTasks());
    }

    public function test_due_tasks_can_be_filtered()
    {
        $schedule = new Schedule;

        $schedule->addTask(new Task('new:task1'))
            ->addTask((new Task('new:task2'))->at((new \DateTimeImmutable)->format('H:i')))
            ->addTask((new Task('new:task3'))->monthly())
            ->addTask((new Task('new:task4'))->wednesdays())
            ->addTask((new Task('new:task5'))->weekly())
            ->addTask((new Task('new:task6'))->daily())
            ->addTask(new Task('new:task7'));

        $this->assertCount(3, $schedule->getDueTasks());

        $this->assertEquals('new:task1', $schedule->getDueTasks()[0]->execute());
        $this->assertEquals('new:task2', $schedule->getDueTasks()[1]->execute());
        $this->assertEquals('new:task7', $schedule->getDueTasks()[2]->execute());
    }
}
