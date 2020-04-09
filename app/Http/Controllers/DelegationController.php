<?php

namespace App\Http\Controllers;

use App\Delegation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DelegationController extends Controller
{
    public function addDeleg(Request $request){
        $name=$request->name;
        $gouv=$request->gouv;

        $gouv_id = DB::table('gouvernorats')
            ->where([
                ['gouvernorats.name', '=', $gouv],
            ])
            ->select('gouvernorats.id')
            ->get()->first()->id;

        Delegation::create([
            'name' => $name,
            'gouvernorat_id' => $gouv_id
        ]);
    }
}