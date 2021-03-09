<?php
namespace App\Helpers;
use Carbon\Carbon;

class CustomHelpers
{
    static function displayTime($start, $end)
    {
        $date = Carbon::parse($start);
        $diff = $date->diffForHumans($end, true);
        return $diff;
    }

    
}
?>
