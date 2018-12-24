<?php  /** @noinspection PhpIncompatibleReturnTypeInspection */

namespace Codex\Git\Support;

/**
 * This is the class RevisionCollectionSemverMixin.
 *
 * @package Codex\Semver
 * @author  Robin Radic
 * @mixin \Codex\Revisions\RevisionCollection
 */
class GitRevisionCollectionMixin
{
    /** @return \Illuminate\Support\Collection|string[] */
    public function branches()
    {
        return function () {
            return $this->loadable()->filter(function ($configFilePath, $revisionKey) {
                return false === Version::isValid($revisionKey);
            })->keys();
        };
    }

    /** @return \Illuminate\Support\Collection|string[] */
    public function versions()
    {
        return function () {
            return $this->loadable()->filter(function ($configFilePath, $revisionKey) {
                return Version::isValid($revisionKey);
            })->keys();
        };
    }

    /** @return boolean */
    public function hasVersions()
    {
        return function () {
            return $this->versions()->isNotEmpty();
        };
    }

    /** @return string */
    public function getLatestVersion()
    {
        return function () {
            return $this->getSortedVersions()->first();
        };
    }

    /** @return \Illuminate\Support\Collection|string[] */
    public function getSortedVersions()
    {
        return function () {
            return $this->versions()->sort(function ($one, $two) {
                return Version::gt((string)$one, (string)$two) ? -1 : 1;
            });
        };
    }

    /** @return \Illuminate\Support\Collection|string[] */
    public function getSortedBranches()
    {
        return function () {
            return $this->branches()->sort(function ($one, $two) {
                return strcmp((string)$one, (string)$two);
            });
        };
    }

}
