<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\ConnectServices;



class StoreMessagesController extends Controller
{
    /**
     * @var ConnectServices
     */
    protected $services;


    public function __construct(ConnectServices $services)
    {
        $this->services = $services;
    }

    public function __invoke()
    {
        return $this->services->store();
    }
}
