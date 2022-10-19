<?php declare(strict_types=1);

namespace Envorra\GitHelper\Routines;

use Exception;

/**
 * UpdateAllSubtreesRoutine
 *
 * @package Envorra\GitHelper\Routines
 */
class UpdateAllSubtreesRoutine extends AbstractRoutine
{
    protected SubtreeToDifferentRepositoryRoutine $routine;

    /**
     * @param  string  $repositoryBaseUrl
     * @param  array   $prefixMap
     */
    public function __construct(
        protected string $repositoryBaseUrl,
        protected array $prefixMap,
    ) {
        parent::__construct();
        $this->routine = new SubtreeToDifferentRepositoryRoutine();

        if (!str_ends_with($this->repositoryBaseUrl, '/')) {
            $this->repositoryBaseUrl .= '/';
        }
    }


    /**
     * @return void
     * @throws Exception
     */
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
