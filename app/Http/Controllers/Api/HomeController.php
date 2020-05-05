<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Webklex\IMAP\Facades\Client;

class HomeController extends Controller
{
    public function index()
    {
        $oClient = Client::account('default');
        //Connect to the IMAP Server
        //$oClient->connect();



//        $oFolders = $oClient->getFolder('SPAM');
//        $aMessage = $oFolders->messages()->all()->get();

        //dd($oFolderss);
        //dd($oClient->getFolders());





        return view('index');
    }
}
