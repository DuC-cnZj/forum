<?php

namespace App\Inspections;

use Exception;

class InvalidKeywords
{
    protected $keywords = [
         'fuck', '艹'
    ];

    public function detect($body)
    {
        foreach ($this->keywords as $keyword) {
            if (stripos($body, $keyword) !== false) {
                throw new Exception('error');
            }
        }
    }
}