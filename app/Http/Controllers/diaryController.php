<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\pregnants as pregnants;
use App\Models\RecordOfPregnancy as RecordOfPregnancy;
use App\Models\sequents as sequents;
use App\Models\sequentsteps as sequentsteps;
use App\Models\users_register as users_register;
use App\Models\tracker as tracker;
use App\Models\question as question;
use App\Models\quizstep as quizstep;
use App\Models\reward as reward;

use View;
use DB;
use Carbon\Carbon;
use DateTime;

class diaryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
   
    public function show_food($id)
    {

        //$user = 'U2dc636d2cd052e82c29f5284e00f69b9';

           $record = tracker::where('user_id',$id)
                               ->whereNull('deleted_at')
                               ->where('created_at', '>=',Carbon::now()->subDays(15))
                               ->get();


        return View::make('food_diary')->with('record',$record);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show_vitamin($user)
    {

        //$user = 'U2dc636d2cd052e82c29f5284e00f69b9';
          
           $record = tracker::where('user_id',$user)
                               ->whereNull('deleted_at')
                               ->where('created_at', '>=',Carbon::now()->subDays(15))
                               ->get();


        return View::make('vitamin_diary')->with('record',$record);
    }

     public function show_exercise($user)
    {

        //$user = 'U2dc636d2cd052e82c29f5284e00f69b9';
          
           $record = tracker::where('user_id',$user)
                               ->whereNull('deleted_at')
                               ->where('created_at', '>=',Carbon::now()->subDays(15))
                               ->get();


        return View::make('exercise_diary')->with('record',$record);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

      public function show_weight($user)
    {

        //$user = 'U2dc636d2cd052e82c29f5284e00f69b9';
         // $user = 'Udb5efc89a4729c093051ce8813454223';
             $pre_weight = users_register::where('user_id', $user)
                     ->whereNull('deleted_at')
                     ->first();
              $record = DB::table('RecordOfPregnancy')
                     ->select('preg_week','preg_weight')
                     ->where('user_id', $user)
                     ->whereNull('deleted_at')
                     ->distinct()
                     ->orderBy('preg_week', 'asc')
                     ->get();

        return View::make('weight_diary')->with('record',$record)->with('pre_weight',$pre_weight);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
}
