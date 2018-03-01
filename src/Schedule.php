<?php

namespace JoeSweeny\Schedule;

class Schedule
{
    private $tasks = [];

    private $dueTasks = [];

    public function addTask(Task $task): Schedule
    {
        $this->tasks[] = $task;

        return $this;
    }

    public function getTasks(): array
    {
        return $this->tasks;
    }

    public function getDueTasks(): array
    {
        foreach ($this->tasks as $task) {
            if ($task->isDue()) {
                $this->dueTasks[] = $task;
            }
        }

        return $this->dueTasks;
    }
}
