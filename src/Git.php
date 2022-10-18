<?php declare(strict_types=1);

namespace Envorra\GitHelper;

use Envorra\GitHelper\Shell\Shell;
use Envorra\GitHelper\Commands\PushCommand;
use Envorra\GitHelper\Commands\BranchCommand;
use Envorra\GitHelper\Commands\RemoteCommand;
use Envorra\GitHelper\Commands\SubtreeCommand;

/**
 * Git
 *
 * @package Envorra\GitHelper
 *
 */
class Git
{
    /**
     * @return BranchCommand
     */
    public static function branch(): BranchCommand
    {
        return new BranchCommand();
    }

    /**
     * @return RemoteCommand
     */
    public static function remote(): RemoteCommand
    {
        return new RemoteCommand();
    }

    /**
     * @return SubtreeCommand
     */
    public static function subtree(): SubtreeCommand
    {
        return new SubtreeCommand();
    }

    /**
     * @return PushCommand
     */
    public static function push(): PushCommand
    {
        return new PushCommand();
    }

    /**
     * @return Shell
     */
    public static function shell(): Shell
    {
        return Shell::instance();
    }
}
