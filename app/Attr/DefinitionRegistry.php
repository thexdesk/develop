<?php

namespace App\Attr;

/**
 * @property-read DefinitionGroup $codex
 * @property-read DefinitionGroup $projects
 * @property-read DefinitionGroup $revisions
 * @property-read DefinitionGroup $documents
 */
class DefinitionRegistry
{
    /** @var DefinitionGroup[] */
    protected $groups = [];

    public function __construct()
    {
        $codex     = $this->addGroup('codex');
        $projects  = $this->addGroup('projects')->parent($codex);
        $revisions = $this->addGroup('revisions')->parent($projects);
        $documents = $this->addGroup('documents')->parent($revisions);
    }

    public function addGroup(string $name)
    {
        return $this->groups[ $name ] = with(new DefinitionGroup())->name($name)->type(Type::MAP);
    }

    public function keys()
    {
        return array_keys($this->groups);
    }

    public function getGroup(string $name)
    {
        return $this->groups[ $name ];
    }

    /**
     * Returns the group after ensuring all the attributes that should inherit and merge are copied from the parent
     *
     * @param string $name
     *
     * @return \App\Attr\DefinitionGroup
     */
    public function resolveGroup(string $name)
    {
        $group = $this->getGroup($name);
        if ( ! $group->hasParent()) {
            return $group;
        }
        $parent = $group->parent;
        foreach (array_merge($group->inheritKeys, $group->mergeKeys) as $sourceKey => $targetKey) {
            if (is_int($sourceKey)) {
                $sourceKey = $targetKey;
            }
            if ( ! $parent->children->has($sourceKey) || $group->children->has($targetKey)) {
                continue;
            }
            $source = $parent->children->get($sourceKey);
            $this->addSourceToTarget($group, $targetKey, $source);
        }
        return $group;
    }

    protected function addSourceToTarget(Definition $target, $targetKey, Definition $source)
    {
        $targetChild = $target
            ->child($targetKey, $source->type)
            ->api($source->api)
            ->default($source->default)
            ->noApi($source->noApi);

        foreach ($source->children as $child) {
            $this->addSourceToTarget($targetChild, $child->name, $child);
        }
    }

    /** @noinspection MagicMethodsValidityInspection */
    public function __get($key)
    {
        if (array_key_exists($key, $this->groups)) {
            return $this->getGroup($key);
        }
    }

}
