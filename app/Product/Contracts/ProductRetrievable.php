<?php


namespace App\Product\Contracts;


interface ProductRetrievable
{
    public function getProducts(array $querySearchParams = []);
}
