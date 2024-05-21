<?php

namespace App\Class\Filters;

use App\Models\Homeworks;
use App\Models\User;
use Illuminate\Http\Request;

class Filters
{

    public function filterU(Request $r){
        $h=(new User)->newQuery();
        !$r->name?:$h->where('name','like','%'.$r->name.'%');

        $h= $h->select('id','name','email')->get();

        $h=$h->map(function($hh){
            $hh->homew;
            $hh->homew=$hh->homew->map(function($hw){
                $hw->status_text=$hw->status==0?'waiting':'done';
                return $hw;
            })->values()->all();
            return $hh;
        })->values()->all();

        return $h;
    }

}
