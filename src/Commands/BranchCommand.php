<?php declare(strict_types=1);

namespace Envorra\GitHelper\Commands;

/**
 * BranchCommand
 *
 * @package Envorra\GitHelper\Commands
 */
class BranchCommand extends AbstractCommand
{
    /**
     * @var string
     */
    protected string $mode = '';
    /**
     * @var array
     */
    protected array $flags = [];
    /**
     * @var array
     */
    protected array $arguments = [];

    /**
     * @inheritDoc
     */
    public function signature(): string
    {
        return 'git branch {mode} {flags} {arguments}';
    }

    /**
     * @return $this
     */
    public function reset(): static
    {
        $this->mode = '';
        $this->flags = [];
        $this->arguments = [];
        return $this;
    }

    /**
     * @return array
     */
    public function getAll(): array
    {
        return array_map(
            callback: fn($name) => preg_replace('/^[*\s]*/', '', $name),
            array: $this->reset()->run()->output()
        );
    }

    /**
     * @return string|null
     */
    public function getCurrent(): ?string
    {
        $this->reset();
        $this->mode = '--show-current';
        return $this->run()->output()[0] ?? null;
    }

    /**
     * @return $this
     */
    public function force(): static
    {
        $this->flags[] = '--force';
        return $this;
    }

    /**
     * @param  string  $name
     * @return $this
     */
    public function delete(string $name): static
    {
        $this->mode = '--delete';
        $this->arguments = [$name];
        return $this;
    }

    /**
     * @param  string  $oldName
     * @param  string  $newName
     * @return $this
     */
    public function move(string $oldName, string $newName): static
    {
        $this->mode = '--move';
        $this->arguments = [$oldName, $newName];
        return $this;
    }

    /**
     * @param  string  $branch
     * @param  string  $to
     * @return $this
     */
    public function copy(string $branch, string $to): static
    {
        $this->mode = '--copy';
        $this->arguments = [$branch, $to];
        return $this;
    }

    /**
     * @param  string  $name
     * @return $this
     */
    public function create(string $name): static
    {
        $this->mode = '';
        $this->arguments = [$name];
        return $this;
    }
}
