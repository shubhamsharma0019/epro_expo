<?php
$xml = simplexml_load_file('docs/diagrams/eproexpo_complete_single_flow.svg');
$xml->registerXPathNamespace('svg', 'http://www.w3.org/2000/svg');
foreach ($xml->xpath('//svg:text') as $t) {
    echo trim((string)$t) . PHP_EOL;
}

