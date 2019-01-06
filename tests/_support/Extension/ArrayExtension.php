<?php

namespace \Codeception\Extension;

use \Codeception\Events;

class ArrayExtension extends \Codeception\Extension
{
    // list events to listen to
    // Codeception\Events constants used to set the event

    public static $events = array(
        Events::SUITE_AFTER  => 'afterSuite',
        Events::SUITE_BEFORE => 'beforeTest',
        Events::STEP_BEFORE => 'beforeStep',
        Events::TEST_FAIL => 'testFailed',
        Events::RESULT_PRINT_AFTER => 'print',
    );

   public function seeArrayCount($array, $count)
   {
       echo 'hello';
   }        
}