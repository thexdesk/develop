<?php

namespace Codex\Phpdoc\Documents;

use Codex\Documents\Processors\Links\Link;
use Codex\Phpdoc\FQSEN;

class PhpdocLinks
{

    public function handle(Link $link)
    {

        $phpdoc   = codex()->phpdoc;
        $project  = $link->getProject();
        $revision = $link->getRevision();
        $fullName = $link->param(0, $revision->attr('phpdoc.default_class'));
        $fqsen    = new FQSEN($fullName);
        if ( ! $fqsen->isValid) {
            return;
        }
        $action    = $link->hasModifier('drawer') ? 'drawer' : 'navigate';
        $modifiers = [];
        foreach ([ 'type', 'popover' ] as $modifier) {
            if ($link->hasModifier($modifier)) {
                $modifiers[] = $modifier;
            }
        }
        foreach ([ '!icon', '!styling' ] as $modifier) {
            if (false === $link->hasModifier($modifier)) {
                $modifiers[] = substr($modifier, 1);
            }
        }

        $el            = $link->getElement();
        $linkText      = $el->textContent;
        $linkProps     = json_encode([
            'fqsen'     => (string)$fqsen,
            'action'    => $action,
            'modifiers' => $modifiers,
        ], JSON_UNESCAPED_SLASHES);
        $manifestProps = json_encode([
            'project'  => $project->getKey(),
            'revision' => $revision->getKey(),
        ], JSON_UNESCAPED_SLASHES);

        $link->replaceElementHtml("
<phpdoc-manifest-provider props='{$manifestProps}'>
    <phpdoc-link props='{$linkProps}'>{$linkText}</phpdoc-link>
</phpdoc-manifest-provider>
");
    }
}
