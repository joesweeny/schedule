# Schedule
An extremely lightweight library to create and filter console based commands that can be run on a schedule

# Usage

Individual tasks can be instantiated with or without arguments
```php
use JoeSweeny\Schedule\Task;

$task1 = new Task('delete:files');

$task2 = new Task('notify:users', ['--admin']);
```

When instantiated a Tasks frequency can be added to let the Schedule know when the Task is required to run
```php
use JoeSweeny\Schedule\Task;

$task1 = new Task('delete:files');

// Task will run every Monday at 00:00
$task1->weekly();

Additional frequency methods can be chained to the Task to be more specific

$task2 = new Task('notify:users', ['--admin']);

// Task will run every Wednesday at 09:00AM
$task2->wednesdays()->at('09:00');
```

Individual Tasks can be added to a Schedule
```php
use JoeSweeny\Schedule\Task;
use JoeSweeny\Schedule\Schedule;

$task1 = (new Task('delete:files'))->sundays();

$task2 = new Task('notify:users', ['--admin']);

$schedule = new Schedule;

$schedule->addTask($task1)->addTask($task2);

$schedule->getTasks() // Will return [(new Task('delete:files'))->sundays(), new Task('notify:users', ['--admin'])] 
``` 