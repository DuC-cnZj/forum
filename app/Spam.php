<?php

namespace App;

class Spam
{
    public function detect($body)
    {
        $this->detectInvalidKeywords($body);

        return false;
    }

    public function detectInvalidKeywords($body)
    {
        $invalidKeywords = [
            'duc'
        ];

        foreach ($invalidKeywords as $keyword) {
            if (stripos($body, $keyword)) {
                throw new \Exception('error');
            }
        }
    }
}