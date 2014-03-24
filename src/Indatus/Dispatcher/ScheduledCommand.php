<?php

/**
 * This file is part of Dispatcher
 *
 * (c) Ben Kuhl <bkuhl@indatus.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Indatus\Dispatcher;

use App;
use Illuminate\Console\Command;

abstract class ScheduledCommand extends Command implements ScheduledCommandInterface
{


    /**
     * Unfortunately, this has to be here for unit testing
     *
     * @var string
     */
    protected $name = 'scheduledCommand';

    /**
     * User to run the command as
     *
     * @return string Defaults to false to run as default user
     */
    public function user()
    {
        return false;
    }

    /**
     * Environment(s) under which the given command should run
     *
     * @return string
     */
    public function environment()
    {
        return '*';
    }

}