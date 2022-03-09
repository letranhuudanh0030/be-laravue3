<?php
namespace Acme\OpenClosed;

class AreaCalculator {
    public function caculate($shapes)
    {
        foreach ($shapes as $shape){
            $area[] = $shape->area();
        }
        return array_sum($area);
    }
}
