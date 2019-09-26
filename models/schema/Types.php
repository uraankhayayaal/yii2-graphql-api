<?php

namespace app\models\schema;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\UnionType;

class Types {
    private static $query;
    private static $mutation;

    private static $post;
    private static $comment;

    public static function query()
    {
        return self::$query ?: (self::$query = new QueryType());
    }

    public static function mutation()
    {
        return self::$mutation ?: (self::$mutation = new MutationType());
    }

    public static function post()
    {
        return self::$post ?: (self::$post = new \app\models\schema\PostType());
    }

    public static function comment()
    {
        return self::$comment ?: (self::$comment = new \app\models\schema\CommentType());
    }

    public static $postTypeMutation;
    public static function postTypeMutation()
    {
        return self::$postTypeMutation ?: (self::$postTypeMutation = new \app\models\schema\PostTypeMutation());
    }

    public static $commentTypeMutation;
    public static function commentTypeMutation()
    {
        return self::$commentTypeMutation ?: (self::$commentTypeMutation = new \app\models\schema\CommentTypeMutation());
    }
}