<?php
/*
 * Logging Utils.
 */

//
//Debug/Logging parameters
//

// Report all PHP errors
//error_reporting(E_ALL);

//Enable tracing level.
//0 - disabled. Higher numbers will show more debug information.
define ("DEBUG" , 3);

/*
 * Print a message to log.
 */
function logger($msg, $severity=3)
{
    if($severity <= DEBUG)
    {
        error_log(date(DATE_RFC822) . ": "  . $msg . "\n", 3,  "/tmp/transposh.log");
    }
}


?>