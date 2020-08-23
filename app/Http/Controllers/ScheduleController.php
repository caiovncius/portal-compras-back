<?php

namespace App\Http\Controllers;

use App\Request;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function send(Request $request)
    {
        foreach($request->offer->partners as $partner) {
            
        }
        
        $model = Program::find(1)->connection;

        $connection = (new FtpService)->setConnection($model);
        try {
            $list = \Storage::disk('onthefly')->files('/');
        } catch (Exception $e) {
            dd($e);
        }

        dd($list);
    }
}
