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
     * @return self
     */
    public static function instance(): self
    {
        return new self;
    }

    /**
     * @return Shell
     */
    public function runQueued(): Shell
    {
        return $this->shell()->runQueued();
    }

    /**
     * @return Shell
     */
    public function shell(): Shell
    {
        return Shell::instance();
    }

    /**
     * @return BranchCommand
     */
    public function branch(): BranchCommand
    {
        return new BranchCommand();
    }

    /**
     * @return PushCommand
     */
    public function push(): PushCommand
    {
        return new PushCommand();
    }

    /**
     * @return RemoteCommand
     */
    public function remote(): RemoteCommand
    {
        return new RemoteCommand();
    }

    /**
     * @return SubtreeCommand
     */
    public function subtree(): SubtreeCommand
    {
        return new SubtreeCommand();
    }
}
