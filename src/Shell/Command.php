<?php declare(strict_types=1);

namespace Envorra\GitHelper\Shell;

use Envorra\GitHelper\Contracts\ShellCommand;

/**
 * Command
 *
 * @package Envorra\GitHelper\Shell
 */
class Command implements ShellCommand
{
    public readonly string $command;
    protected array $output = [];
    protected int $exitCode = 0;
    protected bool $executed = false;

    /**
     * @param  string  $command
     */
    public function __construct(string $command)
    {
        $this->command = trim(preg_replace('/\s+/', ' ', $command));
    }

    /**
     * @return $this
     */
    public function run(): static
    {
        if(!$this->executed) {
            exec($this->command, $this->output, $this->exitCode);
            $this->executed = true;
        }

        return $this;
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
        return $this->exitCode() !== 0;
    }
    /**
     * @inheritDoc
     */
    public function exitCode(): int
    {
        return $this->run()->exitCode;
    }

    /**
     * @return $this
     */
    public function duplicate(): static
    {
        return new self($this->command);
    }

    /**
     * @return ImmutableCommand
     */
    public function toImmutable(): ImmutableCommand
    {
        return $this->executed ? new ExecutedCommand($this) : new ImmutableCommand($this);
    }

    /**
     * @param  string  $command
     * @return static
     */
    public static function make(string $command): static
    {
        return new self($command);
    }

    /**
     * @param  string  $command
     * @return static
     */
    public static function execute(string $command): static
    {
        return self::make($command)->run();
    }
}
