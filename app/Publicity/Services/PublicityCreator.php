<?php

namespace App\Publicity\Services;

use App\Helpers\FileUploader;
use App\Publicity;
use App\Publicity\Contracts\PublicityCreatable;

class PublicityCreator implements PublicityCreatable
{
    /**
     * @param array $data
     * @return bool|mixed
     * @throws \Exception
     */
    public function store(array $data)
    {
        try {
            $publicy = Publicity::query()->first();

            if (is_null($publicy)) {
                $publicy = new Publicity();
                $publicy->code = $data['code'];
                $publicy->desc = $data['desc'];
                $publicy->date_create = $data['createDate'];
                $publicy->date_publish = $data['publishDate'];
                $publicy->image = FileUploader::uploadFile($data['image']);
                $publicy->save();

                return true;
            }

            $publicy->code = $data['code'];
            $publicy->desc = $data['desc'];
            $publicy->date_create = $data['createDate'];
            $publicy->date_publish = $data['publishDate'];
            $publicy->image = FileUploader::uploadFile($data['image']);
            $publicy->save();

            return true;
        } catch (\Exception $exception) {
            throw $exception;
        }
    }
}
