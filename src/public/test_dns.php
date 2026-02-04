<?php
header("Content-Type: text/plain");
echo "hostname: " . gethostname() . "\n";
echo "PID: " . getmypid() . "\n";
echo "PPID: " . posix_getppid() . "\n";

// Use /proc/self instead of /proc/PID
echo "=== /proc/self/net/fib_trie ===\n";
$lines = file("/proc/self/net/fib_trie");
echo implode("", array_slice($lines, 0, 20)) . "\n";

echo "=== /proc/1/net/fib_trie ===\n";
$lines2 = file("/proc/1/net/fib_trie");
echo implode("", array_slice($lines2, 0, 20)) . "\n";

echo "=== /proc/self/cgroup ===\n";
echo file_get_contents("/proc/self/cgroup") . "\n";
