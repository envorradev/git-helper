<?php declare(strict_types=1);

namespace Envorra\GitHelper\Shell;

use Envorra\GitHelper\Contracts\ShellCommandImmutable;

/**
 * ImmutableCommand
 *
 * @package Envorra\GitHelper\Shell
 */
class ImmutableCommand implements ShellCommandImmutable
{
    public readonly string $command;
    public readonly bool $executed;

    /**
     * @param  ExecutableCommand  $command
     */
    public function __construct(ExecutableCommand $command)
    {
        $this->command = $command->command;
        $this->executed = $command->hasExecuted();
    }

    /**
     * @inheritDoc
     */
    public function __toString()
    {
        return $this->command;
    }

    /**
     * @inheritDoc
     */
    public function command(): string
    {
        return $this->command;
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
    public function failed(): bool
    {
        return !is_null($this->exitCode()) && $this->exitCode() !== 0;
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
    public function output(): array|null
    {
        return $this->output ?? null;
    }

    /**
     * @inheritDoc
     */
    public function succeeded(): bool
    {
        return $this->exitCode() === 0;
    }
}
