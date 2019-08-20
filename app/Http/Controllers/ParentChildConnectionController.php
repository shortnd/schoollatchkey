<?php

namespace App\Http\Controllers;

use App\Child;
use App\ChildParent;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class ParentChildConnectionController extends Controller
{
    public function attach($childParent, Child $child)
    {
        try {
            $childParent = ChildParent::where('user_id', $childParent)->first();
        } catch (ModelNotFoundException $e) {
            throw new $e;
        }

        $childParent->children()->attach($child);
        return back();
    }

    public function detach($childParent, Child $child)
    {
        try {
            $childParent = ChildParent::where('user_id', $childParent)->first();
        } catch (ModelNotFoundException $e) {
            throw new $e;
        }

        $childParent->children()->detach($child);
        return back();
    }
}
