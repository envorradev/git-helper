<?php declare(strict_types=1);

namespace Envorra\GitHelper\Commands;

use Exception;

/**
 * SubtreeCommand
 *
 * @package Envorra\GitHelper\Commands
 */
class SubtreeCommand extends AbstractCommand
{
    /**
     * @var string|null
     */
    protected string|null $action = null;
    /**
     * @var array
     */
    protected array $arguments = [];
    /**
     * @var string|null
     */
    protected string|null $prefix = null;

    /**
     * @param  string  $prefix
     * @return $this
     */
    public function prefix(string $prefix): static
    {
        $this->reset();
        $this->prefix = '"'.$prefix.'"';
        return $this;
    }

    /**
     * @return $this
     */
    public function reset(): static
    {
        $this->action = null;
        $this->prefix = null;
        $this->arguments = [];
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function signature(): string
    {
        return 'git subtree {action} --prefix={prefix} {arguments}';
    }

    /**
     * @param  string  ...$arguments
     * @return $this
     * @throws Exception
     */
    public function split(string ...$arguments): static
    {
        $this->throwIfPrefixNotSet();
        $this->action = 'split';
        $this->arguments = array_merge($this->arguments, $arguments);
        return $this;
    }

    /**
     * @param  string  $branchName
     * @return $this
     * @throws Exception
     */
    public function splitToBranch(string $branchName): static
    {
        return $this->split('--branch', $branchName);
    }

    /**
     * @return void
     * @throws Exception
     */
    protected function throwIfPrefixNotSet(): void
    {
        if (!isset($this->prefix)) {
            throw new Exception('Set prefix first!');
        }
    }
}
