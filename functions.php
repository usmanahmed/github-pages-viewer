<?php

function load_content($url) {
    global $md;
    $html = '<h1>No Content Found</h1>';
    $url = str_replace(['ajax/', SITE_URL], '', $url);

    $md_path = DOCSPATH . $url . '/index.md';
    $md_path = str_replace('+', ' ', $md_path);

    if (file_exists($md_path)) $html = $md->text( file_get_contents($md_path) );

    return $html;
}


function get_nav($pages, $parent = '') {

    $html = '<ul>';
    foreach ($pages as $key => $value) {
        if ($value == 'index.md' || in_array($value, ['.', '..'])) continue;

        $key = is_array($value) ? $key : $value;

        $anchor = explode( '. ', $key);
        $anchor = end($anchor);

        $key = str_replace( ' ', '+', $key );

        $uri = $parent . (!empty($parent) ? '/' : '') . $key;

        $html .= '<li><a href="' . SITE_URL . '/' . $uri . '">' . $anchor . '</a>';

        if (is_array($value)) {
            $html .= get_nav($value, $uri);
        }
        $html .= '</li>';
    }

    $html .= '</ul>';
    return $html;
}
function generate_nav($pages, $parent = '', $indent = '') {
    $md = '';
    foreach ($pages as $key => $value) {
        if ($value == 'index.md' || in_array($value, ['.', '..'])) continue;

        $uri = $parent . (!empty($parent) ? '/' : '') . $key;

        $anchor = explode( '. ', $key);
        $anchor = end($anchor);

        $md .= "$indent* [$anchor](" . GITHUB_PAGES . "$uri)" . PHP_EOL;

        if (is_array($value)) {
            $md .= generate_nav($value, $uri, $indent . '    ');
        }
    }

    return $md;
}


function scanAllDir(string $path, $start_from = ''): array
{

    $path = str_replace('+', ' ', $path);

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