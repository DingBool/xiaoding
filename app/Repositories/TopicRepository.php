<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017-06-13
 * Time: 14:09
 */

namespace App\Repositories;


use App\Topic;
use Illuminate\Http\Request;

class TopicRepository
{
    public function getTopicsForTagging(Request $request)
    {
        $data = $request->query('q');
        //    $topics = \App\Topic::select(['id','name'])->where('name','like','%'.$data.'%')->get();   //原生写法
        $topics = Topic::where('name','like','%'.$data.'%')->get(['id','name']);   //orm   写法
        if($topics->isEmpty())
        {
            $dataarray = ['name' => $data,'questions_count' => 1];
            $topic = Topic::create($dataarray);
            $topics = [$topic];
        }
        return $topics;
    }
}