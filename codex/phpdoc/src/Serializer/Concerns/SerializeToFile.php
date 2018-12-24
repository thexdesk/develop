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

namespace Codex\Phpdoc\Serializer\Concerns;

use Illuminate\Filesystem\Filesystem;
use JMS\Serializer\Annotation as Serializer;

/**
 * This is the SerializeToFile trait.
 *
 * @author  Robin Radic
 */
trait SerializeToFile
{
    /**
     * @var \Illuminate\Filesystem\Filesystem
     * @Serializer\Exclude()
     */
    private $fs;

    public function serializeToFile($filePath): self
    {
        if (null === $this->fs) {
            $this->fs = new Filesystem();
        }
        $dirPath = path_get_directory($filePath);
        if (false === $this->fs->exists($dirPath)) {
            $this->fs->makeDirectory($dirPath, 0755, true);
        }
        $filePath = str_ensure_right($filePath, '.php');
        if ($this->fs->exists($filePath)) {
            $this->fs->delete($filePath);
        }

        $this->fs->put($filePath, "<?php\nreturn ".var_export($this->toArray(), true).';');

        return $this;
    }
}
