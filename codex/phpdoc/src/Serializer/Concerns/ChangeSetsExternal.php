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

use JMS\Serializer\Annotation as Serializer;

trait ChangeSetsExternal
{
    /**
     * @var \Closure
     * @Serializer\Exclude()
     */
    private $changer;

    /**
     * @var \Codex\Phpdoc\Serializer\Concerns\SerializesSelf
     * @Serializer\Exclude()
     */
    private $changerSource;

    /**
     * @var bool
     * @Serializer\Exclude()
     */
    private $changerChecked;

    public function triggerChange(): self
    {
        if ($this->hasChanger()) {
            $this->checkIfSerializable();
            \call_user_func($this->changer, $this->changerSource);
        }

        return $this;
    }

    /**
     * setChanger method.
     *
     * @param \Closure            $changer       The closure that changes the external data. Will be passed the changerSource serializable class that should be used to read the data
     * @param null|SerializesSelf $changerSource The source serializable that should be used to read the changed data from. Defaults to null, in which case $this class will be used
     *
     * @return static
     */
    public function setChanger(\Closure $changer, SerializesSelf $changerSource = null): self
    {
        $this->changer = $changer;
        $this->changerSource = $changerSource ?? $this;

        return $this;
    }

    public function hasChanger()
    {
        return null !== $this->changer;
    }

    private function checkIfSerializable()
    {
        if ($this->changerChecked) {
            return true;
        }
        $traits = class_uses_recursive($this->changerSource);
        if (false === \in_array(SerializesSelf::class, $traits, true)) {
            throw new \RuntimeException('The ChangeSetExternal target should be using '.SerializesSelf::class);
        }
        $this->changerChecked = true;
    }
}
