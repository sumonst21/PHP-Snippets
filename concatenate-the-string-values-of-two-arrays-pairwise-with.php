<?php
// example one
$combined = array_map(function($a, $b) { return $a . ' ' . $b; }, $a1, $a2));


// example two - complex
$combined_episodes = array_map(function ($a, $b, $c, $d) {
    return '<tr><td>' . $a->text . '</td><td>' . $b->text . '</td><td>' . $c->text . '</td><td>' . $d->text . '</td></tr>';
}, $episodeNumbers, $episodeNames, $episodeDuratoin, $episodeAirDate);

//print_r($combineds);

foreach ($combined_episodes as $combined_episode) {
    echo $combined_episode;
}
