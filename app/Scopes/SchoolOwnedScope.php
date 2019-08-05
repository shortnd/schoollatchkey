<?php


namespace App\Scopes;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use App\School;

class SchoolOwnedScope implements Scope
{
    public function apply(Builder $builder, Model $model)
    {
        $builder->where('school_id', '=', request('school'));
    }

}
