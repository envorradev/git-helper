<?php declare(strict_types=1);

namespace Envorra\GitHelper\Routines;

use Envorra\GitHelper\Git;
use Envorra\GitHelper\Contracts\Queued;
use Envorra\GitHelper\Contracts\Routine;
use Envorra\GitHelper\Commands\PushCommand;
use Envorra\GitHelper\Shell\ExecutedCommand;
use Envorra\GitHelper\Commands\BranchCommand;
use Envorra\GitHelper\Commands\RemoteCommand;
use Envorra\GitHelper\Commands\SubtreeCommand;
use Envorra\GitHelper\Commands\AbstractCommand;

/**
 * AbstractRoutine
 *
 * @package Envorra\GitHelper\Routines
 */
abstract class AbstractRoutine implements Routine
{
    protected Git $git;

    public function __construct()
    {
        $this->git = new Git();
    }

    abstract public function run(): void;

    /**
     * @return BranchCommand
     */
    protected function branch(): BranchCommand
    {
        return $this->git->branch();
    }

    /**
     * @param  AbstractCommand|array  ...$commands
     * @return ExecutedCommand[]
     */
    protected function execute(AbstractCommand|array ...$commands): array
    {
        $results = [];
        foreach ($commands as $command) {
            if (is_array($command)) {
                $results = array_merge($results, $this->execute(...$command));
            } else {
                $results[] = in_array(Queued::class, class_implements($this)) ? $command->queue() : $command->run();
            }
        }
        return $results;
    }

    /**
     * @return PushCommand
     */
    protected function push(): PushCommand
    {
        return $this->git->push();
    }

    /**
     * @return RemoteCommand
     */
    protected function remote(): RemoteCommand
    {
        return $this->git->remote();
    }

    /**
     * @return SubtreeCommand
     */
    protected function subtree(): SubtreeCommand
    {
        return $this->git->subtree();
    }
}
