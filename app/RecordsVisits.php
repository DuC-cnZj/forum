<?php

namespace App;

use Illuminate\Support\Facades\Redis;

trait RecordsVisits
{

    public function recordVisit()
    {
        Redis::incr($this->visitCacheKey());

        return $this;
    }

    public function visits()
    {
        return Redis::get($this->visitCacheKey()) ?? 0;
    }

    public function resetVisits()
    {
        Redis::del($this->visitCacheKey());
    }

    public function visitCacheKey()
    {
        return "threads.{$this->id}.visits";
    }
}