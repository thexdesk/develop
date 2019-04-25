<?php


namespace Codex\Comments;

use Codex\Attributes\AttributeType as T;
use Codex\Attributes\AttributeDefinitionRegistry;
use Codex\Attributes\AttributeExtension;

class CommentsAttributeExtension extends AttributeExtension
{
    public function register(AttributeDefinitionRegistry $registry)
    {
        $comments = $registry->documents->child('comments', T::MAP)->api('DocumentCommentsConfig', [ 'new' ]);
        $comments->child('enabled', T::BOOL,false);
        $comments->child('driver', T::STRING);
        $comments->child('connection', T::STRING);
    }
}

