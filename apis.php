<?php
class CheckRedis {
	public static function Run()
    {
		try {
			if (!extension_loaded('redis')) {
				throw new \Exception('检测到未安装Reids扩展，请现在当前PHP'.PHP_VERSION.'扩展中安装Redis扩展');
			}
			$redis = new Redis();
			$redis->connect('127.0.0.1', 6379);
		}
		catch (\Exception $error) {
			echo $error->getMessage();
			exit;
		}
		// $redis->auth('dong2002');
		// 允许每分钟 100 次请求
		$limit = 100;
		$interval = 60;
		// 检查用户是否使用了代理 IP
//		if (isset($_SERVER['HTTP_X_FORWARDED_FOR']) && !empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
//			exit('非真实 IP，禁止访问');
//		}
		// 检查速率限制键是否已在 Redis 中存在
		$key = "rate_limit:{$_SERVER['REMOTE_ADDR']}";
		if ($redis->exists($key)) {
			// 速率限制键存在，检查剩余的生存时间
			$ttl = $redis->ttl($key);
			if ($ttl > 0) {
				// 速率限制仍在生效，检查计数器
				$count = $redis->get($key);
				if ($count >= $limit) {
					// 计数器已超过限制，向用户显示消息并设置新的过期时间
					echo "访问频率过高  ".$count."次";
					$redis->expire($key, $interval);
					exit;
				} else {
					// 计数器未超过限制，增加计数器
					$redis->incr($key);
				}
			} else {
				// 速率限制已过期，重置速率限制
				$count = $redis->incr($key);
				$redis->expire($key, $interval);
			}
		} else {
			// 速率限制键不存在，创建键并设置过期时间
			$count = $redis->incr($key);
			$redis->expire($key, $interval);
		}
		echo '第'.self::test_Api($count).'次';
	}
	
	public static function test_Api($a): string
    {
	    return "'$a'";
	}
	
}
CheckRedis::Run();























