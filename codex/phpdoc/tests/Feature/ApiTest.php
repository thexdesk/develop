<?php
/**
 * Copyright (c) 2018. Codex Project
 *
 * The license can be found in the package and online at https://codex-project.mit-license.org.
 *
 * @copyright 2018 Codex Project
 * @author Robin Radic
 * @license https://codex-project.mit-license.org MIT License
 */

namespace Codex\Tests\Addon\Phpdoc\Feature;

use Codex\Tests\Addon\Phpdoc\TestCase;

class ApiTest extends TestCase
{
    public function testManifest404()
    {
        $response = $this->json('get', '/api/v1/phpdoc/codex/foobar');

        $response->assertStatus(404);
    }

    public function testManifest()
    {
        $response = $this->json('get', '/api/v1/phpdoc/codex/master');

        $response->assertStatus(200);
    }

    public function testFull404()
    {
        $response = $this->json('get', '/api/v1/phpdoc/codex/foobar/full');

        $response->assertStatus(404);
    }

    public function testFull()
    {
        $response = $this->json('get', '/api/v1/phpdoc/codex/master');

        $response->assertStatus(200);
    }

    public function testFile404()
    {
        $response = $this->json('get', '/api/v1/phpdoc/codex/foobar/foobar');

        $response->assertStatus(404);
    }

    public function testFile()
    {

        $manifest = $this->codex->getProject('codex')->getRevision('master')->phpdoc->generate(false)->getManifest();
        $hash     = $manifest->getHashByFullName('Codex\Codex');
        $response = $this->json('get', '/api/v1/phpdoc/codex/master/' . $hash);

        $response->assertStatus(200);
    }

    public function testProject404()
    {
        $response = $this->json('get', '/api/v1/phpdoc/foobar');

        $response->assertStatus(404);
    }

    public function testProject()
    {
        $response = $this->json('get', '/api/v1/phpdoc/codex');

        $response->assertStatus(200);
    }
}
