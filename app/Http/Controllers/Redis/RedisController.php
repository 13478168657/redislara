<?php

namespace App\Http\Controllers\Redis;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RedisController extends Controller
{
    protected $redis;
    protected $channel;
    public function __construct(){

        $redis = new \redis();
        $redis->connect('127.0.0.1',6379);
        $this->redis = $redis;
    }

    public function publish(Request $request,$type){
        $msg = "消息推送:".$type."\n";
        $channel = 'pub:'.$type;
        $res = $this->redis->publish($channel,$msg);
        echo $res."\n";
        return "发布成功";
    }
}
