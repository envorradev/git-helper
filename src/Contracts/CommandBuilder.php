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
     * @return ShellCommandImmutable
     */
    public function run(): ShellCommandImmutable;

    /**
     * @return ShellCommandImmutable
     */
    public function queue(): ShellCommandImmutable;

    /**
     * @return string
     */
    public function build(): string;

    /**
     * @return string
     */
    public function signature(): string;

    /**
     * @return $this
     */
    public function reset(): static;
}
