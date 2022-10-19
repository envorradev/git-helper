<?php declare(strict_types=1);

namespace Envorra\GitHelper\Shell;

/**
 * QueuedCommand
 *
 * @package Envorra\GitHelper\Shell
 */
class QueuedCommand extends ImmutableCommand
{
    /**
     * @param  ExecutableCommand  $command
     * @param  int|null           $queueIndex
     */
    public function __construct(
        ExecutableCommand $command,
        public readonly int|null $queueIndex = null,
    ) {
        parent::__construct($command);
    }
}
