<?php

namespace Indatus\Dispatcher;

/**
 * This file is part of Dispatcher
 *
 * (c) Ben Kuhl <bkuhl@indatus.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
use Indatus\Dispatcher\Scheduling\ScheduledCommandInterface;
use Indatus\Dispatcher\Services\CommandService;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class BackgroundProcessRunner
{
    /**
     * @var \Indatus\Dispatcher\Services\CommandService
     */
    private $commandService;

    public function __construct(CommandService $commandService)
    {
        $this->commandService = $commandService;
    }

    /**
     * Run a scheduled command
     *
     * @param \Indatus\Dispatcher\Scheduling\ScheduledCommandInterface  $scheduledCommand
     * @param array                                                     $arguments
     * @param array                                                     $options
     * @return bool
     */
    public function run(
        ScheduledCommandInterface $scheduledCommand,
        array $arguments = array(),
        array $options = array(),
        Debugger $debugger = null
    ) {
        $runCommand = $this->commandService->getRunCommand($scheduledCommand, $arguments, $options);

        if (!is_null($debugger)) {
            $debugger->commandRun($scheduledCommand, $runCommand);
        }

        if(function_exists('exec')) {
            exec($runCommand);
        } else {
            $process = new Process($runCommand);
            $process->run();
            // executes after the command finishes
            if (!$process->isSuccessful()) {
                throw new ProcessFailedException($process);
            }
        }

        return true;
    }
}
