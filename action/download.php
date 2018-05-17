<?php

$output = findAndCompare($link1, $link2, $sort);

    header('Content-type: text/csv');
    header('Content-Disposition: attachment; filename="linksComparation.' . date("H:i:s") . '.csv"');
    header('Pragma: no-cache');
    header('Expires: 0');

    $file = fopen('php://output', 'w');

    fputcsv($file, array('domain 1', 'domain 2', 'percentage'));
    if($output) {
        foreach ($output as $row) {
            fputcsv($file, $row);
        }
    }
    fclose($file);

exit();
?>