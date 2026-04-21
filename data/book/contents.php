<title>Table of Contents</title>

<body>

<h1>=== TABLE OF CONTENTS ===</h1>

<?php
    chdir("monlang");
    $files = array_diff(scandir("."), array(".", "..", "img"));
    $map = [];

    foreach ($files as $file) {
        if (preg_match("/\.html$/", $file)) {
            $stem = substr($file, 0, -5); # remove .html
            $map["$stem"]["html"] = 1;
        }
        else if (preg_match("/\.txt$/", $file)) {
            $stem = substr($file, 0, -4); # remove .txt
            $map["$stem"]["txt"] = 1;
        }
    }

    foreach ($map as $file => $formats) {
        $first = true;
        echo "<li>{$file}";
        if (array_key_exists("html", $formats)) {
            if ($first) echo " ";
            echo "[<a href=\"{$file}.html\">html</a>]";
            $first = false;
        }
        if (array_key_exists("txt", $formats)) {
            if ($first) echo " ";
            echo "[<a href=\"{$file}.txt\">txt</a>]";
            $first = false;
        }
        echo "</li>\n";
    }
?>

</body>
