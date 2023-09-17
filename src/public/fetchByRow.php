<?php

namespace App;

use App\MyUtils;
use FaaPz\PDO\Clause\Limit;

require_once __DIR__ . '/../../vendor/autoload.php';

$database = MyUtils::getDb();

$start = myUtils::seconds();
$selectStatement = $database->select()
    ->from('records')
    ->limit(new Limit(300000)); //  comment limit to get memory allocation error (except custom setup)

$stmt = $selectStatement->execute();

// fetch by step. But in fact data already fetched all in statement
while ($row = $stmt->fetch()) {
    substr($row['text'], 0, 3);
}

echo MyUtils::memorySize(memory_get_usage()) . PHP_EOL;
$end = myUtils::seconds();
echo 'Execution time ' . ($end - $start) . ' sec.' . PHP_EOL;