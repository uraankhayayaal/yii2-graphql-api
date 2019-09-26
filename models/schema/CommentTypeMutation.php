<?php

namespace app\models\schema;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

use app\models\Comment;

class CommentTypeMutation extends ObjectType
{
    public function __construct()
    {
        $config = [
            'fields' => function() {
                return [
                    // Метод для создания Comment
                    'create' => [
                        'type' => Type::boolean(),
                        'description' => 'Create Comment',
                        'args' => [
                            'text' => Type::nonNull(Type::string()),
                            'post_id' => Type::nonNull(Type::int()),
                        ],
                        'resolve' => function(Comment $comment, $args){
                            // в $comment получаем модель с выше из типа мутации
                            $comment->setAttributes($args);
                            // created_at будем задавать на сервере
                            $comment->created_at = time();
                            return $comment->save();
                        }
                    ]
                ];
            }
        ];

        parent::__construct($config);
    }
}