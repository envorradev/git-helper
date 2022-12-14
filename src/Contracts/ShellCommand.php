<?php declare(strict_types=1);

namespace Envorra\GitHelper\Contracts;

use Stringable;

/**
 * ShellCommand
 *
 * @package Envorra\GitHelper\Contracts
 */
interface ShellCommand extends Stringable
{
    /**
     * @return string
     */
    public function command(): string;

    /**
     * @return int|null
     */
    public function exitCode(): int|null;

    /**
     * @return bool
     */
    public function failed(): bool;

    /**
     * @return bool
     */
    public function hasExecuted(): bool;

    /**
     * @return array|null
     */
    public function output(): array|null;

    /**
     * @return bool
     */
    public function succeeded(): bool;
}
