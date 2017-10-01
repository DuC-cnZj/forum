<?php

namespace App\Filters;

use Illuminate\Http\Request;

abstract class Filters
{
    /**
     * @var Request
     */
    protected $request, $builder;

    protected $filters = [];

    /**
     * ThreadsFilters constructor.
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * @param $builder
     * @return mixed
     */
    public function apply($builder)
    {
        $this->builder = $builder;

        $this->getFilters()->filter(function ($filter) {
            return method_exists($this, $filter);
        })->each(function ($filter, $value) {
            $this->$filter($value);
        });

//        dd($this->request->only($this->filters));
//        foreach ($this->getFilters() as $filter => $value) {
//            if (method_exists($this, $filter)) {
//                $this->$filter($value);
//            }

//        }

//        if ( ! $username = $this->request->by) return $builder;

        return $this->builder;
    }

    public function getFilters()
    {
        return collect($this->request->only($this->filters))->flip();
    }


}