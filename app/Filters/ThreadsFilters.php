<?php

namespace App\Filters;

use App\User;

class ThreadsFilters extends Filters
{
    protected $filters = ['by', 'popular', 'unanswered'];
    /**
     * @param $username
     * @return mixed
     */
    protected function by($username)
    {
        $user = User::where('name', $username)->firstOrFail();

        return $this->builder->where('user_id', $user->id);
    }

    protected function popular()
    {
        // 将上面的 latest() 的 orders 清空 
        $this->builder->getQuery()->orders = [];

        return $this->builder->orderBy('replies_count', 'desc');
    }

    protected function unanswered()
    {
        return $this->builder->where('replies_count', 0);
    }
}