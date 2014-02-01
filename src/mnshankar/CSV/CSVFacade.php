<?php
namespace mnshankar\CSV;

use Illuminate\Support\Facades\Facade;

class CSVFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'csv';
    }
}
