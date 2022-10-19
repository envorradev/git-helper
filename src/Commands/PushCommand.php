<?php declare(strict_types=1);

namespace Envorra\GitHelper\Commands;

/**
 * PushCommand
 *
 * @package Envorra\GitHelper\Commands
 */
class PushCommand extends AbstractCommand
{
    /**
     * @var string|null
     */
    protected string|null $branchSeparator = null;
    /**
     * @var array
     */
    protected array $flags = [];
    /**
     * @var string|null
     */
    protected string|null $localBranch = null;
    /**
     * @var string|null
     */
    protected string|null $remote = null;
    /**
     * @var string|null
     */
    protected string|null $remoteBranch = null;

    /**
     * @return $this
     */
    public function all(): static
    {
        $this->flags[] = '--all';
        return $this;
    }

    /**
     * @param  string  $name
     * @return $this
     */
    public function branch(string $name): static
    {
        $this->reset();
        $this->remoteBranch = $name;
        return $this;
    }

    /**
     * @param  string  $local
     * @param  string  $remote
     * @return $this
     */
    public function branches(string $local, string $remote): static
    {
        $this->localBranch = $local;
        $this->remoteBranch = $remote;
        $this->withSeparator();
        return $this;
    }

    /**
     * @param  string  $remote
     * @return $this
     */
    public function remote(string $remote): static
    {
        $this->remote = $remote;
        return $this;
    }

    /**
     * @return $this
     */
    public function reset(): static
    {
        $this->flags = [];
        $this->remote = null;
        $this->localBranch = null;
        $this->remoteBranch = null;
        $this->branchSeparator = null;
        return $this;
    }

    /**
     * @param  string       $remote
     * @param  string       $localBranch
     * @param  string|null  $remoteBranch
     * @return $this
     */
    public function setUpstream(string $remote, string $localBranch, string|null $remoteBranch = null): static
    {
        $this->reset();
        $this->flags[] = '--set-upstream';
        $this->remote = $remote;
        $this->localBranch = $localBranch;

        if ($remoteBranch) {
            $this->remoteBranch = $remoteBranch;
            $this->withSeparator();
        }

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function signature(): string
    {
        return 'git push {flags} {remote} {localBranch}{branchSeparator}{remoteBranch}';
    }

    /**
     * @return $this
     */
    public function tags(): static
    {
        $this->flags[] = '--tags';
        return $this;
    }

    /**
     * @return $this
     */
    public function withSeparator(): static
    {
        $this->branchSeparator = ':';
        return $this;
    }
}
