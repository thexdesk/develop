<?php

namespace Codex\Phpdoc\Commands;

use Codex\Contracts\Revisions\Revision;
use Codex\Exceptions\Exception;
use Codex\Phpdoc\Serializer\Phpdoc\PhpdocStructure;

class GetRevisionPhpdoc
{
    /** @var \Codex\Contracts\Revisions\Revision */
    protected $revision;

    /**
     * GetRevisionPhpdoc constructor.
     *
     * @param \Codex\Contracts\Revisions\Revision $revision
     */
    public function __construct(Revision $revision)
    {
        $this->revision = $revision;
    }

    public function handle()
    {
        $rev = $this->revision;
        if ( ! $rev[ 'phpdoc.enabled' ]) {
            return;
        }
        $fs = $rev->getFiles();
        if ( ! $fs->exists($rev->path($rev[ 'phpdoc.xml_path' ]))) {
            throw Exception::make('Could not find structure.xml');
        }
        $xml = $fs->get($rev->path($rev[ 'phpdoc.xml_path' ]));
        $phpdoc = PhpdocStructure::deserialize($xml, 'xml');
        return $phpdoc;
    }
}
