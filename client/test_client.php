<?php

require_once('Socket.php');

function makeRequest($size)
{
	$result = '';
	for ($i = 0; $i < $size; $i++) $result .= chr(rand() % 256);
	return $result;
}

$log_start = hrtime(true);

function logTime($message)
{
	global $log_start;
	$current = (hrtime(true) - $log_start) / 1000000.0;
	print(sprintf("%.3f", $current)." ".$message."\n");
}

function testSocket($amount, $reconnect, $size)
{
	logTime("start");
	$s = null;
	$current = 0;
	for ($i = 0; $i < $amount; $i++)
	{
		if ($s === null)
		{
			logTime("begin connecting");
			$s = new IPSocket('127.0.0.1', 19876);
			$s->connect();
			logTime("connected");
			$current = 0;
		}
		$m = makeRequest($size);
		logTime("begin sending");
		$s->sendMessage($m);
		logTime("sent, receiving");
		$r = $s->receiveMessage();
		logTime("received");
		$current++;
		if ($current >= $reconnect)
		{
			$s = null;
		}
	}
	logTime("finish");
}

$requests_amount = $argv[1];
$requests_per_connect = $argv[2];
$request_size = $argv[3];

print('Testing '.$requests_amount.' requests, reconnect after '.
		$requests_per_connect.' size '.$request_size."\n");


print("Testing IP socket:\n");
$start = microtime(true);
testSocket($requests_amount, $requests_per_connect, $request_size);
$finish = microtime(true);

$elapsed = $finish - $start;
print('Total: '.round($elapsed, 3).' seconds, '.round($requests_amount / $elapsed, 3).' RPS'."\n");

