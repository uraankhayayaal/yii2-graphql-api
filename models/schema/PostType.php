<?php 

namespace app\models\schema;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

class PostType extends ObjectType
{
    public function __construct()
    {
        $config = [
            'description' => "Post",
            'fields' => function() {
                return [
                    'title' => [
                        'type' => Type::string(),
                        'description' => "Заголовок",
                    ],
                    'body' => [
                        'type' => Type::string(),
                        'description' => "Содержание",
                    ],
                    'is_public' => [
                        'type' => Type::boolean(),
                        'description' => "Открыт",
                    ],
                    'created_at' => [
                        'type' => Type::int(),
                        'description' => "Создан",
                    ],
                ];
            }
        ];

        parent::__construct($config);
    }
}