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
                    // Добавляем модель Post в мутацию
                    'post' => [
                        // Модель Post имеет свой тип мутации
                        'type' => Types::postTypeMutation(),
                        'resolve' => function($root, $args){
                            // отправляем модель ниже в мутацию модели Post
                            return new Post();
                        }
                    ]
                ];
            }
        ];

        parent::__construct($config);
    }
}