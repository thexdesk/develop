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

use Codex\Addons\Annotations as CA;
use Codex\Documents\Processors\Links\Link;

/**
 * This is the class Links.
 *
 * @author Robin Radic
 * @CA\Link("phpdoc", description="Transforms phpdoc links")
 */
class PhpdocLinks
{
    /** @var \Codex\Processors\Links\Link */
    protected $action;

    /** @var string */
    protected $query;

    public function handle(Link $link)
    {
        $this->action = $link;

        $phpdoc = codex()->phpdoc;
        $revision = $link->getRevision();
        $fullName = $link->param(0, $revision->config('phpdoc.default_class'));
//        $basePath  = $phpdoc->getRoutePath();
//        $entity    = $phpdoc->makeEntity($fullName);
        $query = $phpdoc->makeEntity($fullName)->fullName;
        $action = $link->hasModifier('drawer') ? 'drawer' : 'navigate';
        $modifiers = [];
        foreach (['type', 'popover'] as $modifier) {
            if ($link->hasModifier($modifier)) {
                $modifiers[] = $modifier;
            }
        }
        foreach (['!icon', '!styling'] as $modifier) {
            if (false === $link->hasModifier($modifier)) {
                $modifiers[] = substr($modifier, 1);
            }
        }

        $link->replaceElement('phpdoc-link', $link->getElement()->textContent, [
            'props' => json_encode(compact('query', 'action', 'modifiers')),
        ]);
    }
}
