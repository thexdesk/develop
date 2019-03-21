<?php

namespace Codex\Comments\Drivers;

use Codex\Comments\Contracts\CommentDriver as CommentDriverContract;
use Codex\Mergable\Model;

abstract class CommentDriver implements CommentDriverContract
{

    public function render(array $options = [])
    {

        return '';
    }
}
