<?php

namespace app\models\schema;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

use app\models\Post;
use app\models\Comment;

class MutationType extends ObjectType
{
    public function __construct()
    {
        $config = [
            'fields' => function() {
                return [
                    // Добавляем модель Post в мутацию
                    'post' => [
                        // Модель Post имеет свой тип мутации
                        'type' => Types::postTypeMutation(),
                        'resolve' => function($root, $args){
                            // отправляем модель ниже в мутацию модели Post
                            return new Post();
                        }
                    ],
                    'comment' => [
                        // Модель Comment имеет свой тип мутации
                        'type' => Types::commentTypeMutation(),
                        'resolve' => function($root, $args){
                            // отправляем модель ниже в мутацию модели Comment
                            return new Comment();
                        }
                    ]
                ];
            }
        ];

        parent::__construct($config);
    }
}