<?php

namespace App\Http\Controllers;

use App\Program;
use App\Services\FileOrder;
use App\Services\FileReturn;
use App\Services\FtpService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function ftp()
    {
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
