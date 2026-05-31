<?php

function replaceDollarWithRupee($dir) {
    $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir));
    $count = 0;
    
    foreach ($iterator as $file) {
        if ($file->isFile() && $file->getExtension() === 'php') {
            $path = $file->getPathname();
            $content = file_get_contents($path);
            
            // Match $ followed by a digit and replace with ₹
            $newContent = preg_replace('/\$([0-9])/', '₹$1', $content);
            
            if ($content !== $newContent) {
                file_put_contents($path, $newContent);
                $count++;
                echo "Updated: $path\n";
            }
        }
    }
    
    echo "Total files updated: $count\n";
}

replaceDollarWithRupee(__DIR__ . '/resources/views');
replaceDollarWithRupee(__DIR__ . '/app/Http/Controllers');
