<?php

use SD\Erecruiter;

require_once(__DIR__ . "/../../../wp-load.php");

$importer = new Erecruiter\Importer();

try {
    $importer->updateOffers(true);
    $importer->removeDuplicates(true);
} catch (Exception $e) {
    echo '<h1>Wystąpił bład :(</h1>';
    echo '<p>' . $e->getMessage() . '</p>';
    echo '<p>' . $e->getFile() . '</p>';
    echo '<p>' . $e->getLine() . '</p>';
}
