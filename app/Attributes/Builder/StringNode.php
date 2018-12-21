<?php

namespace App\Attributes\Builder;

use Symfony\Component\Config\Definition\Exception\InvalidTypeException;
use Symfony\Component\Config\Definition\ScalarNode;

class StringNode extends ScalarNode
{
    protected function validateType($value)
    {
        if (!is_string($value) && null !== $value) {
            $ex = new InvalidTypeException(sprintf('Invalid type for path "%s". Expected string, but got %s.', $this->getPath(), \gettype($value)));
            if ($hint = $this->getInfo()) {
                $ex->addHint($hint);
            }
            $ex->setPath($this->getPath());

            throw $ex;
        }
    }

    /**
     * {@inheritdoc}
     */
    protected function getValidPlaceholderTypes(): array
    {
        return ['string'];
    }
}
