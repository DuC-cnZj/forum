<?php

namespace App\Inspections;

class KeyHeldDown
{
    public function detect($body)
    {
        if (preg_match('/(.)\\1{8,}/', $body, $matches)) {
            throw new \Exception('error');
        }
    }
}