<?php declare(strict_types=1);

namespace Envorra\GitHelper\Commands;

/**
 * RemoteCommand
 *
 * @package Envorra\GitHelper\Commands
 */
class RemoteCommand extends AbstractCommand
{
    /**
     * @var string|null
     */
    protected string|null $action = null;
    /**
     * @var string|null
     */
    protected string|null $name = null;
    /**
     * @var array
     */
    protected array $arguments = [];

    /**
     * @inheritDoc
     */
    public function signature(): string
    {
        return 'git remote {action} {name} {arguments}';
    }

    /**
     * @return array
     */
    public function getAll(): array
    {
        return $this->reset()->run()->output();
    }

    /**
     * @param  string  $name
     * @return bool
     */
    public function hasRemote(string $name): bool
    {
        return in_array($name, $this->getAll());
    }

    /**
     * @return $this
     */
    public function reset(): static
    {
        $this->action = null;
        $this->name = null;
        $this->arguments = [];
        return $this;
    }

    /**
     * @param  string  $name
     * @param  string  $url
     * @return $this
     */
    public function add(string $name, string $url): static
    {
        $this->reset();
        $this->action = 'add';
        $this->name = $name;
        $this->arguments[] = $url;
        return $this;
    }

    /**
     * @param  string  $name
     * @return $this
     */
    public function remove(string $name): static
    {
        $this->reset();
        $this->action = 'remove';
        $this->name = $name;
        return $this;
    }

    /**
     * @param  string  $old
     * @param  string  $new
     * @return $this
     */
    public function rename(string $old, string $new): static
    {
        $this->reset();
        $this->action = 'rename';
        $this->name = $old;
        $this->arguments[] = $new;
        return $this;
    }

    /**
     * @param  string  $name
     * @return $this
     */
    public function show(string $name): static
    {
        $this->reset();
        $this->action = 'show';
        $this->name = $name;
        return $this;
    }
}
