<?php declare(strict_types=1);

namespace Envorra\GitHelper\Shell;

/**
 * ExecutedCommand
 *
 * @package Envorra\GitHelper\Shell
 */
class ExecutedCommand extends ImmutableCommand
{
    public readonly int $exitCode;
    public readonly bool $failed;
    public readonly array $output;
    public readonly bool $succeeded;

    /**
     * @param  ExecutableCommand  $command
     * @param  int|null           $stackIndex
     */
    public function __construct(
        ExecutableCommand $command,
        public readonly int|null $stackIndex = null,
    ) {
        parent::__construct($command);
        $this->exitCode = $command->exitCode();
        $this->succeeded = $command->succeeded();
        $this->failed = $command->failed();
        $this->output = $command->output();
    }
}
