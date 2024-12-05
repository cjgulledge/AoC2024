<?php

function countXMASEntries($grid) {
    $word = "XMAS";
    $directions = [
        [0, 1],   // right
        [0, -1],  // left
        [1, 0],   // down
        [-1, 0],  // up
        [1, 1],   // diagonal down-right
        [-1, -1], // diagonal up-left
        [1, -1],  // diagonal down-left
        [-1, 1]   // diagonal up-right
    ];

    $rowCount = count($grid);
    $colCount = strlen($grid[0]);
    $count = 0;

    function searchWord($grid, $word, $row, $col, $direction) {
        $rowCount = count($grid);
        $colCount = strlen($grid[0]);
        $wordLength = strlen($word);

        for ($i = 0; $i < $wordLength; $i++) {
            $newRow = $row + $direction[0] * $i;
            $newCol = $col + $direction[1] * $i;

            if ($newRow < 0 || $newRow >= $rowCount || $newCol < 0 || $newCol >= $colCount) {
                return false;
            }

            if ($grid[$newRow][$newCol] !== $word[$i]) {
                return false;
            }
        }

        return true;
    }

    for ($row = 0; $row < $rowCount; $row++) {
        for ($col = 0; $col < $colCount; $col++) {
            foreach ($directions as $direction) {
                if (searchWord($grid, $word, $row, $col, $direction)) {
                    $count++;
                }
            }
        }
    }

    return $count;
}

// Example grid
$grid = [
    "MMMSXXMASM",
    "MSAMXMSMSA",
    "AMXSXMAAMM",
    "MSAMASMSMX",
    "XMASAMXAMM",
    "XXAMMXXAMA",
    "SMSMSASXSS",
    "SAXAMASAAA",
    "MAMMMXMMMM",
    "MXMXAXMASX"
];

$gridData = file_get_contents('input.txt');
$grid = explode("\n",$gridData);
array_pop($grid);

$count = countXMASEntries($grid);
echo "The word 'XMAS' appears $count times in the grid.\n";
?>
