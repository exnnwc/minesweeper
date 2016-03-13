<?php

class Board{
	const SIZE=28;
    public $visible=[];
    public $bombs=[];
    function __construct($size){
        for($x=0;$x<$size;$x++){
            for($y=0;$y<$size;$y++){
                $visible[$x][$y]=false;
				$bombs[$x][$y]=false;
            }   
        }
		$this->visible = $visible;
        $this->bombs=$this->populate_with_bombs($bombs, $size, 15);
    }
    private function populate_with_bombs($bombs, $size, $percent){        		
        $num_of_bombs=0;
        $max_num_of_bombs=$size*$size*($percent/100);		
        while ($num_of_bombs<$max_num_of_bombs){
            $rand_x=rand(0,$size-1);
            $rand_y=rand(0, $size-1);
                if (!$bombs[$rand_x][$rand_y]){
                    $bombs[$rand_x][$rand_y]=true;
                    $num_of_bombs++; 
                }
        }
        return $bombs;
    }
	
	public function neighbors($home_x, $home_y){
		
		for ($x=($home_x-1);$x<($home_x+2);$x++){
			for ($y=($home_y-1);$y<($home_y+2);$y++){				
				if (!($x==$home_x && $y==$home_y) && $x>=0 && $y>=0 && $x<self::SIZE && $y<self::SIZE){
					$neighbors[]=["x"=>$x, "y"=>$y];	
				}
				
			}
		}
		return $neighbors;
	}
	public function num_of_bombs_adjacent($home_x, $home_y){
		$num_of_bombs=0;
		$neighbors = $this->neighbors($home_x, $home_y);
		
		foreach ($neighbors as $neighbor){
			if (isset($this->bombs[$neighbor["x"]][$neighbor["y"]]) && $this->bombs[$neighbor["x"]][$neighbor["y"]]) {
				$num_of_bombs++;		
			}
		}
		return $num_of_bombs;
	}
}
