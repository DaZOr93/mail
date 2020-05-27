<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\ConnectServices;
use Illuminate\Http\JsonResponse;
use Webklex\IMAP\Exceptions\ConnectionFailedException;
use Webklex\IMAP\Exceptions\MaskNotFoundException;


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

    /**
     * Подгрузка новых сообщений
     * @param $folder
     * @return JsonResponse
     * @throws ConnectionFailedException
     * @throws MaskNotFoundException
     */
    public function __invoke($folder)
    {
        return $this->services->store($folder);
    }
}
