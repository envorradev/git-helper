<?php declare(strict_types=1);

namespace Envorra\GitHelper\GitObjects;

/**
 * Repository
 *
 * @package Envorra\GitHelper\GitObjects
 */
class Repository
{
    protected string $name;
    /** @var Remote[] */
    protected array $remotes = [];
    /** @var Branch[] */
    protected array $branches = [];
}
