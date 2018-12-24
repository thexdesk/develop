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

namespace Codex\Phpdoc;

class Entity
{
    const PROPERTY = 'property';
    const METHOD = 'method';
    const CONSTANT = 'constant';

    /** @var string */
    protected $original;

    /** @var string */
    public $type;

    /** @var string */
    public $fullName;

    /** @var bool */
    public $isEntity;

    /** @var string */
    public $entityName;

    /** @var bool */
    public $isMember;

    /** @var string */
    public $memberSignature;

    /** @var string */
    public $memberType;

    /** @var string */
    public $memberName;

    /** @var bool */
    public $isProperty;

    /** @var bool */
    public $isMethod;

    /** @var bool */
    public $isConstant;

    /** @var bool */
    public $isValid;

    /**
     * Entity constructor.
     *
     * @param $str
     */
    public function __construct(string $str)
    {
        $this->update($str);
    }

    protected function reset()
    {
        $this->original = null;
        $this->entityName = null;
        $this->isEntity = false;
        $this->isMember = false;
        $this->memberName = null;
        $this->memberSignature = null;
        $this->isMethod = false;
        $this->isProperty = false;
        $this->isConstant = false;
        $this->isValid = true;
    }

    /**
     * update the entity with a new value.
     *
     * @param $str
     */
    public function update($str)
    {
        $this->reset();
        $this->original = $str = str_ensure_left($str, '\\');
        $this->isValid = static::isValid($str);
        if (!$this->isValid) {
            return;
        }
        $this->fullName = $str;

        if (str_contains($this->fullName, '::')) {
            $this->entityName = head(explode('::', $this->fullName));
            $this->isMember = true;
            $this->memberSignature = last(explode('::', $this->fullName));
            $this->memberType = static::memberSignatureType($this->memberSignature);
            $this->memberName = static::cleanMemberSignature($this->memberSignature);
            $this->isProperty = $this->memberType === static::PROPERTY;
            $this->isMethod = $this->memberType === static::METHOD;
            $this->isConstant = $this->memberType === static::CONSTANT;
            $this->type = $this->memberType;
        } else {
            $this->entityName = $this->fullName;
            $this->isEntity = true;
            $this->type = 'entity';
        }

        $this->entityName = str_remove_left($this->entityName, '\\');
    }

    public function __toString(): string
    {
        return $this->fullName;
    }

    /**
     * If given a memberSignature, it will return either property, method or constant.
     *
     * @param string $signature
     *
     * @return string
     */
    public static function memberSignatureType(string $signature): string
    {
        if (ends_with($signature, '()')) {
            return starts_with($signature, '$') ? static::PROPERTY : static::METHOD;
        } else {
            return starts_with($signature, '$') ? static::PROPERTY : static::CONSTANT;
        }
    }

    /**
     * cleans a memberSignature and returns the memberName.
     *
     * @param string $signature
     *
     * @return string
     */
    public static function cleanMemberSignature(string $signature): string
    {
        return str_remove_left(str_remove_right($signature, '()'), '$');
    }

    public static function isValid($str)
    {
        $matches = [];
        $result = preg_match(
            '/^\\\\([a-zA-Z_\\x7f-\\xff][a-zA-Z0-9_\\x7f-\\xff\\\\]*)?(?:[:]{2}\\$?([a-zA-Z_\\x7f-\\xff][a-zA-Z0-9_\\x7f-\\xff]*))?(?:\\(\\))?$/',
            $str,
            $matches
        );
        if (0 === $result) {
            return false;
        }

        return true;
    }
}
