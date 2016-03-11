<?php

class Board{
    public $visible=[];
    public $bombs=[];
    function __construct($size){
        for($x=0;$x<$size;$x++){
            for($y=0;$y<$size;$y++){
                $visible[$x][$y]=false;
            }   
        }
		$this->visible = $visible;
        $this->bombs=$this->populate_with_bombs($size, 10);
    }
    private function populate_with_bombs($size, $percent){
        $bombs=[];
        $num_of_bombs=0;
        $max_num_of_bombs=$size*$size*(1/$percent);
        while ($num_of_bombs<$max_num_of_bombs){
            $rand_x=rand(0,$size-1);
            $rand_y=rand(0, $size-1);
                if (!isset($bombs[$rand_x][$rand_y])){
                    $bombs[$rand_x][$rand_y]=true;
                    $num_of_bombs++; 
                }
        }
        return $bombs;
    }
}
