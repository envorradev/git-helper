<?php declare(strict_types=1);

namespace Envorra\GitHelper\Commands;

use Envorra\GitHelper\Shell\Shell;
use Envorra\GitHelper\Shell\QueuedCommand;
use Envorra\GitHelper\Shell\ExecutedCommand;
use Envorra\GitHelper\Contracts\CommandBuilder;

/**
 * AbstractCommand
 *
 * @package Envorra\GitHelper\Commands
 */
abstract class AbstractCommand implements CommandBuilder
{
    /**
     * @inheritDoc
     */
    public function __toString(): string
    {
        return $this->build();
    }

    /**
     * @return string
     */
    public function build(): string
    {
        preg_match_all('/\{([a-zA-Z0-9]+)\}/', $this->signature(), $matches);
        $values = [];
        foreach ($matches[1] ?? [] as $prop) {
            if (property_exists($this, $prop)) {
                $value = $this->$prop;

                if (is_array($value)) {
                    $value = implode(' ', $value);
                }

                $values['{'.$prop.'}'] = $value;
            }
        }
        return strtr($this->signature(), $values);
    }

    /**
     * @return QueuedCommand
     */
    public function queue(): QueuedCommand
    {
        return Shell::instance()->queue($this->build())->lastInQueue();
    }

    /**
     * @return ExecutedCommand
     */
    public function run(): ExecutedCommand
    {
        return Shell::instance()->run($this->build());
    }

    /**
     * @return string
     */
    abstract public function signature(): string;
}
