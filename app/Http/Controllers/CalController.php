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

use App\Http\Controllers\checkmessageController;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\SqlController;
use App\Http\Controllers\CalController;

class CalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
  public function cal_calculator($user_age,$active_lifestyle,$user_Pre_weight,$preg_week){

        if ( $user_age>=10 && $user_age<=18) {
          $cal=(13.384*$user_Pre_weight )+692.6;
        }elseif ($user_age>18 && $user_age<31) {
          $cal=(14.818*$user_Pre_weight )+486.6;
        }else{
          $cal=(8.126*$user_Pre_weight )+845.6;
        }

        if ($active_lifestyle=='3'  ) {
          $total = $cal*2.0;
        }elseif($active_lifestyle =='2') {
          $total = $cal*1.7;
        }else{
          $total = $cal*1.4;

        } 

        if ($preg_week >=13 && $preg_week<=40) {
                  $cal1 = $total+300;
                  $cal = number_format($cal1);  
        }else{
                 $cal = number_format($total);
        }
            return  $cal;
    }


        public function weight_criteria($bmi){

                    if ($bmi<18.5) {
                      $result="น้ำหนักน้อย";
                    } elseif ($bmi>=18.5 && $bmi<=22.9) {
                      $result="น้ำหนักปกติ";
                    } elseif ($bmi>=23.0 && $bmi<=29.9) {
                      $result="น้ำหนักเกิน";
                    } elseif ($bmi>=30.0) {
                      $result="อ้วน";
                    }

            return $result;
    }

       public function bmi_calculator($user_Pre_weight,$user_height){

                $height = $user_height*0.01;
                $bmi = $user_Pre_weight/($height*$height);
                $bmi = number_format($bmi, 2, '.', '');
            return $bmi;
    }

       public function expdate($startdate,$datenum){
                                     $startdatec=strtotime($startdate); // ทำให้ข้อความเป็นวินาที
                                     $tod=$datenum*86400; // รับจำนวนวันมาคูณกับวินาทีต่อวัน
                                     $ndate=$startdatec-$tod; // นับบวกไปอีกตามจำนวนวันที่รับมา
                                     return $ndate; // ส่งค่ากลับ
    }

    public function pregnancy_calculator($user,$userMessage,$seqcode)
    {          

                if(strpos($userMessage, '/') !== false ){
                  $pieces = explode("/", $userMessage);
                  $date   = str_replace("","",$pieces[0]);
                  $month  = str_replace("","",$pieces[1]);
                  $today_years= date("Y") ;
                  $today_month= date("m") ;
                  $today_day  = date("d") ;

                if(is_numeric($month) == false){
                    $month = (new checkmessageController)->check_month($month);
                  }
                }elseif(strpos($userMessage, ':') !== false ){
                  $pieces = explode(":", $userMessage);
                  $date   = str_replace("","",$pieces[0]);
                  $month  = str_replace("","",$pieces[1]);
                  $today_years= date("Y") ;
                  $today_month= date("m") ;
                  $today_day  = date("d") ;
                if(is_numeric($month) == false){
                    $month = (new checkmessageController)->check_month($month);
                  }
                }elseif(strpos($userMessage, '-') !== false ){
                  $pieces = explode("-", $userMessage);
                  $date   = str_replace("","",$pieces[0]);
                  $month  = str_replace("","",$pieces[1]);
                  $today_years= date("Y") ;
                  $today_month= date("m") ;
                  $today_day  = date("d") ;
         
                  if(is_numeric($month) == false){
                    $month = (new checkmessageController)->check_month($month);
                  }
                }elseif(strpos($userMessage, ' ') !== false ){
                  $pieces = explode(" ", $userMessage);
                  $date   = str_replace("","",$pieces[0]);
                  $month  = str_replace("","",$pieces[1]);
                  $today_years= date("Y") ;
                  $today_month= date("m") ;
                  $today_day  = date("d") ;

                  if(is_numeric($month) == false){
                    $month = (new checkmessageController)->check_month($month);
                     if($month=='00'){
                      $textReplyMessage = 'ฉันคิดว่าคุณพิมพ์เดือนผิดนะ';
                      return   $textReplyMessage;
                     }
                  }
                  
                }else{
                     $textReplyMessage = 'ฉันคิดว่าคุณพิมพ์ผิดตามรูปแบบที่กำหนดนะคะ ตัวอย่างการพิมพ์เช่น 12 มกราคม หรือ 13:03 ค่ะ ลองพิมพ์ใหม่นะคะ';
                      return   $textReplyMessage;
                }
              
                 
                  if($month> '12'|| $month<'1' ){
                      $textReplyMessage = 'ฉันคิดว่าคุณพิมพ์เดือนผิดนะ';
                      return   $textReplyMessage;
                  }


                  $day = (new checkmessageController)->check_day($date ,$month);

            
        switch($seqcode) {
     
                 case ($seqcode=='1015' || $seqcode =='10640'): 

                            if($month>$today_month && $month<=12 && $date<=31 && $day=='' ){
                                        $years = $today_years-1;
                                        $strDate1 = $years."-".$month."-".$date;
                                        $strDate2=date("Y-m-d");
                                        
                                        $date_pre =  (strtotime($strDate2) - strtotime($strDate1))/( 60 * 60 * 24 );
                                        $week = $date_pre/7;
                                        $w_preg = number_format($week);
                                        $day = $date_pre%7;
                                        $day_preg = number_format($day);

                                        if($w_preg>41){
                                              $textReplyMessage = 'ฉันคิดว่าอายุครรภ์ของคุณผิดนะ';
                                              return   $textReplyMessage;
                                        }
                                        $age_pre = 'คุณมีอายุครรภ์'.$w_preg .'สัปดาห์'.  $day_preg .'วัน' ;
                                        (new SqlController)->sequentsteps_update2($user,$w_preg); 
                                        (new SqlController)->update_datepreg($strDate1,$user); 
                                        return  $age_pre;  
                                           

                                    }elseif($month<=$today_month && $month<=12 && $date<=31 && $day==''){
                                        $strDate1 = $today_years."-".$month."-".$date;
                                        $strDate2=date("Y-m-d");
                                        $date_pre =  (strtotime($strDate2) - strtotime($strDate1))/( 60 * 60 * 24 );;
                                        $week = $date_pre/7;
                                        $w_preg = number_format($week);
                                        $day = $date_pre%7;
                                        $day_preg = number_format($day);

                                        if($w_preg>41){
                                              $textReplyMessage = 'ฉันคิดว่าอายุครรภ์ของคุณผิดนะ';
                                              return   $textReplyMessage;
                                        }
                                        $age_pre = 'คุณมีอายุครรภ์'. $w_preg .'สัปดาห์'.  $day_preg .'วัน' ;
                                        (new SqlController)->sequentsteps_update2($user,$w_preg);
                                        (new SqlController)->update_datepreg($strDate1,$user); 
                                        return  $age_pre;    
                                    }else{

                                        // $textReplyMessage = 'ดูเหมือนคุณจะพิมพ์วันที่ผิดนะ';
                                        return   $day ;

                                    }
                
                    break;
                 case ($seqcode=='2015'|| $seqcode=='20640')  : 
                        
                         if( $month < $today_month && $month<=12 && $date<=31 && $day==''){
                                 $years = $today_years+1;
                                 $strDate1 = $years."-".$month."-".$date;
                                 $strDate2=date("Y-m-d");
                                
                                 $date_pre =  (strtotime($strDate1) - strtotime($strDate2))/( 60 * 60 * 24 );
                                 $week = $date_pre/7;
                                 $week_preg =floor($week);
                                 $day = $date_pre%7;
                                 $day_preg = number_format($day);
                                 $w_preg = 39-$week_preg  ;
                                 $d = 7-$day_preg;


                         switch ($d){
                         case '7':
                              $w_preg = $w_preg + 1;
                                if($w_preg>41){
                                              $textReplyMessage = 'ฉันคิดว่าอายุครรภ์ของคุณผิดนะ';
                                              return   $textReplyMessage;
                                        }
                              $replyData = 'คุณมีอายุครรภ์'.  $w_preg  .'สัปดาห์';
                              (new SqlController)->sequentsteps_update2($user,$w_preg);

                                    $dr=$this->expdate($strDate1,266); 
                                    $df=date("Y-m-d",$dr); 
                                    (new SqlController)->update_datepreg($df,$user); 

                              return  $replyData;
                          break;
                         default:
                                if($w_preg>41){
                                              $textReplyMessage = 'ฉันคิดว่าอายุครรภ์ของคุณผิดนะ';
                                              return   $textReplyMessage;
                                        }
                              $replyData = 'คุณมีอายุครรภ์'. $w_preg .'สัปดาห์'.  $d .'วัน' ;
                              (new SqlController)->sequentsteps_update2($user,$w_preg);
                              $dr=$this->expdate($strDate1,266); 
                              $df=date("Y-m-d",$dr);
                              (new SqlController)->update_datepreg($df,$user); 
                              return  $replyData;
                          break;
                          }

                         }elseif($month >= $today_month && $month<=12 && $date<=31){
                                 $years = $today_years;
                                 $strDate1 = $years."-".$month."-".$date;
                                 $strDate2=date("Y-m-d");
                                
                                 $date_pre =  (strtotime($strDate1) - strtotime($strDate2))/( 60 * 60 * 24 );
                                 $week = $date_pre/7;
                                 $week_preg =floor($week);
                                 $day = $date_pre%7;
                                 $day_preg = number_format($day);
                                 $w_preg = 39-$week_preg  ;
                                 $d = 7-$day_preg;
                      
                          switch ($d){
                               case '7':
                                 if($w_preg>41){
                                              $textReplyMessage = 'ฉันคิดว่าอายุครรภ์ของคุณผิดนะ';
                                              return   $textReplyMessage;
                                        }
                                  $w_preg = $w_preg + 1;
                                  $replyData ='คุณมีอายุครรภ์'.  $w_preg  .'สัปดาห์';
                                  (new SqlController)->sequentsteps_update2($user,$w_preg);
                                  $dr=$this->expdate($strDate1,266); 
                                  $df=date("Y-m-d",$dr);
                                  (new SqlController)->update_datepreg($df,$user); 
                                  return  $replyData;
                                 break;
                               default:
                                 if($w_preg>41){
                                              $textReplyMessage = 'ฉันคิดว่าอายุครรภ์ของคุณผิดนะ';
                                              return   $textReplyMessage;
                                        }
                                  $replyData = 'คุณมีอายุครรภ์'. $w_preg .'สัปดาห์'.  $d .'วัน' ;
                                  (new SqlController)->sequentsteps_update2($user,$w_preg);
                                  $dr=$this->expdate($strDate1,266); 
                                  $df=date("Y-m-d",$dr);
                                  (new SqlController)->update_datepreg($df,$user); 
                                 return  $replyData;
                                 break;
                           }
                         }else{

                                        // $textReplyMessage = 'ดูเหมือนคุณจะพิมพ์ไม่ถูกต้อง';
                                        // return   $textReplyMessage;
                                  return   $day ;

                                    }
               
                     break;

                   
      }
    }


    public function cal_food($tracker){
                                 $d = explode(" ",$tracker);
                                    $u = [];
                                    $da= [];

                                      $json1 = file_get_contents('calfood.json');
                                      $json= json_decode($json1);
                                                foreach($json->data as $item)
                                                  {
                                                    
                                                    foreach($d as $item1)
                                                      if(strpos( $item1, $item->id ) !== false )
                                                      {

                                                        $da[]= $item->content;
                                                        $u[] = $item->cal;
                                                        // $sum =  array_sum($u);
                                                                                
                                                      }    
                                    }
                   return $da ;
                    // if(empty( $da )) {
                     
                    //        $userMessage  = '😋';
                     
                    // } else {
                     
                    //        $comma_separated = implode("\n", $da);
                    //        $userMessage = "วันนี้คุณแม่กิน \n".$comma_separated."\n \n"."พลังงาน: ".$sum."kcal";
                     
                    // }

                    // return $userMessage;

  }public function cal_sum_food($tracker){
                                 $d = explode(" ",$tracker);
                                    $u = [];
                                    $da= [];

                                      $json1 = file_get_contents('calfood.json');
                                      $json= json_decode($json1);
                                                foreach($json->data as $item)
                                                  {
                                                    
                                                    foreach($d as $item1)
                                                      if(strpos( $item1, $item->id ) !== false )
                                                      {

                                                        // $da[]= $item->content;
                                                        $u[] = $item->cal;
                                                        $sum =  array_sum($u);
                                                                                
                                                      }    
                                    }
                        if(empty($sum)){
                          $sum=null;
                        }
                    return $sum;

  }
     
}
