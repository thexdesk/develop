<?php

namespace Codex\Git\Drivers;

use Codex\Git\Connection\Ref;
use Codex\Git\Connection\RefCollection;
use Codex\Git\Connection\WithZipDownloader;
use Http\Adapter\Guzzle6\Client as GuzzleClient;
use Http\Client\Common\Plugin\HeaderDefaultsPlugin;

class BitbucketDriver implements DriverInterface
{
    use WithZipDownloader;

    /** @var \Bitbucket\Client */
    protected $client;

    /** @var \Bitbucket\HttpClient\Builder */
    protected $builder;

    protected $config;

    public function __construct($config)
    {
        $this->config  = $config;
        $this->builder = new \Bitbucket\HttpClient\Builder(new GuzzleClient());
        $this->client  = new \Bitbucket\Client($this->builder);

        $this->connect($config);
    }

    protected function authenticate(array $config, \Bitbucket\Client $client)
    {
        if ('token' === $config[ 'method' ]) {
            $client->authenticate(\Bitbucket\Client::AUTH_OAUTH_TOKEN, $config[ 'token' ]);
        } elseif ('password' === $config[ 'method' ]) {
            $client->authenticate(\Bitbucket\Client::AUTH_HTTP_PASSWORD, $config[ 'username' ], $config[ 'password' ]);
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
     * @return \Codex\Git\Connection\RefCollection
     */
    public function getRefs(string $owner, string $repository)
    {
        $refs = $this->client->repositories()->users($owner)->refs($repository);
        $list = $refs->list([ 'pagelen' => 100 ]);

        $all = new RefCollection();
        foreach ($list[ 'values' ] as $ref) {
            $all->put($ref[ 'name' ], new Ref([
                'name'        => $ref[ 'name' ],
                'type'        => $ref[ 'type' ],
                'hash'        => $ref[ 'target' ][ 'hash' ],
                'downloadUrl' => "https://bitbucket.org/{$owner}/{$repository}/get/{$ref['name']}.zip",
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
        $builder = new \Bitbucket\HttpClient\Builder(new GuzzleClient());
        $client  = new \Bitbucket\Client($builder);
        $this->authenticate($this->config, $client);
        $client->setUrl('https://bitbucket.org/');
        $builder->removePlugin(HeaderDefaultsPlugin::class);
        $builder->addPlugin(new HeaderDefaultsPlugin([
            'User-Agent' => 'bitbucket-api-client/1.1',
        ]));
        $uri      = str_replace_first('https://bitbucket.org/', '', $url);
        $client   = $client->getHttpClient();
        $response = $client->get($uri);
        $body     = $response->getBody();
        $content  = $body->getContents();
        $body->close();

        return $content;
    }

    /**
     * getClient method
     *
     * @return \Bitbucket\Client
     */
    public function getClient()
    {
        return $this->client;
    }
}
