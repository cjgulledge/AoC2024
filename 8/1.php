<?php

function solve($lines) {
    // Read the lines into a 2D grid
    $grid = array_map('str_split', $lines);
    $rows = count($grid);
    $cols = count($grid[0]);

    // Collect antenna positions by frequency
    $antennas = [];
    for ($r = 0; $r < $rows; $r++) {
        for ($c = 0; $c < $cols; $c++) {
            $ch = $grid[$r][$c];
            if ($ch !== '.') {
                $antennas[$ch][] = [$r, $c];
            }
        }
    }

    // Set to store unique antinode positions
    // We'll store them as "row,col" strings for uniqueness
    $antinode_positions = [];

    // For each frequency, find pairs and compute antinodes
    foreach ($antennas as $freq => $positions) {
        $count = count($positions);
        if ($count < 2) continue; // Need at least two antennas to form antinodes

        for ($i = 0; $i < $count; $i++) {
            for ($j = $i + 1; $j < $count; $j++) {
                list($x1, $y1) = $positions[$i];
                list($x2, $y2) = $positions[$j];

                $dx = $x2 - $x1;
                $dy = $y2 - $y1;

                // Antinode 1: Extend beyond A
                $ax1 = $x1 - $dx;
                $ay1 = $y1 - $dy;

                // Antinode 2: Extend beyond B
                $ax2 = $x2 + $dx;
                $ay2 = $y2 + $dy;

                // Check bounds and add if valid
                if ($ax1 >= 0 && $ax1 < $rows && $ay1 >= 0 && $ay1 < $cols) {
                    $antinode_positions["$ax1,$ay1"] = true;
                }

                if ($ax2 >= 0 && $ax2 < $rows && $ay2 >= 0 && $ay2 < $cols) {
                    $antinode_positions["$ax2,$ay2"] = true;
                }
            }
        }
    }

    // Count unique antinode positions
    return count($antinode_positions);
}

// Example usage with the provided input:
// Replace the lines below with the actual puzzle input lines.
$input = [
    "............",
    "........0...",
    ".....0......",
    ".......0....",
    "....0.......",
    "......A.....",
    "............",
    "............",
    "........A...",
    ".........A..",
    "............",
    "............"
];

$input = explode("\n",trim(file_get_contents('input.txt')));
$result = solve($input);
echo $result, "\n";

