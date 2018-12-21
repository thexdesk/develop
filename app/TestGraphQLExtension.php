<?php

namespace App;

use GraphQL\Executor\ExecutionResult;
use Nuwave\Lighthouse\Schema\AST\DocumentAST;
use Nuwave\Lighthouse\Schema\Extensions\ExtensionRequest;

class TestGraphQLExtension extends \Nuwave\Lighthouse\Schema\Extensions\GraphQLExtension
{
    /**
     * Manipulate the schema.
     *
     * @param DocumentAST $documentAST
     *
     * @return DocumentAST
     */
    public function manipulateSchema(DocumentAST $documentAST)
    {
//        $documentAST->typeExtensions()[0]->
        return $documentAST;
    }

    /**
     * Handle request start.
     *
     * @param ExtensionRequest $request
     */
    public function requestDidStart(ExtensionRequest $request)
    {
        return;
    }

    /**
     * Handle batch request start.
     *
     * @param int index
     */
    public function batchedQueryDidStart($index)
    {
        return;
    }

    /**
     * Handle batch request end.
     *
     * @param ExecutionResult $result
     * @param int             $index
     */
    public function batchedQueryDidEnd(ExecutionResult $result, $index)
    {
        return;
    }

    /**
     * Manipulate the GraphQL response.
     *
     * @param array    $response
     * @param \Closure $next
     *
     * @return array
     */
    public function willSendResponse(array $response, \Closure $next)
    {
        return $next($response);
    }


    /**
     * The extension name controls under which key the extensions shows up in the result.
     *
     * @return string
     */
    public static function name()
    {
        return 'test-graph';
    }

    /**
     * Specify data which should be serialized to JSON.
     *
     * @link  http://php.net/manual/en/jsonserializable.jsonserialize.php
     *
     * @return mixed data which can be serialized by <b>json_encode</b>,
     *               which is a value of any type other than a resource.
     *
     * @since 5.4.0
     */
    public function jsonSerialize()
    {
        return [];
    }
}
