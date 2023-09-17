<?php

namespace App;

use FaaPz\PDO\Clause\Limit;
use PDO;
use App\MyUtils;

require_once __DIR__ . '/../../vendor/autoload.php';
$database = MyUtils::getDb();

function getData($database) {

    $start = myUtils::seconds();
    $page = 0;
    $pageSize = 100000;
    $data = [];

    while(true) {

        $selectStatement = $database->select()
            ->from('records')
            ->limit(new Limit($pageSize, $page * $pageSize));

        $stmt = $selectStatement->execute();
        if (!$stmt->rowCount()) {
            break;
        }
    
        echo 'page ' . $page . ' - ' . MyUtils::memorySize(memory_get_usage()) . PHP_EOL;

        // Emulate domain logic: API requests, paging etc
        // SOLID violation - SPR (Single responsibility principle)
        while ($row = $stmt->fetch()) {
            // return @Iterator 
            yield($row);
        }
        $page++;
    }
    $end = myUtils::seconds();
    echo 'Execution time ' . ($end - $start) . ' sec.' . PHP_EOL;

    return $data;
}

//function someDomainLogic() {
    foreach (getData($database) as $row) {
        substr($row['text'], 0, 3);
    }
//}
