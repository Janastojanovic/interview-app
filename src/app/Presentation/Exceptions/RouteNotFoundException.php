<?php

namespace App\Presentation\Exceptions;

class RouteNotFoundException extends \Exception
{
    protected $message = '404 Not Found';
}
