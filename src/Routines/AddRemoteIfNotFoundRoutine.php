<?php declare(strict_types=1);

namespace Envorra\GitHelper\Routines;

/**
 * AddRemoteIfNotFoundRoutine
 *
 * @package Envorra\GitHelper\Routines
 */
class AddRemoteIfNotFoundRoutine extends AbstractRoutine
{
    /**
     * @param  string  $remoteName
     * @param  string  $remoteUrl
     */
    public function __construct(
        protected string $remoteName,
        protected string $remoteUrl,
    ) {
        parent::__construct();
    }

    /**
     * @return void
     */
    public function run(): void
    {
        if(!$this->remote()->hasRemote($this->remoteName)) {
            $this->execute($this->remote()->add($this->remoteName, $this->remoteUrl));
        }
    }
}
