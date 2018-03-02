<?php

namespace JoeSweeny\Schedule;

class Schedule
{
    private $tasks = [];

    private $dueTasks = [];

    public function addTask($task): Schedule
    {
        $this->tasks[] = $task;

        return $this;
    }

    /**
     * @return array|Task[]
     *  An array of all Task objects added to this Schedule
     */
    public function getTasks(): array
    {
        return $this->tasks;
    }

    /**
     * @return array|Task[]
     *  A filtered array of Task objects that are due to be executed
     */
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
