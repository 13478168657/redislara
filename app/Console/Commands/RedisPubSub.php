<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class RedisPubSub extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pub:sub_redis';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();


    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        $redis = new \redis();
        $redis->pconnect('127.0.0.1',6379);//pconnect，连接一个redis实例或重复使用已经建立的连接，没有时间限制，除非将进程强制关闭

        $redis->psubscribe(['pub:*'],function($redis, $pattern, $chan, $msg) {
            echo "Pattern: $pattern\n";
            echo "Channel: $chan\n";
            echo "Payload: $msg\n";
        });
    }
}
