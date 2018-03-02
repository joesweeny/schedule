# Schedule
An extremely lightweight library to create and filter console based commands that can be run on a schedule

# Usage

Individual tasks can be instantiated with or without arguments
```php
use JoeSweeny\Schedule\Task;

$task1 = new Task('delete:files');

$task2 = new Task('notify:users', ['--admin']);
```

When instantiated a Task's frequency can be added to let the Schedule know when the Task is required to run
```php
use JoeSweeny\Schedule\Task;

$task1 = new Task('delete:files');

// Task will run every Monday at 00:00
$task1->weekly();

// Additional frequency methods can be chained to the Task to be more specific

$task2 = new Task('notify:users', ['--admin']);

// Task will run every Wednesday at 09:00AM
$task2->wednesdays()->at('09:00');

// Note any Task without a frequency specified will automatically run every minute of every day
```

Individual Tasks can be added to a Schedule
```php
use JoeSweeny\Schedule\Task;
use JoeSweeny\Schedule\Schedule;

$task1 = (new Task('delete:files'))->sundays();

$task2 = new Task('notify:users', ['--admin']);

$schedule = new Schedule;

$schedule->addTask($task1)->addTask($task2);

$schedule->getTasks() 
// Will return [(new Task('delete:files'))->sundays(), new Task('notify:users', ['--admin'])] 
``` 

Once a Schedule has Tasks, the Tasks can be filtered on Tasks that are currently due to run
```php
use JoeSweeny\Schedule\Task;
use JoeSweeny\Schedule\Schedule;

$task1 = (new Task('delete:files'))->sundays();

$task2 = new Task('notify:users', ['--admin']);

$schedule = new Schedule;

$schedule->addTask($task1)->addTask($task2);

$schedule->getDueTasks();
// Will return an array of Task objects ready to be executed
```

Once due Tasks are filtered they can be individually executed by the consuming application. The example uses
Symfony Console as an example although other libraries can be used
```php
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Input\StringInput;
use Symfony\Component\Console\Output\BufferedOutput;
use JoeSweeny\Schedule\Task;
use JoeSweeny\Schedule\Schedule;

$schedule = new Schedule;

$application = new Application('CLI Application');

$schedule
    ->addTask((new Task('delete:files'))->sundays())
    ->addTask(new Task('notify:users', ['--admin']));

$due = $schedule->getDueTasks();

foreach($due as $task) {
    $application->run(new StringInput($task->execute()), $output = new BufferedOutput);
}
```