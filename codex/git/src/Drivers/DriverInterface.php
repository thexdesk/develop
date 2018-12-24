<?php
/**
 * Copyright (c) 2018. Codex Project.
 *
 * The license can be found in the package and online at https://codex-project.mit-license.org.
 *
 * @copyright 2018 Codex Project
 * @author    Robin Radic
 * @license   https://codex-project.mit-license.org MIT License
 */

namespace Codex\Git\Drivers;

use GrahamCampbell\Manager\ConnectorInterface;

interface DriverInterface extends ConnectorInterface
{
    /**
     * Establish a connection.
     *
     * @param array $config
     *
     * @return $this
     */
    public function connect(array $config);

    /**
     * getZipDownloader method.
     *
     * @return \Codex\Git\Connection\ZipDownloader
     */
    public function getZipDownloader();

    /**
     * getRefs method.
     *
     * @param string $owner
     * @param string $repository
     *
     * @return \Codex\Git\Connection\RefCollection
     */
    public function getRefs(string $owner, string $repository);

    /**
     * downloadFile method.
     *
     * @param string $url
     *
     * @return string
     */
    public function downloadFile(string $url);
}
