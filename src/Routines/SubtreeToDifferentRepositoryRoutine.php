<?php declare(strict_types=1);

namespace Envorra\GitHelper\Routines;

/**
 * SubtreeToDifferentRepositoryRoutine
 *
 * @package Envorra\GitHelper\Routines
 */
class SubtreeToDifferentRepositoryRoutine extends AbstractRoutine
{
    protected string $branch;
    protected string $prefix;
    protected string $remote;
    protected string $repository;

    /**
     * @return string
     */
    public function getBranch(): string
    {
        return $this->branch;
    }

    /**
     * @param  string  $branch
     * @return self
     */
    public function setBranch(string $branch): self
    {
        $this->branch = $branch;
        return $this;
    }

    /**
     * @return string
     */
    public function getPrefix(): string
    {
        return $this->prefix;
    }

    /**
     * @param  string  $prefix
     * @return self
     */
    public function setPrefix(string $prefix): self
    {
        $this->prefix = $prefix;
        return $this;
    }

    /**
     * @return string
     */
    public function getRemote(): string
    {
        return $this->remote;
    }

    /**
     * @param  string  $remote
     * @return self
     */
    public function setRemote(string $remote): self
    {
        $this->remote = $remote;
        return $this;
    }

    /**
     * @return string
     */
    public function getRepository(): string
    {
        return $this->repository;
    }

    /**
     * @param  string  $repository
     * @return self
     */
    public function setRepository(string $repository): self
    {
        $this->repository = $repository;
        return $this;
    }

    /**
     * @return bool
     */
    public function validate(): bool
    {
        return isset($this->prefix, $this->branch, $this->remote, $this->repository);
    }

    /**
     * @return void
     * @throws \Exception
     */
    public function run(): void
    {
        if($this->validate()) {
            (new AddRemoteIfNotFoundRoutine($this->remote, $this->repository))->run();

            $this->execute([
                $this->subtree()->prefix($this->prefix)->splitToBranch($this->branch),
                $this->push()->setUpstream($this->remote, $this->branch, 'master'),
                $this->branch()->delete($this->branch)->force(),
                $this->remote()->remove($this->remote),
            ]);
        }
    }
}
