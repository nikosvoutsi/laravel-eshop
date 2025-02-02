<?php

//Get arguments
$search=$argv[1];
$replace=$argv[2];
$filename=$argv[3];

//Read, replace and write
$fileContents=file_get_contents($filename);
$fileContents=str_replace($search, $replace, $fileContents);
file_put_contents($filename, $fileContents);
