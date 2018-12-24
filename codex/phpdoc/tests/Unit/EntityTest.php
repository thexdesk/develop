<?php
/**
 * Copyright (c) 2018. Codex Project
 *
 * The license can be found in the package and online at https://codex-project.mit-license.org.
 *
 * @copyright 2018 Codex Project
 * @author    Robin Radic
 * @license   https://codex-project.mit-license.org MIT License
 */

namespace Codex\Tests\Addon\Phpdoc\Unit;

use Codex\Addon\Phpdoc\Entity;
use Codex\Tests\Addon\Phpdoc\TestCase;

class EntityTest extends TestCase
{
    protected $data = [
        'Codex'                   => 'entity',
        '\\Codex'                   => 'entity',
        '\\Codex\\Codex'            => 'entity',
        '\\Codex\\Codex::constant'  => 'constant',
        '\\Codex\\Codex::method()'  => 'method',
        '\\Codex\\Codex::$property' => 'property',
    ];

    public function testReturnsValidTypes()
    {

        foreach ($this->data as $input => $expected) {
            $entity = new Entity($input);

            $this->assertTrue($entity->isValid, 'should be valid');
            $this->assertEquals($expected, $entity->type, 'should be the correct type');
        }
    }
}
