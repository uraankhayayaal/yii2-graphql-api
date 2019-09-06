<?php

namespace app\models\schema;

use GraphQL\Type\Definition\ObjectType;

class CommentType extends ObjectType
{
    public function __construct()
    {
        $config = [
            'description' => 'Comment',
            'fields' => function() {
                return [

                ];
            }
        ];

        parent::__construct($config);
    }
}