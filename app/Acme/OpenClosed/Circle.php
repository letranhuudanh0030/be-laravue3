<?php
namespace Acme\OpenClosed;

class Circle implements ShapeInterface {
    public $radius;

    function __construct($radius)
    {
        $this->radius = $radius;
    }

    public function area()
    {
        return $this->radius * $this->radius * pi();
    }
}
