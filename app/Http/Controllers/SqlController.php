<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\pregnants as pregnants;
use App\Models\RecordOfPregnancy as RecordOfPregnancy;
use App\Models\sequents as sequents;
use App\Models\sequentsteps as sequentsteps;
use App\Models\users_register as users_register;
use App\Models\logmessage as logmessage;
use App\Models\tracker as tracker;
use App\Models\question as question;
use App\Models\quizstep as quizstep;
use App\Models\reward as reward;
use App\Models\presenting_gift as presenting_gift;
use App\Models\reward_gift as reward_gift;

use Illuminate\Support\Facades\DB;


use App\Http\Controllers\checkmessageController;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\SqlController;
use App\Http\Controllers\CalController;


class SqlController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
      public function users_register_select($user){
        $users_register = users_register::where('user_id',$user)
                                        ->whereNull('deleted_at')
                                        ->first();
        return $users_register;

    }
      public function user_update($user,$answer,$update)
    {          

         switch($update) {
                 case 1 : 
                        $users_register = users_register::where('user_id', $user)
                                                          ->whereNull('deleted_at')
                                                          ->update(['user_name' => $answer ]);
                    break;
                 case 2 : 
                        $users_register = users_register::where('user_id', $user)
                                                          ->whereNull('deleted_at')
                                                          ->update(['user_age' => $answer ]);
                    break;
                 case 3 : 
                        $users_register = users_register::where('user_id', $user)
                                                          ->whereNull('deleted_at')
                                                          ->update(['user_height' => $answer ]);
                    break;
                 case 4 : 
                        $users_register = users_register::where('user_id', $user)
                                                          ->whereNull('deleted_at')
                                                          ->update(['user_Pre_weight' => $answer ]);
                    break;
                  case 5 : 
                        $users_register = users_register::where('user_id', $user)
                                                          ->whereNull('deleted_at')
                                                          ->update(['user_weight' => $answer ]);
                    break;
                 case 6 : 
                        $users_register = users_register::where('user_id', $user)
                                                          ->whereNull('deleted_at')
                                                          ->update(['preg_week' => $answer ]);
                    break;
                 case 7 : 
                        $users_register = users_register::where('user_id', $user)
                                                          ->whereNull('deleted_at')
                                                          ->update(['phone_number' => $answer ]);
                    break;
                 case 8 : 
                        $users_register = users_register::where('user_id', $user)
                                                          ->whereNull('deleted_at')
                                                          ->update(['email' => $answer ]);
                    break;
                 case 9 : 
                        $users_register = users_register::where('user_id', $user)
                                                          ->whereNull('deleted_at')
                                                          ->update(['hospital_name' => $answer ]);
                    break;
                 case 10 : 
                        $users_register = users_register::where('user_id', $user)
                                                          ->whereNull('deleted_at')
                                                          ->update(['hospital_number' => $answer ]);
                    break;
                 case 11 : 
                        $users_register = users_register::where('user_id', $user)
                                                          ->whereNull('deleted_at')
                                                          ->update(['history_medicine' => $answer ]);
                    break;
                 case 12 : 
                        $users_register = users_register::where('user_id', $user)
                                                          ->whereNull('deleted_at')
                                                          ->update(['history_food' => $answer ]);
                    break;
                 case 13 : 
                        $users_register = users_register::where('user_id', $user)
                                                          ->whereNull('deleted_at')
                                                          ->update(['active_lifestyle' => $answer ]);
                    break;
                  case 14 : 
                        $users_register = users_register::where('user_id', $user)
                                                          ->whereNull('deleted_at')
                                                          ->update(['status' => $answer ]);
                    break;
                  case 15 : 
                        $users_register = users_register::where('user_id', $user)
                                                          ->whereNull('deleted_at')
                                                          ->update(['ulife_connect' => $answer ]);
                    break;
         
             }
        
    }

     public function delete_data_all($user)
    {          
        
         //$users_register = users_register::where('user_id', $user)->delete();
        // $RecordOfPregnancy = RecordOfPregnancy::where('user_id', $user)->delete();
         (new ApiController)->api_delete($user);
         $users_register = users_register::where('user_id', $user)
                       ->update(['deleted_at'=>NOW()]);
         $RecordOfPregnancy = RecordOfPregnancy::where('user_id', $user)
                       ->update(['deleted_at'=>NOW()]);
         $tracker = tracker::where('user_id', $user)
                       ->update(['deleted_at'=>NOW()]);

         $sequentsteps = sequentsteps::where('sender_id', $user)->delete();
         //$tracker = tracker::where('user_id', $user)
         //               ->update(['deleted_status'=>'0']);

    }
     public function  pregnants($preg_week){
        $pregnants = pregnants::where('week', $preg_week)->first();
        return $pregnants;

    }
     public function sequents_question($seqcode)
    {          
                   $question = sequents::select('question')
                                ->where('seqcode',$seqcode)
                                ->first();
                   return $question->question;
    }
     public function sequentsteps_seqcode($user)
    {          
                   $sequentsteps = sequentsteps::select('seqcode','nextseqcode','answer')
                                ->where('sender_id',$user)
                                ->first();
                   return $sequentsteps;
    }
     public function sequentsteps_insert($user,$seqcode,$nextseqcode)
    {          
        $sequentsteps = sequentsteps::insert(['sender_id'=>$user,'seqcode' => $seqcode,'answer' => 'NULL','nextseqcode' =>$nextseqcode,'status'=>'0','created_at'=>NOW() , 'updated_at'=>NOW()]);
    }
     public function sequentsteps_update($user,$seqcode,$nextseqcode)
    {          
         $sequentsteps = sequentsteps::where('sender_id', $user)

                       ->update(['seqcode' =>$seqcode,'nextseqcode' => $nextseqcode]);
    }
     public function update_datepreg($strDate1,$user){

         $users_register = users_register::where('user_id', $user)
                       ->update(['date_preg'=>$strDate1]);  

    }
     public function update_dateofbirth($dateofbirth,$user){

         $users_register = users_register::where('user_id', $user)
                       ->update(['dateofbirth'=>$dateofbirth]);  

    }
     public function sequentsteps_update2($user,$answer)
    {          
         $sequentsteps = sequentsteps::where('sender_id', $user)
                       ->update(['answer'=>$answer]);
    }
     public function user_insert($user,$user_name)
    {          
         $users_register = users_register::insert(['user_id'=>$user,'user_name' => $user_name ,'status' => '4','user_age'=>'0','user_height'=>'0','user_Pre_weight'=>'0','user_weight'=>'0','preg_week'=>'0', 'phone_number'=>'NULL','email' =>'NULL','hospital_name'=>'NULL','hospital_number'=>'NULL','history_medicine'=>'NULL', 'history_food'=>'NULL','active_lifestyle'=>'0','created_at'=>NOW(),'updated_at' =>NOW(),'date_preg'=>'NULL','dateofbirth'=>'NULL','ulife_connect'=>'0']);
    }
     public function tracker_insert1($user,$tracker)
    {          
          $tracker = tracker::insert(['user_id'=>$user,'breakfast' => $tracker,'lunch' => 'NULL','dinner' => 'NULL','dessert_lu' => 'NULL' ,'dessert_din' => 'NULL' ,'exercise' => 'NULL','vitamin'=>'NULL','created_at'=>NOW(),'updated_at' =>NOW(),'data_to_ulife'=>'0']);
    }
     public function tracker_update($user,$column,$tracker)
    {          

         $tracker_update = tracker::where('user_id',$user)
                                        ->whereNull('deleted_at')
                                        ->orderBy('created_at', 'desc')
                                        ->first();
         $created_at   =   $tracker_update ->created_at;                         
         $tracker_update = tracker::where('user_id', $user)
                       ->where('created_at', $created_at)
                       ->update([ $column =>$tracker]);

        
         return $tracker_update;
    }
     public function RecordOfPregnancy_insert($preg_week, $user_weight,$user){
     $RecordOfPregnancy = RecordOfPregnancy::insert(['user_id'=>$user,'preg_week' => $preg_week,'preg_weight' => $user_weight, 'created_at'=>NOW(),'updated_at' =>NOW(),'data_to_ulife'=>'0']);
    }
     public function RecordOfPregnancy_update($user_weight,$user,$date){

     $RecordOfPregnancy = RecordOfPregnancy::where('user_id', $user)
                       ->where('preg_week', $date)
                       ->update(['preg_weight' =>$user_weight]);
    }
     public function RecordOfPregnancy_select($user){

     $RecordOfPregnancy = RecordOfPregnancy::where('user_id', $user)
                       ->whereNull('deleted_at')
                       ->orderBy('updated_at', 'desc')
                       ->first();
     return $RecordOfPregnancy;
    }

     public function log_message($user, $Message,$message_type)
    {          
         $sequentsteps = logmessage::insert(['user_id'=>$user,'message_type'=>$message_type,'message' =>$Message ,'created_at'=>NOW()]);
    }
       public function tracker_cal($user)
    {          
         $record = tracker::where('user_id',$user)
                               ->whereNull('deleted_at')
                               ->orderBy('created_at', 'DESC')
                               ->first();
          return $record;
    }

    public function select_question($date){
        $select_question = question::where('date_question',$date)
                                        ->first();
        return $select_question;

    }
    public function insert_reward($user){
        $reward = reward::insert(['user_id'=>$user,'question_num' => $question_num,'question_ans' => $question_ans,'code_quiz'=>$code_quiz,'point' => $point,'feq_ans_week' => $feq_ans_week,'answer_status' => $answer_status,'created_at'=>NOW(),'updated_at' =>NOW()]);
        return $reward;

    }
    public function insert_quizstep($user,$code_quiz,$question_num,$answer_status){
        $quizstep = quizstep::insert(['user_id'=>$user,'code_quiz'=>$code_quiz,'question_num' => $question_num,'answer_status' => $answer_status,'created_at'=>NOW(),'updated_at' =>NOW()]);
        return $quizstep;

    }
    public function select_quizstep($user,$code_quiz,$question_num){
        $select_quizstep = quizstep::where('user_id',$user)
                                        ->where('code_quiz',$code_quiz)
                                        ->where('question_num',$question_num)
                                        ->first();
        return $select_quizstep;
    }
    public function select_quizstep_user($user){
        $select_quizstep1 = quizstep::where('user_id',$user)
                                        ->orderBy('question_num', 'DESC')
                                        ->first();
        return $select_quizstep1;
    }
    public function select_question_user($code_quiz1,$question_num1){
        $question2 = question::where('code_quiz',$code_quiz1)
                              ->where('question_num',$question_num1)
                              ->first();
        return $question2;
    }   
    public function quizstep_update($user,$question_ans,$answer_status,$correct_ans,$code_quiz1,$question_num1)
    {          
         $quizstep_up = quizstep::where('user_id', $user)
                       ->where('code_quiz', $code_quiz1)
                       ->where('question_num', $question_num1)
                       ->update(['question_ans'=>$question_ans,'answer_status'=>$answer_status,'correct_ans'=>$correct_ans]);
        return $quizstep_up ;
    }
    public function ins_reward($user,$code_quiz1,$point,$feq_ans_week){
        $insert_reward = reward::insert(['user_id'=>$user,'code_quiz'=>$code_quiz1,'point' => $point,'feq_ans_week' => $feq_ans_week,'created_at'=>NOW(),'updated_at' =>NOW()]);
        return $insert_reward;

    }
    public function update_reward($user,$code_quiz1,$point,$feq_ans_week){
            $reward_up = reward::where('user_id', $user)
                       ->where('code_quiz', $code_quiz1)
                       ->update(['point'=>$point,'feq_ans_week'=>$feq_ans_week]);
        return $reward_up ;

    }  
    public function reward_select($user,$code_quiz1){
        $reward1 = reward::where('user_id',$user)
                                ->where('code_quiz', $code_quiz1)
                                ->first();
        return $reward1;
    }  
    public function ins_reward1($user,$point,$feq_ans_week,$feq_ans_meals){
        $insert_reward1 = reward::insert(['user_id'=>$user,'point' => $point,'feq_ans_week' => $feq_ans_week,'feq_ans_meals'=>$feq_ans_meals,'created_at'=>NOW(),'updated_at' =>NOW()]);
        return $insert_reward1;

    }
    public function update_reward1($user,$point,$feq_ans_week,$feq_ans_meals){
            $reward_up1 = reward::where('user_id', $user)
                       ->update(['point'=>$point,'feq_ans_week'=>$feq_ans_week,'feq_ans_meals'=>$feq_ans_meals]);
        return $reward_up1 ;

    }  
    public function reward_select1($user){
        $reward1 = reward::where('user_id',$user)
                                ->first();
        return $reward1;
    }
    public function reward_count($user){
        $reward_count = reward::where('user_id',$user)
                                ->count();
        return $reward_count;
    }
    public function reward_gift(){
        // $reward_gift = reward_gift::get();
     
        $reward_gift = reward_gift::
                      whereRaw('? between date_start and date_exp', [date('Y-m-d')])
                      ->get()
                      ->toArray();
        return $reward_gift;
    }
    public function ins_presenting_gift($user,$code_gift,$presenting_status){
      /////เพิ่มวันหมดอายุ
        $insert_reward1 = presenting_gift::insert(['user_id'=>$user,'code_gift' => $code_gift,'presenting_status' => $presenting_status,'created_at'=>NOW(),'updated_at' =>NOW()]);
        return $insert_reward1;

    } 
    public function update_reward1_point($user,$point){
            $reward_up1 = reward::where('user_id', $user)
                       ->update(['point'=>$point]);
        return $reward_up1 ;

    } 
    public function reward_gift2($code_gift){
        $reward1 = reward_gift::where('code_gift',$code_gift)
                                ->first();
        return $reward1;
    }  
    public function presenting_gift_select($user){
        $presenting_gift =  presenting_gift::where('presenting_gift.user_id',$user)
                                           -> where('presenting_gift.presenting_status','1')
                                           ->join('reward_gift', 'reward_gift.code_gift', '=', 'presenting_gift.code_gift')
                                           ->select('reward_gift.code_gift', 'reward_gift.name_gift') 
                                           ->get();


       
        return  $presenting_gift;
    }
    public function update_presenting_gift($user,$presenting_status,$code_gift){
            $reward_up1 = presenting_gift::where('user_id', $user)
                       ->where('code_gift', $code_gift)
                       ->update(['presenting_status'=>$presenting_status]);
        return $reward_up1 ;

    } 
    public function presenting_gift_count($user){
      
        $presenting_gift1 =  presenting_gift::where('user_id',$user)
                                           ->where('presenting_status',1)
                                           ->distinct('code_gift')->count('code_gift');
        return  $presenting_gift1;

    } 
    public function reward_gift_count($code_gift){
        $reward1 = reward_gift::where('code_gift',$code_gift)
                                ->count();
        return $reward1;
    } 
    public function presenting_gift_group($user){
           $data = presenting_gift::where('presenting_gift.presenting_status',1)
                 ->where('presenting_gift.user_id',$user)
                 ->join('reward_gift', 'reward_gift.code_gift', '=', 'presenting_gift.code_gift')
                 ->select('reward_gift.name_gift','presenting_gift.code_gift', DB::raw('count(*) as total'))
                 ->groupBy('presenting_gift.code_gift')
                 ->get()
                 ->toArray();

      return $data;

    } 
    public function presenting_gift_check($user,$code_gift){
      
        $presenting_gift1 =  presenting_gift::where('user_id',$user)
                                           ->where('presenting_status',1)
                                           ->where('code_gift',$code_gift)
                                           ->distinct('code_gift')->count('code_gift');
        return  $presenting_gift1;

    } 
}
