<?php namespace Codex\ComposerPlugin\Installer;

use Composer\Installer\LibraryInstaller;
use Composer\Package\PackageInterface;

class AddonInstaller extends LibraryInstaller
{
    protected $codexAddonsDir = 'codex-addons';


    /**
     * Determines whether a package should be processed
     *
     * @param  string
     *
     * @return bool
     */
    public function supports($packageType)
    {
        return 'codex-addon' === $packageType;
    }

    public function getInstallPath(PackageInterface $package)
    {
        $this->initializeCodexAddonsDir();

        $basePath  = ($this->codexAddonsDir ? $this->codexAddonsDir . '/' : '') . $package->getPrettyName();
        $targetDir = $package->getTargetDir();

        return $basePath . ($targetDir ? '/' . $targetDir : '');
    }

    protected function initializeCodexAddonsDir()
    {
        $this->filesystem->ensureDirectoryExists($this->codexAddonsDir);
        $this->codexAddonsDir = realpath($this->codexAddonsDir);
    }

}
