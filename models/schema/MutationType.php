<?php

namespace app\models\schema;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

use app\models\Post;

class MutationType extends ObjectType
{
    public function __construct()
    {
        $config = [
            'fields' => function() {
                return [
                    'post' => [
                        'type' => Types::postTypeMutation(),
                        'resolve' => function($root, $args){
                            return new Post();
                        }
                    ]
                ];
            }
        ];

        parent::__construct($config);
    }
}