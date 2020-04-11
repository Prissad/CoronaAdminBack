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

    public function getDelegations(Request $request){
        $gouv=$request->gouv;

        $delegations = DB::table('delegations')
            ->join('gouvernorats', 'delegations.gouvernorat_id', 'gouvernorats.id')
            ->where([
                ['gouvernorats.name', '=', $gouv],
            ])
            ->select('delegations.name')
            ->get();

        return response()->json($delegations);
    }
}