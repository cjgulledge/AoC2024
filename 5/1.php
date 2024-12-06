<?php
$input = [
    "47|53",
    "97|13",
    "97|61",
    "97|47",
    "75|29",
    "61|13",
    "75|53",
    "29|13",
    "97|29",
    "53|29",
    "61|53",
    "97|53",
    "61|29",
    "47|13",
    "75|47",
    "97|75",
    "47|61",
    "75|61",
    "47|29",
    "75|13",
    "53|13"
];


unset($input);
$data = file_get_contents('1pairs.txt');
$input = explode("\n",$data);
array_pop($input);


// Step 1: Parse the input to create adjacency lists and in-degrees
$adjacencyList = [];
$inDegrees = [];

foreach ($input as $rule) {
    list($x, $y) = explode('|', $rule);
    
    if (!isset($adjacencyList[$x])) {
        $adjacencyList[$x] = [];
    }
    
    if (!isset($adjacencyList[$y])) {
        $adjacencyList[$y] = [];
    }
    
    $adjacencyList[$x][] = $y;
    
    if (!isset($inDegrees[$x])) {
        $inDegrees[$x] = 0;
    }
    
    if (!isset($inDegrees[$y])) {
        $inDegrees[$y] = 0;
    }
    
    $inDegrees[$y]++;
}
print_r($adjacencyList);
//print_r($inDegrees);
die;

// Step 2: Use Kahn's algorithm to perform topological sorting
$sortedOrder = [];
$queue = new SplQueue();

foreach ($inDegrees as $node => $degree) {
    if ($degree === 0) {
        $queue->enqueue($node);
    }
}

while (!$queue->isEmpty()) {
    $currentNode = $queue->dequeue();
    $sortedOrder[] = $currentNode;
    
    foreach ($adjacencyList[$currentNode] as $neighbor) {
        $inDegrees[$neighbor]--;
        
        if ($inDegrees[$neighbor] === 0) {
            $queue->enqueue($neighbor);
        }
    }
}

// Step 3: Build the result array with keys as ordered list starting from zero
$result = [];
foreach ($sortedOrder as $index => $page) {
    $result[$index] = $page;
}

$sortedOrderMap = $result;


// Function to check if an update is in the correct order
function isCorrectOrder($update, $sortedOrderMap) {
    $previousIndex = -1;
    
    foreach ($update as $page) {
            $index = array_search($page,$sortedOrderMap);
        if (!isset( $index )) {
            continue; // Skip pages not in the sorted order
        }
        
        if ($index < $previousIndex) {
            return false; // Order is violated
        }
        
	$previousIndex = $index;
	unset($index);
    }
    
    return true;
}


/*
// Updates to check
$updates = [
    [75, 47, 61, 53, 29],
    [97, 61, 53, 29, 13],
    [75, 29, 13],
    [75, 97, 47, 61, 53],
    [61, 13, 29],
    [97, 13, 75, 29, 47]
];
 */

$pageData = file_get_contents('1pages.txt');
$pageData = explode("\n",$pageData);
array_pop($pageData);
foreach($pageData as $key=>$vals) {
   $updates[] = explode("\n",$vals);
}


$total = 0;
foreach ($updates as $key=>$vals) {
    if (isCorrectOrder($vals,$sortedOrderMap)) {
       //print_r($vals);
	//// Calculate the middle index
	$middleIndex = (count($vals) - 1) / 2;

	// Get the middle value
	$middleValue = $vals[$middleIndex];
        $total += $middleValue;
        
    }
}
print $total;



?>
