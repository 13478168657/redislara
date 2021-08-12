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
        $this->channel = "mypublish";
    }

    public function publish(Request $request){
        $msg = "消息推送";
        $this->redis->publish($this->channel,$msg);

        return "发布成功";
    }
}
