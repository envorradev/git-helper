<?php declare(strict_types=1);

namespace Envorra\GitHelper\Contracts;

use Stringable;

/**
 * CommandBuilder
 *
 * @package Envorra\GitHelper\Contracts
 */
interface CommandBuilder extends Stringable
{
    /**
     * @return string
     */
    public function build(): string;

    /**
     * @return ShellCommandImmutable
     */
    public function queue(): ShellCommandImmutable;

    /**
     * @return $this
     */
    public function reset(): static;

    /**
     * @return ShellCommandImmutable
     */
    public function run(): ShellCommandImmutable;

    /**
     * @return string
     */
    public function signature(): string;
}
