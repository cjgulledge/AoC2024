<?php
error_reporting(E_ERROR|E_PARSE);
//'....#.....',


$grid = [
'....#.....',
'.........#',
'..........',
'..#.......',
'.......#..',
'..........',
'.#..^.....',
'........#.',
'#.........',
'......#...'];
$grid = file_get_contents('input.txt');
$grid = explode("\n",$grid);
array_pop($grid);

$ogrid = $grid;


$startDirection = 'up';
$startPos = findStart($ogrid, $startDirection);


$infiniteLoopPositions = 0;
foreach ($ogrid as $rkey=>$row) {
    $rowvals = str_split($row);
    $grid = $ogrid;
    $newgrid = $ogrid;
    foreach ($rowvals as $ckey=>$curval) {
	    if (substr($grid[$rkey],$ckey,1) == '.') {
	    //   print $rkey." ".$ckey." ".$curval."\n";
             $rowcopy = $rowvals;
             $rowcopy[$ckey] = '#';
             $newgrid = $grid;
	     $newgrid[$rkey] = implode($rowcopy); 
             $grid = $newgrid;
             //print_r($grid);
	    } else {
                continue;
	    }
$spotsTouched = array();
$go = $startDirection;
$iterations = 0;
$pos = $startPos;

/*
 //i dont THINK we need this for this exercise. *
$spotsTouched[
	strval(strval($pos[0]).".".strval($pos[1]))
             ] = 1;
 */

while (1==1) {
        $prevPos = $pos;
        $pos = findNext($pos,$go);
        if ($pos == false) {
	}
        //print_r($pos);
	$val = substr($grid[$pos[0]],$pos[1],1);
	//print $val;
        if ($val == '.' || $val == '^') {
            //direction doesn't change. 
           $iterations++; 
           //$spotsTouched[strval($pos[0].$pos[1])] = 1;
	   if (isset( $spotsTouched[strval(strval($pos[0]).".".strval($pos[1]))])) {
	      $spotsTouched[strval(strval($pos[0]).".".strval($pos[1]))] += 1;
	   } else {
	      $spotsTouched[strval(strval($pos[0]).".".strval($pos[1]))] = 1;
	   }
	   if ($spotsTouched[strval(strval($pos[0]).".".strval($pos[1]))] ==10) {
//		  print "we have been here before\n";
		   //print_r($grid);
		                                       print "found a loop at ". $pos[0]." ". $pos[1]."\n";
                   //print_r($spotsTouched); 
                  $infiniteLoopPositions++;
                  break;
	   } 
	} elseif ($val == '#') {
            //change direcction
	    $go = getNewDirection($go);
            $pos = $prevPos;
            //print "changing direction at iteration ". $iterations;
            //print ". new direction is ". $go;
	    //print ". pos is now ". print_r($pos,1)."\n";
	} else {
              //we are DONE
	      //print "WE AARE DONE: at ". print_r($pos,1)."\n";
	   break;
	}
	 if ($iterations> 200000) break;
}
#print "\n";
#print "iterations were ". $iterations;
#print "\n";
#print "spots touched were ". count($spotsTouched)."\n";
}
}
print "infinite loop count: ". $infiniteLoopPositions;

function getNewDirection($dir) {
    if ($dir == 'up') return 'right';
    if ($dir == 'right') return 'down';
    if ($dir == 'down') return 'left';
    if ($dir == 'left') return 'up';
}

function findNext($curPos, $direction) {
     global $grid;

     $dirs = 
	[
           'up' => [-1,0],
	   'right' => [0,1],
	   'down' =>[1,0],
	   'left' => [0,-1]
        ];

        //curpos is [X,Y]
	$nextPos = [$curPos[0]+$dirs[$direction][0],  $curPos[1]+$dirs[$direction][1]];
        //check to see next position exists
	//if (in_array(substr($grid[$nextPos[0]],$nextPos[1],1),['.','#','^'])) {
               return $nextPos;
//	} else {
 //          return false;
//	}
}




function findStart($grid) {
  foreach ($grid as $key=>$row) {
       $loc = strpos($row,'^');
       if ($loc !== false) return [$key,$loc];
  }
}

findStart($grid);
