<?php
namespace BurnerMap\Controllers;

use Illuminate\Support\Facades\Response;

class LoadSysFiles
{
    public function jqueryJs()
    {
        $response = Response::make(
            file_get_contents('../vendor/components/jquery/jquery.min.js'));
        $response->header('Content-Type', 'application/javascript');
        return $response;
    }

    public function jqueryUiJs()
    {
        $response = Response::make(
            file_get_contents('../vendor/components/jqueryui/jquery-ui.min.js'));
        $response->header('Content-Type', 'application/javascript');
        return $response;
    }

    public function jqueryUiCss()
    {
        $response = Response::make(
            file_get_contents('../vendor/components/jqueryui/themes/base/jquery-ui.min.css'));
        $response->header('Content-Type', 'text/css');
        return $response;
    }
}