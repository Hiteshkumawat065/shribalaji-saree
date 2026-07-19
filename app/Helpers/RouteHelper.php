<?php

/**
 * Recursively include all PHP files from a folder.
 * This helps us automatically load routes from subfolders
 * like routes/frontend/ and routes/backend/
 */
if (! function_exists('includeFilesInFolder')) {
    function includeFilesInFolder($folder)
    {
        try {
            $rdi = new RecursiveDirectoryIterator($folder);
            $it = new RecursiveIteratorIterator($rdi);

            while ($it->valid()) {
                // Check if it's a readable PHP file
                if (! $it->isDot() && $it->isFile() && $it->isReadable() && $it->current()->getExtension() === 'php') {
                    require $it->key();
                }
                $it->next();
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
}

/**
 * Wrapper function to include route files from a folder
 */
if (! function_exists('includeRouteFiles')) {
    function includeRouteFiles($folder)
    {
        includeFilesInFolder($folder);
    }
}
