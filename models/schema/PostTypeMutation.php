<?php

namespace app\models\schema;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

use app\models\Post;

class PostTypeMutation extends ObjectType
{
    public function __construct()
    {
        $config = [
            'fields' => function() {
                return [
                    // Метод для создания Post
                    'create' => [
                        'type' => Type::string(),
                        'description' => 'Create post',
                        'args' => [
                            'title' => Type::nonNull(Type::string()),
                            'body' => Type::string(),
                            'is_public' => Type::int(),
                            'created_at' => Type::int(),
                        ],
                        'resolve' => function(Post $post, $args){
                            // в $post получаем модель с выше из типа мутации
                            $post->setAttributes($args);
                            return $post->save();
                        }
                    ]
                ];
            }
        ];

        parent::__construct($config);
    }
}