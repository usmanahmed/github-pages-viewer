<?php

function scanAllDir(string $path): array
{
    $structure = [];
    $iterator = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($path, RecursiveDirectoryIterator::SKIP_DOTS),
        RecursiveIteratorIterator::SELF_FIRST
    );

    foreach ($iterator as $item) {
        $relativePath = $iterator->getSubPathName();
        $parts = explode(DIRECTORY_SEPARATOR, $relativePath);

        $currentLevel = &$structure;
        foreach ($parts as $part) {
            if ($item->isDir() && $part === end($parts)) {
                // If it's a directory, ensure it's an array
                if (!isset($currentLevel[$part])) {
                    $currentLevel[$part] = [];
                }
            } else {
                // If it's a file, add it
                if ($part === end($parts) && $item->isFile()) {
                    $currentLevel[] = $part;
                } else {
                    // For intermediate directories, traverse
                    if (!isset($currentLevel[$part])) {
                        $currentLevel[$part] = [];
                    }
                    $currentLevel = &$currentLevel[$part];
                }
            }
        }
    }
    return $structure;
}

function get_nav($pages, $parent = '') {
    
    $html = '<ol>';
    foreach ($pages as $key => $value) {
        if ($value == 'index.md') continue;

        $anchor = explode( '. ', $key);
        $anchor = end($anchor);

        $key = str_replace( ' ', '+', $key );

        $html .= '<li><a href="' . SITE_URL . '/' .  $parent . (!empty($parent) ? '/' : '') . $key . '">' . $anchor . '</a>';

        if (is_array($value)) {
            $html .= get_nav($value, $key);
        }
        $html .= '</li>';
    }

    $html .= '</ol>';
    return $html;
}