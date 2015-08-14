<?php

namespace App\Exceptions;

use Exception;

class RedirectException extends Exception
{
    protected $redirectUrl;

    public function __construct($redirectUrl = '')
    {
        parent::__construct();

        $this->redirectUrl = $redirectUrl;
    }

    public function getRedirectUrl()
    {
        return $this->redirectUrl;
    }
}