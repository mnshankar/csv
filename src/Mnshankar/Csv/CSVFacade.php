<?php
namespace mnshankar\Csv;
use Illuminate\Support\Facades\Facade;
class CSVFacade extends Facade 
{
    protected static function getFacadeAccessor() { return 'csv'; }
}