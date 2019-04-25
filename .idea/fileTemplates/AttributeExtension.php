<?php
#parse("PHP File Header.php")
#if (${NAMESPACE})
namespace ${NAMESPACE};
#end

use Codex\Attributes\AttributeType as T;
use Codex\Attributes\AttributeDefinitionRegistry;
use Codex\Attributes\AttributeExtension;

class ${PACKAGE_NAME}AttributeExtension} extends AttributeExtension 
{
    public function register(AttributeDefinitionRegistry $registry)
    {
        \$${PACKAGE_NAME.toLowerCase()} = $registry->add(${PACKAGE_NAME.toLowerCase()});
        \$${PACKAGE_NAME.toLowerCase()}->parent($registry->codex);
        \$${PACKAGE_NAME.toLowerCase()}->mergeKeys([]);
        \$${PACKAGE_NAME.toLowerCase()}->inheritKeys([ 'processors', 'layout', 'cache' ]);
        \$${PACKAGE_NAME.toLowerCase()}->child('inherits', T::ARRAY(T::STRING) );
        \$${PACKAGE_NAME.toLowerCase()}->child('changes', T::MAP );
    }
}
