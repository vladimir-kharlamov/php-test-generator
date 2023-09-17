<?php
namespace App;

use App\MyUtils;
use FaaPz\PDO\Clause\Limit;

require_once __DIR__ . '/../../vendor/autoload.php';

$database = MyUtils::getDb();

$start = myUtils::seconds();
$selectStatement = $database->select()
    ->from('records')
    ->limit(new Limit(200000)); // comment to get memory allocation error (except custom setup)

$stmt = $selectStatement->execute();

// Worst dummy fetch all data.
foreach ($stmt->fetchAll() as $row) {
    // Emulate domain logic: API requests, paging etc (No SOLID)
    substr($row['text'], 0, 3);
}

echo MyUtils::memorySize(memory_get_usage()) . PHP_EOL;
$end = myUtils::seconds();
echo 'Execution time ' . ($end - $start) . ' sec.' . PHP_EOL;
//ComposerAutoloaderInitd65257009fa5da51c9525569a977d60f