<?php

namespace Acme\SingleResponsibility\Reporting;

use Acme\SingleResponsibility\Reporting\SalesOutputInterface;

class HtmlOutput implements SalesOutputInterface {
    public function output($sales)
    {
        return "<h1>Sales: $sales</h1>";
    }
}

