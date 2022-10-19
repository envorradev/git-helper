<?php declare(strict_types=1);

namespace Envorra\GitHelper\Shell;

use Envorra\GitHelper\Contracts\ShellCommand;

/**
 * Command
 *
 * @package Envorra\GitHelper\Shell
 */
final class ExecutableCommand implements ShellCommand
{
    public readonly string $command;
    protected bool $executed = false;
    protected int $exitCode = 0;
    protected array $output = [];

    /**
     * @param  string  $command
     */
    public function __construct(string $command)
    {
        $this->command = trim(preg_replace('/\s+/', ' ', $command));
    }

    /**
     * @param  string  $command
     * @return static
     */
    public static function execute(string $command): self
    {
        return self::make($command)->run();
    }

    /**
     * @param  string  $command
     * @return static
     */
    public static function make(string $command): self
    {
        return new self($command);
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
     * @return $this
     */
    public function duplicate(): self
    {
        return new self($this->command);
    }

    /**
     * @inheritDoc
     */
    public function exitCode(): int
    {
        return $this->run()->exitCode;
    }

    /**
     * @inheritDoc
     */
    public function failed(): bool
    {
        return $this->exitCode() !== 0;
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
    public function output(): array
    {
        return $this->run()->output;
    }

    /**
     * @return $this
     */
    public function run(): self
    {
        if (!$this->executed) {
            exec($this->command, $this->output, $this->exitCode);
            $this->executed = true;
        }

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function succeeded(): bool
    {
        return $this->exitCode() === 0;
    }

    /**
     * @return ImmutableCommand
     */
    public function toImmutable(): ImmutableCommand
    {
        return $this->executed ? new ExecutedCommand($this) : new ImmutableCommand($this);
    }
}
