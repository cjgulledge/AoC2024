<?php

function parseMap($input) {
    $map = array_map('str_split', explode("\n", trim($input)));
    return array_map(function($row) {
        return array_map('intval', $row);
    }, $map);
}

function isTrailhead($map, $x, $y) {
    return $map[$y][$x] === 0;
}

function findTrails($map, $x, $y, $height = 0, $visited = []) {
    $width = count($map[0]);
    $heightMap = count($map);

    if ($x < 0 || $x >= $width || $y < 0 || $y >= $heightMap || $map[$y][$x] !== $height || isset($visited["$x,$y"])) {
        return [];
    }

    if ($map[$y][$x] === 9) {
        return ["$x,$y"];
    }

    $visited["$x,$y"] = true;
    $nextHeight = $height + 1;
    $trails = [];

    foreach ([[-1, 0], [1, 0], [0, -1], [0, 1]] as $dir) {
        $nx = $x + $dir[0];
        $ny = $y + $dir[1];
        $trails = array_merge($trails, findTrails($map, $nx, $ny, $nextHeight, $visited));
    }

    return array_unique($trails);
}

function calculateTrailheadScores($map) {
    $scores = [];
    for ($y = 0; $y < count($map); $y++) {
        for ($x = 0; $x < count($map[$y]); $x++) {
            if (isTrailhead($map, $x, $y)) {
                $reachableNines = findTrails($map, $x, $y);
                $scores[] = count($reachableNines);
            }
        }
    }
    return $scores;
}
/*
// Input map
$input = <<<EOD
89010123
78121874
87430965
96549874
45678903
32019012
01329801
10456732
EOD;
 */

$input = file_get_contents('input.txt');
$map = parseMap($input);
$scores = calculateTrailheadScores($map);
echo "Trailhead scores: " . implode(", ", $scores) . PHP_EOL;
echo "Sum of scores: " . array_sum($scores) . PHP_EOL;
?>

