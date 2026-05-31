<?php
$log = file_get_contents('modified_files_log.txt');
preg_match_all('/TargetFile\\\\?":\\\\?"([^\\\\"]+)\\\\?"/', $log, $matches);
if (empty($matches[1])) {
    preg_match_all('/"TargetFile":"([^"]+)"/', $log, $matches);
}
$files = array_unique($matches[1]);
foreach ($files as $f) {
    echo $f . "\n";
}
