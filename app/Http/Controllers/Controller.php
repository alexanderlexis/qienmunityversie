<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesResources;

class Controller extends BaseController
{
    use AuthorizesRequests, AuthorizesResources, DispatchesJobs, ValidatesRequests;
        
    public static function authenticate(){
        switch(auth()->user()->rol){
                case 0;
                    $admin = "block";
                    $docent = "block";
                break;
                case 1;
                    $admin = "none";
                    $docent = "block";
                break;
                default:
                    $admin = "none";
                    $docent = "none";        
        }
        $data = array(
            'admin' => $admin,
            'docent' => $docent);
        return $data;
    }
}
