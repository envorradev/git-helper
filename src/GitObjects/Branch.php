<?php declare(strict_types=1);

namespace Envorra\GitHelper\GitObjects;

use Envorra\GitHelper\Shell\Shell;

/**
 * Branch
 *
 * @package Envorra\GitHelper\GitObjects
 */
class Branch
{
    protected bool $current;

    public function __construct(protected string $name)
    {

    }
}
