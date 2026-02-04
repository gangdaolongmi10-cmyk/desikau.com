<?php
header('Content-Type: text/plain');
echo "=== PHP-FPM Debug ===\n";
echo "PHP hostname: " . gethostname() . "\n";
echo "Server IP: " . $_SERVER['SERVER_ADDR'] . "\n";
echo "PHP PID: " . getmypid() . "\n";

// 複数のホストでテスト
$hosts = [
    'db' => gethostbyname('db'),
    '172.18.0.2' => '172.18.0.2',
];

foreach ($hosts as $label => $ip) {
    echo "\n--- Testing: $label ($ip) ---\n";
    try {
        $pdo = new PDO("mysql:host=$ip;port=3306;dbname=desikau", "desikau", "password", [
            PDO::ATTR_TIMEOUT => 3,
        ]);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $result = $pdo->query("SELECT @@hostname, DATABASE()");
        $row = $result->fetch(PDO::FETCH_ASSOC);
        echo "MySQL hostname: " . $row['@@hostname'] . "\n";
        echo "Database: " . $row['DATABASE()'] . "\n";

        $result = $pdo->query("SHOW TABLES");
        $tables = $result->fetchAll(PDO::FETCH_COLUMN);
        echo "Tables (" . count($tables) . "): " . implode(", ", $tables) . "\n";

    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage() . "\n";
    }
}

