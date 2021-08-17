<?php


$redis = new redis();
$redis->connect('127.0.0.1',6379);


$script = <<<EOF
   local userid = KEYS[1];
   local goodid = KEYS[2];
   redis.call("decr",goodid);
   return 1;
EOF;
$ret = $redis->eval($script, [3,'sk:01'],2);
var_dump($ret);
print_r(777);
