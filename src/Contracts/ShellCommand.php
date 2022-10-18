<?php declare(strict_types=1);

namespace Envorra\GitHelper\Contracts;

/**
 * ShellCommand
 *
 * @package Envorra\GitHelper\Contracts
 */
interface ShellCommand
{
    /**
     * @return array|null
     */
    public function output(): array|null;

    /**
     * @return int|null
     */
    public function exitCode(): int|null;

    /**
     * @return bool
     */
    public function hasExecuted(): bool;

    /**
     * @return bool
     */
    public function succeeded(): bool;

    /**
     * @return bool
     */
    public function failed(): bool;
}
