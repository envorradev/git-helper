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
     * @param  Command   $command
     * @param  int|null  $queueIndex
     */
    public function __construct(
        Command $command,
        public readonly int|null $queueIndex = null,
    ) {
        parent::__construct($command);
    }
}
