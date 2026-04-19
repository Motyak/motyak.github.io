#!/usr/bin/env -S php -f
<?php

$content = file_get_contents("{$argv[1]}");
$matches = array();
preg_match_all('/^<\?php include_pre\("(atom\/.*\.html)"\); \?>$/m', $content, $matches);

# performs data/book/%.php => monlang/%.html
$targetHtml = "monlang/" . basename($argv[1], ".php") . ".html";
$targetTxt = "monlang/" . basename($argv[1], ".php") . ".txt";

echo "{$targetHtml} {$targetTxt}: \\\n";
foreach ($matches[1] as $match) {
    echo " data/{$match} \\\n";
}
echo "\n";

foreach ($matches[1] as $match) {
    echo "data/{$match}:\n";
}

/*
    generate this kind of output:
    monlang/book.html monlang/book.txt: \
     data/atom/LV1.html \
     data/atom/LV2.html \
     data/atom/ideas_from_sicp.html \

    data/atom/LV1.html:
    data/atom/LV2.html:
    data/atom/ideas_from_sicp.html:
*/

?>
