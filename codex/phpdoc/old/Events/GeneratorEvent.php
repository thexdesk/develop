<?php
/**
 * Copyright (c) 2018. Codex Project.
 *
 * The license can be found in the package and online at https://codex-project.mit-license.org.
 *
 * @copyright 2018 Codex Project
 * @author Robin Radic
 * @license https://codex-project.mit-license.org MIT License
 */

namespace Codex\Phpdoc\Events;

use Codex\Phpdoc\Generator;
use MyCLabs\Enum\Enum;

/**
 * This is the class GeneratorEvent.
 *
 * @author  Robin Radic
 *
 * @method static GeneratorEvent GENERATE()
 * @method static GeneratorEvent GENERATED()
 * @method static GeneratorEvent START()
 * @method static GeneratorEvent END()
 */
class GeneratorEvent extends Enum
{
    const GENERATE = 'GENERATE';
    const GENERATED = 'GENERATED';
    const START = 'START';
    const END = 'END';

    /** @var int */
    protected $flags;

    /** @var \Codex\Phpdoc\Generator */
    protected $generator;

    /** @var int */
    protected $flag;

    /** @var string */
    protected $context;

    /**
     * GeneratorEvent constructor.
     *
     * @param string                        $event
     * @param \Codex\Phpdoc\Generator $generator
     * @param mixed|null                    $context
     * @param int                           $flag
     */
    public function __construct(string $event, Generator $generator = null, $context = null, int $flag = null)
    {
        parent::__construct($event);
        $this->generator = $generator;
        $this->flag = $flag;
        $this->context = $context;
    }

    /**
     * @return int
     */
    public function getFlags(): int
    {
        return $this->flags;
    }

    /**
     * @return \Codex\Phpdoc\Generator
     */
    public function getGenerator(): \Codex\Phpdoc\Generator
    {
        return $this->generator;
    }

    /**
     * @return int
     */
    public function getFlag()
    {
        return $this->flag;
    }

    /**
     * @return string
     */
    public function getContext()
    {
        return $this->context;
    }
}
