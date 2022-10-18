<?php declare(strict_types=1);

namespace Envorra\GitHelper\Commands;

use Envorra\GitHelper\Shell\Shell;
use Envorra\GitHelper\Shell\Command;

/**
 * AbstractCommand
 *
 * @package Envorra\GitHelper\Commands
 */
abstract class AbstractCommand
{
    /**
     * @return string
     */
    abstract public function signature(): string;

    /**
     * @return string
     */
    public function build(): string
    {
        preg_match_all('/\{([a-zA-Z0-9]+)\}/', $this->signature(), $matches);
        $values = [];
        foreach($matches[1] ?? [] as $prop) {
            if(property_exists($this, $prop)) {
                $value = $this->$prop;

                if(is_array($value)) {
                    $value = implode(' ', $value);
                }

                $values['{'.$prop.'}'] = $value;
            }
        }
        return strtr($this->signature(), $values);
    }

    /**
     * @return Command
     */
    public function run(): Command
    {
        return Shell::instance()->run($this->build());
    }
}
