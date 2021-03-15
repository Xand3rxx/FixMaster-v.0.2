<?php

namespace App\Traits;


trait GenerateUniqueIdentity
{
    protected $random;
    protected $exist;
    protected $tested;
    protected $tableName;
    protected $abbr;
    protected $unique;

    /**
     * Generate a Uniqe CSE ID 
     * 
     * @return string
     */
    public static function generate(string $table, string $abbr, $colunm)
    {
        return static::uniqueIdentity($table, $abbr, $colunm);
    }

    /**
     * Generate Unique ID in related to given table
     * 
     * @param string $tableName
     *
     * @return string
     */
    protected static function uniqueIdentity(string $table, string $abbr, $colunm='',  $unique = false)
    {
        // Store tested results in array to not test them again
        $tested = [];

        do {
            // Generate random characters of 8
            $random = (string) $abbr . strtoupper(substr(md5(time()), 0, 8));

            // Check if it's already testing
            // If so, don't query the database again
            if (in_array($random, $tested)) {
                continue;
            }
              
            if($colunm){
                $exist = \Illuminate\Support\Facades\DB::table($table)->where($colunm, $random)->exists();
            }else{
                $exist = \Illuminate\Support\Facades\DB::table($table)->where('unique_id', $random)->exists();
            }
            // Check if it is unique in the database
           

            // Store the random characters in the tested array
            // To keep track which ones are already tested
            $tested[] = $random;

            // String appears to be unique
            if ($exist === false) {
                // Set unique to true to break the loop
                $unique = true;
            }

            // If unique is still false at this point it will just repeat all the steps until
            // it has generated a random string of characters
        } while (!$unique);


        return $random;
    }
}
