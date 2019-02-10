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
//        $basePath  = $phpdoc->getRoutePath();
//        $entity    = $phpdoc->makeEntity($fullName);
        $fqsen     = new FQSEN($fullName);
        $fqns      = $fqsen->fullName;
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

        $el           = $link->getElement();
        $linkProps    = json_encode(compact([
            'fqsen'     => (string)$fqsen,
            'action'    => $action,
            'modifiers' => $modifiers,
        ]));
        $contentProps = json_encode([
            'project'  => $project->getKey(),
            'revision' => $revision->getKey(),
        ]);
//        $linkEl              = \FluentDOM::create()->element('phpdoc-link', [ 'props' => $linkProps ]);
//        $linkEl->textContent = $link->getElement()->textContent;
//        $link->replaceElement('phpdoc-content', '', [ 'props' => $contentProps ])->append($linkEl);
//        project='{$project}' revision='{$revision}'
        $link->replaceElementHtml("
<phpdoc-content props='{$contentProps}'>
    <phpdoc-link props='{$linkProps}'>{$el->textContent}</phpdoc-link>
</phpdoc-content>        
        ");
    }
}
