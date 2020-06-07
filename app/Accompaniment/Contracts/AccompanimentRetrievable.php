<?php

namespace App\Accompaniment\Contracts;

interface AccompanimentRetrievable
{
    public function getAccompaniments(array $params = []);
}
