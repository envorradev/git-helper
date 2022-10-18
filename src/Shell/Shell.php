<?php declare(strict_types=1);

namespace Envorra\GitHelper\Shell;

/**
 * Shell
 *
 * @package Envorra\GitHelper\Shell
 */
class Shell
{
    protected static self $instance;
    /** @var Command[] */
    protected array $executed = [];
    /** @var Command[] */
    protected array $queued = [];

    protected function __construct()
    {

    }

    public static function instance(): self
    {
        if (!isset(self::$instance)) {
            self::$instance = new self;
        }
        return self::$instance;
    }

    /**
     * @param  Command|string  $command
     * @return $this
     */
    public function execute(Command|string $command): static
    {
        array_unshift(
            $this->executed,
            is_string($command) ? Command::execute($command) : $command->run()
        );
        return $this;
    }

    /**
     * @return ExecutedCommand[]
     */
    public function getExecuted(): array
    {
        return array_map(
            fn(int $index, Command $command) => new ExecutedCommand($command, $index),
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
            fn(int $index, Command $command) => new QueuedCommand($command, $index),
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

    public function firstExecutedCommand(): ?ExecutedCommand
    {
        return $this->nthInExecuted(-1);
    }

    public function nextInQueue(): ?QueuedCommand
    {
        return $this->nthInQueue(1);
    }

    public function lastInQueue(): ?QueuedCommand
    {
        return $this->nthInQueue(-1);
    }

    public function nthInQueue(int $nth): ?QueuedCommand
    {
        return $this->nth($nth, $this->getQueued());
    }

    public function nthInExecuted(int $nth): ?ExecutedCommand
    {
        return $this->nth($nth, $this->getExecuted());
    }

    /**
     * @param  Command|string  $command
     * @return $this
     */
    public function queue(Command|string $command): static
    {
        if (is_string($command)) {
            $command = Command::make($command);
        }

        $this->queued[] = $command->hasExecuted() ? $command->duplicate() : $command;
        return $this;
    }

    /**
     * @param  Command|string  $command
     * @return ExecutedCommand
     */
    public function run(Command|string $command): ExecutedCommand
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
     * @template T
     *
     * @param  int    $nth
     * @param  T[]  $items
     * @return T|null
     */
    protected function nth(int $nth, array $items): mixed
    {
        return array_slice($items, $nth > 0 ? $nth - 1 : $nth, 1)[0] ?? null;
    }
}
