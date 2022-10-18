<?php declare(strict_types=1);

namespace Envorra\GitHelper\Shell;

/**
 * Command
 *
 * @package Envorra\GitHelper\Shell
 */
class Command
{
    protected array $output = [];
    protected int $exitCode = 0;
    protected bool $executed = false;

    public function __construct(
        public readonly string $command,
    ) {
    }

    public function run(): static
    {
        if(!$this->executed) {
            exec($this->command, $this->output, $this->exitCode);
            $this->executed = true;
        }

        return $this;
    }

    public function hasExecuted(): bool
    {
        return $this->executed;
    }

    public function output(): array
    {
        if(!$this->executed) {
            $this->run();
        }
        return $this->output;
    }

    public function exitCode(): int
    {
        if(!$this->executed) {
            $this->run();
        }
        return $this->exitCode;
    }

    public function duplicate(): self
    {
        return new self($this->command);
    }

    public static function make(string $command): self
    {
        return new self($command);
    }

    public static function execute(string $command): self
    {
        return self::make($command)->run();
    }
}
