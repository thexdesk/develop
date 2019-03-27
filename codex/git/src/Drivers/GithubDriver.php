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

use Codex\Git\Connection\Ref;
use Codex\Git\Connection\RefCollection;
use Codex\Git\Connection\WithZipDownloader;
use Http\Adapter\Guzzle6\Client as GuzzleClient;
use Http\Client\Common\Plugin\AddHostPlugin;
use Http\Discovery\UriFactoryDiscovery;

class GithubDriver implements DriverInterface
{
    use WithZipDownloader;

    /** @var \Github\Client */
    protected $client;

    /** @var \Github\HttpClient\Builder */
    protected $builder;

    protected $config;

    public function __construct($config)
    {
        $this->config  = $config;
        $this->builder = new \Github\HttpClient\Builder(new GuzzleClient());
        $this->client  = new \Github\Client($this->builder, 'v3');

        // Authenticate a user for all next requests.
        $this->connect($config);
    }

    protected function authenticate(array $config, \Github\Client $client)
    {
        if ('token' === $config[ 'method' ]) {
            $client->authenticate($config[ 'token' ], \Github\Client::AUTH_HTTP_TOKEN);
        } elseif ('password' === $config[ 'method' ]) {
            $client->authenticate($config[ 'username' ], $config[ 'password' ], \Github\Client::AUTH_HTTP_PASSWORD);
        } else {
            throw new \Exception("Invalid authentication method {$config['method']}");
        }
        return $this;
    }

    /**
     * Establish a connection.
     *
     * @param array $config
     *
     * @return $this
     *
     * @throws \Exception
     */
    public function connect(array $config)
    {
        $this->authenticate($config, $this->client);
        return $this;
    }

    /**
     * getRefs method.
     *
     * @param string $owner
     * @param string $repository
     *
     * @return \Codex\Git\Connection\RefCollection|Ref[]
     */
    public function getRefs(string $owner, string $repository)
    {
        $branches = $this->client->repo()->branches($owner, $repository);
        $tags     = $this->client->repo()->tags($owner, $repository);

        $all = new RefCollection();

        foreach ($branches as $branch) {
            $all->put($branch[ 'name' ], new Ref([
                'name'        => $branch[ 'name' ],
                'type'        => 'branch',
                'hash'        => $branch[ 'commit' ][ 'sha' ],
                'downloadUrl' => "https://github.com/{$owner}/{$repository}/archive/{$branch['name']}.zip",
            ]));
        }
        foreach ($tags as $tag) {
            $all->put($tag[ 'name' ], new Ref([
                'name'        => $tag[ 'name' ],
                'type'        => 'tag',
                'hash'        => $tag[ 'commit' ][ 'sha' ],
                'downloadUrl' => $tag[ 'zipball_url' ],
            ]));
        }

        return $all;
    }


    /**
     * downloadFile method.
     *
     * @param string $url
     *
     * @return string
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function downloadFile(string $url)
    {
        $builder = new \Github\HttpClient\Builder(new GuzzleClient());
        $client  = new \Github\Client($builder);
        $this->authenticate($this->config, $client);
        $builder->removePlugin(AddHostPlugin::class);
        $builder->addPlugin(new AddHostPlugin(UriFactoryDiscovery::find()->createUri('https://github.com')));
//        $client->setUrl('https://github.com/');
//        $builder->removePlugin(HeaderDefaultsPlugin::class);
//        $builder->addPlugin(new HeaderDefaultsPlugin([
//            'User-Agent' => 'php-github-api (http://github.com/KnpLabs/php-github-api)',
//        ]));
        $uri      = str_replace_first('https://github.com/', '', $url);
        $client   = $client->getHttpClient();
        $response = $client->get($uri);
        $body     = $response->getBody();
        $content  = $body->getContents();
        $body->close();

        return $content;
    }

    /**
     * getClient method.
     *
     * @return \Github\Client
     */
    public function getClient()
    {
        return $this->client;
    }

    public function getUrl(string $owner, string $repository)
    {
        return "https://github.com/{$owner}/{$repository}";
    }

    public function getDocumentUrl(string $owner, string $repository, string $path)
    {
        $args = [ $this->getUrl($owner, $repository), 'tree', $path ];
        return path_join(array_filter($args, 'is_string'));
    }
}
