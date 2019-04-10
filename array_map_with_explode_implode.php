<?php
$array_texts = explode("; ", "Link Text 1; Link Text 2; Link Text 3");
$array_links = explode("; ", "https://url1.com; https://url2.com; https://url3.com");

$arr = array_map(null, $array_texts, $array_links);
foreach($arr as $e) {
    $a[] = '<a href="' . $e[1] . '>' . $e[0] . '</a>';
}
echo implode("; ", $a);
