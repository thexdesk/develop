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

namespace Codex\Phpdoc\Serializer;

use Codex\Phpdoc\Serializer\Concerns\DeserializeFromFile;
use Codex\Phpdoc\Serializer\Concerns\SerializeToFile;
use Codex\Phpdoc\Contracts\Serializer\SelfSerializable;
use Codex\Phpdoc\Serializer\Concerns\SerializesSelf;
use Codex\Phpdoc\Serializer\Concerns\WithResponse;
use Illuminate\Contracts\Support\Responsable;
use JMS\Serializer\Annotation as Serializer;

class AddonConfig implements SelfSerializable, Responsable
{
    use SerializesSelf,
        DeserializeFromFile,
        SerializeToFile,
        WithResponse;

    /**
     * @var bool
     * @Serializer\Type("boolean")
     */
    private $enabled;

    /**
     * @var string
     * @Serializer\Type("string")
     * @Serializer\SerializedName("document_slug")
     */
    private $documentSlug;

    /**
     * @var string
     * @Serializer\Type("string")
     */
    private $title;

    /**
     * @var string
     * @Serializer\Type("string")
     * @Serializer\SerializedName("xml_path")
     */
    private $xmlPath;

    /**
     * @var string
     * @Serializer\Type("string")
     * @Serializer\SerializedName("doc_path")
     */
    private $docPath;

    /**
     * @var string
     * @Serializer\Type("string")
     * @Serializer\SerializedName("default_class")
     */
    private $defaultClass;

    /**
     * @return bool
     */
    public function isEnabled(): bool
    {
        return $this->enabled;
    }

    /**
     * @param bool $enabled
     *
     * @return AddonConfig
     */
    public function setEnabled(bool $enabled): self
    {
        $this->enabled = $enabled;

        return $this;
    }

    /**
     * @return string
     */
    public function getDocumentSlug(): string
    {
        return $this->documentSlug;
    }

    /**
     * @param string $documentSlug
     *
     * @return AddonConfig
     */
    public function setDocumentSlug(string $documentSlug): self
    {
        $this->documentSlug = $documentSlug;

        return $this;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     *
     * @return AddonConfig
     */
    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return string
     */
    public function getXmlPath(): string
    {
        return $this->xmlPath;
    }

    /**
     * @param string $xmlPath
     *
     * @return AddonConfig
     */
    public function setXmlPath(string $xmlPath): self
    {
        $this->xmlPath = $xmlPath;

        return $this;
    }

    /**
     * @return string
     */
    public function getDocPath(): string
    {
        return $this->docPath;
    }

    /**
     * @param string $docPath
     *
     * @return AddonConfig
     */
    public function setDocPath(string $docPath): self
    {
        $this->docPath = $docPath;

        return $this;
    }

    /**
     * @return string
     */
    public function getDefaultClass(): string
    {
        return $this->defaultClass;
    }

    /**
     * @param string $defaultClass
     *
     * @return AddonConfig
     */
    public function setDefaultClass(string $defaultClass): self
    {
        $this->defaultClass = $defaultClass;

        return $this;
    }
}
