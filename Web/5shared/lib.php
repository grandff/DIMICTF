<?php

function createDirectory ($path)
{
    if (!file_exists($path))
    {
        mkdir($path, 0755, true);
    }
}

function listDirectory ($path)
{
    $handle = opendir($path);
    $files = Array();
    while (false !== ($file = readdir($handle)))
    {
        $files[] = $file;
    }

    return $files;
}

function xss($string)
{
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}