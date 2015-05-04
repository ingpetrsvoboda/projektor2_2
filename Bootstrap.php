<?php

######### EXCEPTION HANDLER ################################
/**
 * Exception handler zachytává všechny výjimky, vypíše českou hlavičku HTML a znovu výjimku vyhodí.
 */

function exceptionHandler($e) {
        // české texty v exceptions (i v xdebug), bez konce body a html si prohlížeč musí poradit
        echo
   '<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta http-equiv="Content-Language" content="cs"> 
    </head>      
    <body>';
        throw $e;
}
set_exception_handler('exceptionHandler');

