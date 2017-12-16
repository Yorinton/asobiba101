<?php

namespace App\Http\Controllers;

use Asobiba\Application\Service\AcceptanceReservationService;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    private $service;

    public function __construct(AcceptanceReservationService $service)
    {
        $this->service = $service;
    }

    public function acceptReservation(Request $req)
    {
        try {
            $this->service->reserve($this->reqToArray($req));
        }
        catch(\InvalidArgumentException $e){
            return $e->getMessage();
        }
    }

    //別クラスorトレイトに移動
    private function reqToArray(Request $req): array
    {
        $exception = [
            'attributes',
            'request',
            'query',
            'server',
            'files',
            'cookies',
            'headers'
        ];

        foreach($req as $key => $value){
            if(in_array($key,$exception)){
                continue;
            }
            $array[$key] = $value;
        }
        return $array;
    }
}
