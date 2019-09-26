<?php

namespace app\models\schema;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

class CommentType extends ObjectType
{
    public function __construct()
    {
        $config = [
            'description' => 'Comment',
            'fields' => function() {
                return [
                    'id' => [
                        'type' => Type::int(),
                        'description' => "Уникальный идентификатор",
                    ],
                    'text' => [
                        'type' => Type::string(),
                        'description' => "Содержание комментария",
                    ],
                    'post_id' => [
                        'type' => Type::int(),
                        'description' => "Пост к которому относится комментарий",
                    ],
                    'created_at' => [
                        'type' => Type::int(),
                        'description' => "Время создания комментария",
                    ],
                    'post' => [
                        'type' => Types::post(),
                        'description' => "Пост комментария",
                        'resolve' => function(\app\models\Comment $comment){
                            return $comment->post;
                        }
                    ]
                ];
            }
        ];

        parent::__construct($config);
    }
}