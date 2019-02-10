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
     * Generate the PHPDoc method signature component.
     *
     * Possible hide options: inherited,modifiers,arguments,argumentTypes,argumentDefaults,returns,namespace,typeTooltip,typeTooltipClick
     *
     * @param bool   $isCloser
     * @param string $query
     * @param bool   $inline   (optional)
     * @param string $hide     (optional) An string containing comma separated values with names of to hide
     *
     * @example
     * codex:phpdoc:method:signature('Codex\Codex::get()', true, 'namespace,tags')
     *
     * @return string
     */
    public function methodSignature($isCloser = false, $fqsen, $inline = false, $hide = '')
    {
        $hide = $this->transformHideCsv($hide);
        $loader = false;
        $props = $this->toJson(compact('fqsen', 'inline', 'hide', 'loader'));

        return "<phpdoc-method-signature props='{$props}'></phpdoc-method-signature>";
    }

    /**
     * Generate the PHPDoc method component.
     *
     * Possible hide options: signature,details,description,example,tags,inherited,modifiers,arguments,argumentTypes,argumentDefaults,returns,namespace,typeTooltip,typeTooltipClick
     *
     * @param bool   $isCloser
     * @param string $query    The fully qualified namespace to the method
     * @param bool   $collapse (optional) Makes the method component collapsible
     * @param bool   $closed   (optional) Used with $collapse. Makes the method component collapsed by default
     * @param string $hide     (optional) An string containing comma separated values with names of to hide
     *
     * @example
     * codex:phpdoc:method('Codex\Codex::get()', true, true, 'namespace,tags')
     *
     * @return string
     */
    public function method($isCloser = false, $fqsen, $collapse = false, $closed = false, $hide = '')
    {
        $hide = $this->transformHideCsv($hide);
        $loader = false;
        $props = json_encode(compact('fqsen', 'collapse', 'closed', 'hide', 'loader'));
        return "<phpdoc-method class=\"boxed\" props='{$props}'></phpdoc-method>";
    }

    public function listMembers($isCloser = false, $query)
    {
        return "<phpdoc-member-list query=\"{$query}\" no-click></phpdoc-member-list>";
    }

    public function file($isCloser = false, $query, $modifiers = '')
    {
        return "<phpdoc-file query=\"{$query}\" {$modifiers}></phpdoc-file>";
    }

    protected function transformHideCsv($hide)
    {
        $hide = $this->csvToArray($hide);

        return array_combine($hide, array_fill(0, \count($hide), true));
    }

    protected function csvToArray($str)
    {
        return array_map('trim', explode(',', $str));
    }

    protected function toJson($data, $options = 0)
    {
        return json_encode($data, $options);
    }
}
