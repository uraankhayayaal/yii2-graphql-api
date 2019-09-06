<?php

namespace app\models\schema;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;
use app\models\Post;

class QueryType extends ObjectType
{
    public function __construct()
    {
        $config = [
            'description' => 'Query methods',
            'fields' => function() {
                return [
                    'posts' => [
                        'type' => Type::listOf(Types::post()),
                        'description' => 'Get all posts',
                        'args' => [],
                        'resolve' => function($root, $args) {
                            $query = Post::find();
                            return $query->all();
                        }
                    ]
                ];
            }
        ];

        parent::__construct($config);
    }
}