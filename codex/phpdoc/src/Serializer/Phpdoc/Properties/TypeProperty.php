<?php


namespace Codex\Phpdoc\Serializer\Phpdoc\Properties;

use Codex\Phpdoc\Serializer\Annotations\Attr;
use JMS\Serializer\Annotation as Serializer;


trait TypeProperty
{

    /**
     * @var string
     * @Serializer\Type("string")
     * @Serializer\XmlAttribute()
     * @Serializer\Accessor(setter="setType")
     * @Attr()
     */
    private $type;

    /**
     * @var string[]
     * @Serializer\Type("LaravelCollection<string>")
     * @Attr(type="string", array=true)
     */
    private $types;

    public function setType($type)
    {
        if ($type === '') {
            $type = 'mixed';
        }
        $this->type  = $type;
        $this->types = [];
        if (is_string($type)) {
            $this->types = explode('|', $type);
        }
        $this->type = $type;
        return $this;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * getTypes method
     *
     * @return \Codex\Phpdoc\Serializer\Handler\LaravelCollection|string[]
     */
    public function getTypes()
    {
        return $this->types;
    }
}
