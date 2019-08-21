<?php

namespace App\Filters;

use Illuminate\Http\Request;

abstract class Filters
{
    protected $request;
    /**
     * The Eloquent builder.
     *
     * @var \Illuminate\Database\Eloquent\Builder
     */
    protected $builder;
    protected $filters=[];

    public function __construct(Request $request)
    {
        $this->request = $request;
    }
    public function apply($builder)
    {
        $this->builder = $builder;
   //     dd($this->request->only($this->filters));
        foreach ($this->getFilters() as $filter=>$value) {
            if (method_exists($this, $filter)) {
                 $this->$filter($value);
            }
           
        }
        return $this->builder;
    }
    public function getFilters(){
        return $this->request->only($this->filters);
    }
}
