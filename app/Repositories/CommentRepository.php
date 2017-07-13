<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017-06-13
 * Time: 13:40
 */

namespace App\Repositories;


use App\Comment;

class CommentRepository
{
    public function create(array $attributes)
    {
        return Comment::create($attributes);
    }
}