<?php declare(strict_types=1);

namespace Envorra\GitHelper\Commands;

/**
 * BranchCommand
 *
 * @package Envorra\GitHelper\Commands
 */
class BranchCommand extends AbstractCommand
{
    protected string $mode = '';
    protected array $flags = [];
    protected array $arguments = [];

    /**
     * @inheritDoc
     */
    public function signature(): string
    {
        return 'git branch {mode} {flags} {arguments}';
    }

    public function reset(): static
    {
        $this->mode = '';
        $this->flags = [];
        $this->arguments = [];
        return $this;
    }

    public function getAll(): array
    {
        return $this->reset()->run()->output();
    }

    public function getCurrent(): ?string
    {
        $this->reset();
        $this->mode = '--show-current';
        return $this->run()->output()[0] ?? null;
    }

    public function force(): static
    {
        $this->flags[] = '--force';
        return $this;
    }

    public function delete(string $name): static
    {
        $this->mode = '--delete';
        $this->arguments = [$name];
        return $this;
    }

    public function move(string $oldName, string $newName): static
    {
        $this->mode = '--move';
        $this->arguments = [$oldName, $newName];
        return $this;
    }

    public function copy(string $branch, string $to): static
    {
        $this->mode = '--copy';
        $this->arguments = [$branch, $to];
        return $this;
    }

    public function create(string $name): static
    {
        $this->mode = '';
        $this->arguments = [$name];
        return $this;
    }
}
