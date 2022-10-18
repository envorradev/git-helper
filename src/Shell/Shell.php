<?php declare(strict_types=1);

namespace Envorra\GitHelper\Shell;

/**
 * Shell
 *
 * @package Envorra\GitHelper\Shell
 */
class Shell
{
    protected array $executed = [];

    protected array $queued = [];

    protected static self $instance;

    protected function __construct()
    {

    }

    /**
     * @return array
     */
    public function getExecuted(): array
    {
        return $this->executed;
    }

    /**
     * @return array
     */
    public function getQueued(): array
    {
        return $this->queued;
    }

    /**
     * @param  Command|string  $command
     * @return $this
     */
    public function queue(Command|string $command): static
    {
        if(is_string($command)) {
            $command = Command::make($command);
        }

        $this->queued[] = $command->hasExecuted() ? $command->duplicate() : $command;
        return $this;
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
     * @param  Command|string  $command
     * @return Command
     */
    public function run(Command|string $command): Command
    {
        return $this->execute($command)->lastExecutedCommand();
    }

    /**
     * @return $this
     */
    public function runQueued(): static
    {
        while(count($this->queued) > 0) {
            $this->execute(array_pop($this->queued));
        }
        return $this;
    }

    /**
     * @return Command|null
     */
    public function lastExecutedCommand(): ?Command
    {
        return $this->executed[0] ?? null;
    }

    public static function instance(): self
    {
        if(!isset(self::$instance)) {
            self::$instance = new self;
        }
        return self::$instance;
    }
}
