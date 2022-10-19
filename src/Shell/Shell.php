<?php declare(strict_types=1);

namespace Envorra\GitHelper\Shell;

use Envorra\GitHelper\Contracts\ShellCommand;
use Envorra\GitHelper\Contracts\CommandBuilder;

/**
 * Shell
 *
 * @package Envorra\GitHelper\Shell
 */
class Shell
{

    protected static self $instance;
    /** @var ExecutableCommand[] */
    protected array $executed = [];
    /** @var ExecutableCommand[] */
    protected array $queued = [];


    private function __construct()
    {

    }

    /**
     * @return static
     */
    public static function instance(): self
    {
        if (!isset(self::$instance)) {
            self::$instance = new self;
        }
        return self::$instance;
    }


    /**
     * @param  ExecutableCommand|CommandBuilder|string  $command
     * @return $this
     */
    public function execute(ExecutableCommand|CommandBuilder|string $command): static
    {
        array_unshift($this->executed, $this->makeExecutableCommand($command)->run());
        return $this;
    }

    /**
     * @return ExecutedCommand|null
     */
    public function firstExecutedCommand(): ?ExecutedCommand
    {
        return $this->nthInExecuted(-1);
    }

    /**
     * @return ExecutedCommand[]
     */
    public function getExecuted(): array
    {
        return array_map(
            fn(int $index, ExecutableCommand $command) => new ExecutedCommand($command, $index),
            array_keys($this->executed),
            $this->executed
        );
    }

    /**
     * @return QueuedCommand[]
     */
    public function getQueued(): array
    {
        return array_map(
            fn(int $index, ExecutableCommand $command) => new QueuedCommand($command, $index),
            array_keys($this->queued),
            $this->queued
        );
    }

    /**
     * @return ExecutedCommand|null
     */
    public function lastExecutedCommand(): ?ExecutedCommand
    {
        return $this->nthInExecuted(1);
    }

    /**
     * @return QueuedCommand|null
     */
    public function lastInQueue(): ?QueuedCommand
    {
        return $this->nthInQueue(-1);
    }

    /**
     * @return QueuedCommand|null
     */
    public function nextInQueue(): ?QueuedCommand
    {
        return $this->nthInQueue(1);
    }

    /**
     * @param  int  $nth
     * @return ExecutedCommand|null
     */
    public function nthInExecuted(int $nth): ?ExecutedCommand
    {
        return $this->nth($nth, $this->getExecuted());
    }

    /**
     * @param  int  $nth
     * @return QueuedCommand|null
     */
    public function nthInQueue(int $nth): ?QueuedCommand
    {
        return $this->nth($nth, $this->getQueued());
    }


    /**
     * @param  ExecutableCommand|CommandBuilder|string  $command
     * @return $this
     */
    public function queue(ExecutableCommand|CommandBuilder|string $command): static
    {
        $command = $this->makeExecutableCommand($command);
        $this->queued[] = $command->hasExecuted() ? $command->duplicate() : $command;
        return $this;
    }

    /**
     * @param  ExecutableCommand|CommandBuilder|string  $command
     * @return ExecutedCommand
     */
    public function run(ExecutableCommand|CommandBuilder|string $command): ExecutedCommand
    {
        return $this->execute($command)->lastExecutedCommand();
    }

    /**
     * @return $this
     */
    public function runQueued(): static
    {
        while (count($this->queued) > 0) {
            $this->execute(array_pop($this->queued));
        }
        return $this;
    }

    /**
     * @param  ShellCommand|CommandBuilder|string  $command
     * @return ExecutableCommand
     */
    protected function makeExecutableCommand(ShellCommand|CommandBuilder|string $command): ExecutableCommand
    {
        if ($command instanceof ExecutableCommand) {
            return $command;
        }

        return ExecutableCommand::make((string) $command);
    }

    /**
     * @template T
     *
     * @param  int  $nth
     * @param  T[]  $items
     * @return T|null
     */
    protected function nth(int $nth, array $items): mixed
    {
        return array_slice($items, $nth > 0 ? $nth - 1 : $nth, 1)[0] ?? null;
    }
}
