#!/usr/bin/env -S php -f
<?php

set_include_path(get_include_path() . realpath(".") . ":"); // so we can use data/xxx build/yyy

if ($argv[1] == "data/book/contents.php") {
    include("{$argv[1]}");
    include("build/style.html");
    exit;
}

function include_pre($path) {
    $str = file_get_contents($path);
    # escape '%', '<' and '>'
    $str = htmlspecialchars($str);
    # restore <pre> (we allow them)
    $str = preg_replace('/&lt;pre&gt;(.*?)&lt;\/pre&gt;/s', '<pre>$1</pre>', $str);
    # restore <a> (we allow them)
    $str = preg_replace('/&lt;a (href=&quot;[^&]*&quot;)&gt;(.*?)&lt;\/a&gt;/s', '<a $1>$2</a>', $str);
    echo $str;
}

chdir("data");
include("{$argv[1]}");
include("build/style.html");
include("build/script.html");

?>
