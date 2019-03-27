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

namespace Codex\Phpdoc\Documents;

class PhpdocMacros
{
    /**
     * Generate the PHPDoc method component.
     *
     * Possible hide options: signature,details,description,example,tags,inherited,modifiers,arguments,argumentTypes,argumentDefaults,returns,namespace,typeTooltip,typeTooltipClick
     *
     * @param bool   $isCloser
     * @param string $fqsen   The fully qualified namespace to the method
     * @param array  $options (optional)
     *
     * @example
     * codex:phpdoc:method("Codex\Codex::get()", { })
     *
     * @return string
     */
    public function method($isCloser = false, $fqsen = null, $options = [])
    {
        return $this->makeClosed('method', $fqsen, $options);
    }

    /**
     * Generate the PHPDoc method signature component.
     *
     * @param bool   $isCloser
     * @param string $fqsen   The fully qualified namespace to the method
     * @param array  $options (optional)
     *
     * @example
     * codex:phpdoc:method-signature("Codex\Codex::get()", { })
     *
     * @return string
     */
    public function methodSignature($isCloser = false, $fqsen = null, $options = [])
    {
        return $this->makeClosed('method-signature', $fqsen, $options);
    }

    /**
     * Generate the PHPDoc member list component.
     *
     * @param bool   $isCloser
     * @param string $fqsen   The fully qualified namespace to the class/interface/trait
     * @param array  $options (optional)
     *
     * @example
     * codex:phpdoc:member-list("Codex\Codex", { })
     *
     * @return string
     */
    public function memberList($isCloser = false, $fqsen = null, $options = [])
    {
        return $this->makeClosed('member-list', $fqsen, $options);
    }

    protected function props(array $data)
    {
        return json_encode($data, JSON_UNESCAPED_SLASHES);
    }

    protected function make(string $name, $isCloser = false, $fqsen = null, $options = [])
    {
        $options[ 'fqsen' ] = $options[ 'fqsen' ] ?? $fqsen;
        return $isCloser ? "</phpdoc-{$name}>" : "<phpdoc-{$name} props='{$this->props($options)}'>";
    }

    protected function makeClosed(string $name, $fqsen = null, $options = [])
    {
        $options[ 'fqsen' ] = $options[ 'fqsen' ] ?? $fqsen;
        return "<phpdoc-{$name} props='{$this->props($options)}'></phpdoc-{$name}>";
    }
}
