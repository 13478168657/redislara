<?php


$redis = new redis();
$redis->connect('127.0.0.1',6379);

$goodKey = "sk:01";
$userKey = "sk:01:user";


$script = <<<EOF
   local userid = KEYS[1];
   local goodid = KEYS[2];
   local qtkey="sk:"..goodid;
   local usersKey="sk:"..goodid..":user";
   local userExists=redis.call("sismember",usersKey,userid);
   if tonumber(userExists)==1 then 
      return 2;
   end
   local num= redis.call("get" ,qtkey);
   if tonumber(num)<=0 then 
      return 0; 
   else 
      redis.call("decr",qtkey);
      redis.call("sadd",usersKey,userid);
   end
   return 1;

EOF;
$userid = mt_rand(0,9999999);
print_r($userid);
$ret = $redis->eval($script, [$userid,"01"],2);
$f = fopen("kill.txt","a+");
if($ret==2){
   fwrite($f,"秒杀失败\n");
}
if($ret ==0){
   fwrite($f,"秒杀结束\n");
}
if($ret == 1){
   fwrite($f,"秒杀成功\n");
}
fclose($f);
print_r(777);
