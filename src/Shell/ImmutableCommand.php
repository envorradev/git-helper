<?php declare(strict_types=1);

namespace Envorra\GitHelper\Shell;

use Envorra\GitHelper\Contracts\ShellCommand;

/**
 * ImmutableCommand
 *
 * @package Envorra\GitHelper\Shell
 */
class ImmutableCommand implements ShellCommand
{
    public readonly string $command;
    public readonly bool $executed;

    /**
     * @param  Command  $command
     */
    public function __construct(Command $command)
    {
        $this->command = $command->command;
        $this->executed = $command->hasExecuted();
    }

    /**
     * @inheritDoc
     */
    public function output(): array|null
    {
        return $this->output ?? null;
    }

    /**
     * @inheritDoc
     */
    public function exitCode(): int|null
    {
        return $this->exitCode ?? null;
    }

    /**
     * @inheritDoc
     */
    public function hasExecuted(): bool
    {
        return $this->executed;
    }

    /**
     * @inheritDoc
     */
    public function succeeded(): bool
    {
        return $this->exitCode() === 0;
    }

    /**
     * @inheritDoc
     */
    public function failed(): bool
    {
        return !is_null($this->exitCode()) && $this->exitCode() !== 0;
    }


}
