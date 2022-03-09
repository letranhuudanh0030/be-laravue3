<?php

namespace Acme\SingleResponsibility\Reporting;

use Acme\SingleResponsibility\Repositories\SalesRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Exception;

class SalesReporter {

    private $repo;

    function __construct(SalesRepository $repo) {
        $this->repo = $repo;
    }

    public function between($startDate, $endDate, SalesOutputInterface $formatter)
    {
        $sales = $this->repo->between($startDate, $endDate);

        return $formatter->output($sales);
    }
}
