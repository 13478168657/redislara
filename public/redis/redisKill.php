<?php


$redis = new redis();
$redis->connect('127.0.0.1',6379);

$goodKey = "sk:01";
$userKey = "sk:01:user";


$script = <<<EOF
   local userid = KEYS[1];
   local goodid = KEYS[1];
   local qtkey="sk:"..prodid..":qt";
   local usersKey="sk:"..prodid.":usr'; 
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
$skuNum = $redis->get($goodKey);
print_r("" == "0");
if($skuNum == null || $skuNum == ""){
	echo "未开始";
	return;
}
if($skuNum == 0){
	echo "秒杀结束\n";
	return;
}
$f = fopen('log.txt','a+');
fwrite($f,$skuNum."\n");
fclose($f);
$redis->watch($goodKey);
$userid = mt_rand(0,999999);
$exec = $redis->multi()
	->decr($goodKey)
 	->sadd($userKey,$userid)
	->exec();

if($exec){
	echo "秒杀成功\n";
}else{
	echo "秒杀失败\n";
	$fs = fopen('kill.txt','a+');
	fwrite($fs,"秒杀失败:数量：".$skuNum."\n");
	fclose($fs);
}
