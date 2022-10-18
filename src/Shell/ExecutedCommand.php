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
    public readonly bool $succeeded;
    public readonly bool $failed;
    public readonly array $output;

    /**
     * @param  Command   $command
     * @param  int|null  $stackIndex
     */
    public function __construct(
        Command $command,
        public readonly int|null $stackIndex = null,
    ) {
        parent::__construct($command);
        $this->exitCode = $command->exitCode();
        $this->succeeded = $command->succeeded();
        $this->failed = $command->failed();
        $this->output = $command->output();
    }
}
