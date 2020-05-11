<?php

namespace App\Http\Controllers\Api\Mails;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Webklex\IMAP\Client;



class BasketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return
     */
    public function index()
    {
        $oClient = new Client([
            'host'          => 'imap.gmail.com',
            'port'          => 993,
            'encryption'    => 'ssl',
            'validate_cert' => true,
            'username'      => 'it2.0team3@gmail.com',
            'password'      => 'hedbv2580',
            'protocol'      => 'imap'
        ]);
        function truncate_string($str, $maxsymbol){
            if (mb_strlen($str) > $maxsymbol){
                $str=mb_substr($str, 0, $maxsymbol).'...' ;
            }
            return $str;

        }

        $oClient->connect();
        $aFolder = $oClient->getFolder('[Gmail]/&BBoEPgRABDcEOAQ9BDA-');
        $aMessage = $aFolder->messages()->all()
            ->setFetchFlags(false)
            ->setFetchBody(false)
            ->setFetchAttachment(false)
            ->get()->paginate('10');


        foreach($aMessage as $oMessage){

               $mails[] =[
                       'subject'=>truncate_string($oMessage->getSubject(), 12),
                        'sender'=>truncate_string($oMessage->getSender()[0]->personal, 12),
                        'date'=>$oMessage->GetDate()->toDateString(),

               ];
            }

        return response()->json($mails, 200);


    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
