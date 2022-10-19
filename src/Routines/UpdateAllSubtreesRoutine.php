<?php declare(strict_types=1);

namespace Envorra\GitHelper\Routines;

/**
 * UpdateAllSubtreesRoutine
 *
 * @package Envorra\GitHelper\Routines
 */
class UpdateAllSubtreesRoutine extends AbstractRoutine
{
    protected SubtreeToDifferentRepositoryRoutine $routine;

    public function __construct(
        protected string $repositoryBaseUrl,
        protected array $prefixMap,
    ) {
        parent::__construct();
        $this->routine = new SubtreeToDifferentRepositoryRoutine();

        if(!str_ends_with($this->repositoryBaseUrl, '/')) {
            $this->repositoryBaseUrl .= '/';
        }
    }


    public function run(): void
    {
        foreach ($this->prefixMap as $name => $prefix) {
            $this->routine->setPrefix($prefix)
                          ->setBranch($name)
                          ->setRemote($name)
                          ->setRepository($this->repositoryBaseUrl.$name)
                          ->run();
        }
    }
}
