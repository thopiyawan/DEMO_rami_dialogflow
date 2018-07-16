<?php

namespace App\Http\Controllers;

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


use Image; 
use Carbon\Carbon;
use DateTime;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

use LINE\LINEBot;
use LINE\LINEBot\HTTPClient;
use LINE\LINEBot\HTTPClient\CurlHTTPClient;
//use LINE\LINEBot\Event;
//use LINE\LINEBot\Event\BaseEvent;
//use LINE\LINEBot\Event\MessageEvent;
use LINE\LINEBot\MessageBuilder;
use LINE\LINEBot\MessageBuilder\TextMessageBuilder;
use LINE\LINEBot\MessageBuilder\StickerMessageBuilder;
use LINE\LINEBot\MessageBuilder\ImageMessageBuilder;
use LINE\LINEBot\MessageBuilder\LocationMessageBuilder;
use LINE\LINEBot\MessageBuilder\AudioMessageBuilder;
use LINE\LINEBot\MessageBuilder\VideoMessageBuilder;
use LINE\LINEBot\ImagemapActionBuilder;
use LINE\LINEBot\ImagemapActionBuilder\AreaBuilder;
use LINE\LINEBot\ImagemapActionBuilder\ImagemapMessageActionBuilder ;
use LINE\LINEBot\ImagemapActionBuilder\ImagemapUriActionBuilder;
use LINE\LINEBot\MessageBuilder\Imagemap\BaseSizeBuilder;
use LINE\LINEBot\MessageBuilder\ImagemapMessageBuilder;
use LINE\LINEBot\MessageBuilder\MultiMessageBuilder;
use LINE\LINEBot\TemplateActionBuilder;
use LINE\LINEBot\TemplateActionBuilder\DatetimePickerTemplateActionBuilder;
use LINE\LINEBot\TemplateActionBuilder\MessageTemplateActionBuilder;
use LINE\LINEBot\TemplateActionBuilder\PostbackTemplateActionBuilder;
use LINE\LINEBot\TemplateActionBuilder\UriTemplateActionBuilder;
use LINE\LINEBot\MessageBuilder\TemplateBuilder;
use LINE\LINEBot\MessageBuilder\TemplateMessageBuilder;
use LINE\LINEBot\MessageBuilder\TemplateBuilder\ButtonTemplateBuilder;
use LINE\LINEBot\MessageBuilder\TemplateBuilder\CarouselTemplateBuilder;
use LINE\LINEBot\MessageBuilder\TemplateBuilder\CarouselColumnTemplateBuilder;
use LINE\LINEBot\MessageBuilder\TemplateBuilder\ConfirmTemplateBuilder;
use LINE\LINEBot\MessageBuilder\TemplateBuilder\ImageCarouselTemplateBuilder;
use LINE\LINEBot\MessageBuilder\TemplateBuilder\ImageCarouselColumnTemplateBuilder;
class ApiController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


 public function addChild_api($token,$user){
                      
                                  $users_register =   (new SqlController)->users_register_select($user);
                                  $weight = $users_register->user_Pre_weight;
                                  $height = $users_register->user_height;
                                  $men = $users_register->date_preg;
                                  $addChild_api = array(
                                    'access_token'=> $token,
                                    'last_menstruation'=>  $men,
                                    'time'=> '1',
                                    'weight'=> $weight,
                                    'height'=> $height
                                  );
                             
                                      $addChild_json = json_encode($addChild_api);  
                                      $url ='http://128.199.147.57/api/v1/peat/addChild';
                                      $ch = curl_init();
                                      //set the url, number of POST vars, POST data
                                      curl_setopt($ch,CURLOPT_URL, $url);
                                      curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
                                      curl_setopt($ch, CURLOPT_POST, 1);
                                      curl_setopt($ch,CURLOPT_POSTFIELDS, $addChild_json);
                                      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                                      // curl_setopt($ch1,CURLOPT_URL, $url2);
                                      // curl_setopt($ch1, CURLOPT_POST, 1);
                                      // curl_setopt($ch1,CURLOPT_POSTFIELDS, $graph_json);
                                      // curl_setopt($ch1, CURLOPT_RETURNTRANSFER, true);

                                      //execute post
                                      $result = curl_exec($ch);
                                      //close connection
                                      curl_close($ch);

                                      return $result;
           
    }

      public function tracker_api($key,$user){
                                 $tracker = tracker::where('user_id',$user)
                                                           ->whereNull('deleted_at')
                                                           ->where('data_to_ulife','0')
                                                           ->count();
                                 if($tracker>=1){
                                         $tracker = tracker::where('user_id',$user)
                                                           ->whereNull('deleted_at')
                                                           ->where('data_to_ulife','0')
                                                           ->get();
                      
                                            foreach ( $tracker as $track) {
                                            $cre= $track->created_at;
                                            $up= $track->updated_at;
                                             $created_at = $cre->format('Y-m-d H:m:s');
                                             $updated_at =  $up->format('Y-m-d H:m:s');
                                               
                                                $tracker_api[] = array(
                                                  'id'=>$track->id,
                                                  'user_key'=> $key,
                                                  'breakfast'=>$track->breakfast,
                                                  'lunch'=>$track->lunch,
                                                  'dinner'=>$track->dinner,
                                                  'dessert_lu'=>$track->dessert_lu,
                                                  'dessert_din'=>$track->dessert_din,
                                                  'exercise'=>$track->exercise,
                                                  'vitamin'=>$track->vitamin,
                                                  'created_at'=>$created_at,
                                                  'updated_at'=>$updated_at,
                                                  'deleted_at'=>$track->deleted_at
                                                );         
                                                          
                                           }
                             
                                      $tracker_json = json_encode($tracker_api);  
                                      $url3 ='http://128.199.147.57/api/v1/peat/setTrackers';
                                      $ch3 = curl_init();
                                      //set the url, number of POST vars, POST data
                                      curl_setopt($ch3,CURLOPT_URL, $url3);
                               
                                      curl_setopt($ch3, CURLOPT_POST, 1);
                                      curl_setopt($ch3,CURLOPT_POSTFIELDS, $tracker_json);
                                      curl_setopt($ch3, CURLOPT_RETURNTRANSFER, true);
                                      // curl_setopt($ch1,CURLOPT_URL, $url2);
                                      // curl_setopt($ch1, CURLOPT_POST, 1);
                                      // curl_setopt($ch1,CURLOPT_POSTFIELDS, $graph_json);
                                      // curl_setopt($ch1, CURLOPT_RETURNTRANSFER, true);

                                      //execute post
                                      $result = curl_exec($ch3);
                                      //close connection
                                      curl_close($ch3);
                                      
                                       $tracker = NOW();
                                       $tracker_update = tracker::where('user_id', $user)
                                                                 ->whereNull('deleted_at')
                                                                 ->update([ 'data_to_ulife' =>$tracker]);


                                       return $result;
                                     }
           
    }
    public function setgraph_api($key,$user){
                  
                     $RecordOfPregnancy = RecordOfPregnancy::where('user_id',$user)
                                                            ->whereNull('deleted_at')
                                                            ->where('data_to_ulife','0')
                                                            ->count();
                           

                                   if($RecordOfPregnancy>=1){
                                    
                        
                                     $RecordOfPregnancy = RecordOfPregnancy::where('user_id',$user)
                                                                           ->whereNull('deleted_at')
                                                                           ->where('data_to_ulife','0')
                                                                           ->get();
                                      $weight = [];
                                      $time = [];
                                         foreach ($RecordOfPregnancy as $object) {
                                          array_push($weight, $object->preg_weight);
                                          //$weight[] = $object->preg_weight;   
                                          array_push($time, $object->preg_week);    
                                         //$time []= $object->preg_week;     
                                           $data_graph = array(
                                                'user_key'=> $key,
                                                'OFFSPRING'=>1,
                                                'GRAPH_WEIGHT'=>$weight,
                                                'GRAPH_TIME'=> $time,
                                                'deleted_at'=>NULL
                                          );         
                                        
                                      }
                        
                                      $graph_json = json_encode($data_graph);  
                                 
                                      $url2 ='http://128.199.147.57/api/v1/peat/setGraphWeight';
                                      $ch2 = curl_init();
                                      //set the url, number of POST vars, POST data
                                      curl_setopt($ch2,CURLOPT_URL, $url2);
                                      curl_setopt( $ch2, CURLOPT_POST, true );
                                      curl_setopt($ch2,CURLOPT_POSTFIELDS,  $graph_json);
                                      curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
                                      //execute post
                                      $result = curl_exec($ch2);
                                      //close connection
                                      curl_close($ch2);
                                      $tracker = NOW();
                                      $tracker_update = RecordOfPregnancy::where('user_id', $user)
                                                              ->whereNull('deleted_at')
                                                              ->update([ 'data_to_ulife' =>$tracker]);
                                

                                       return $result;
                                   }

                                        
           
    }
       public function check_ulife_weight_edit($user,$date){
            $users_register =   (new SqlController)->users_register_select($user);
            $key = $users_register->ulife_connect;
            if($key!== 0){
                                  

                                     $RecordOfPregnancy = RecordOfPregnancy::where('user_id',$user)
                                                                           ->whereNull('deleted_at')
                                                                           ->where('preg_week', $date)
                                                                           ->get();
                                      $weight = [];
                                      $time = [];
                                         foreach ($RecordOfPregnancy as $object) {
                                          array_push($weight, $object->preg_weight);
                                          //$weight[] = $object->preg_weight;   
                                          array_push($time, $object->preg_week);    
                                         //$time []= $object->preg_week;     
                                           $data_graph = array(
                                                'user_key'=> $key,
                                                'OFFSPRING'=>1,
                                                'GRAPH_WEIGHT'=>$weight,
                                                'GRAPH_TIME'=> $time
                                          );         
                                        
                                      }
                        
                                      $graph_json = json_encode($data_graph);  
                                      $url2 ='http://128.199.147.57/api/v1/peat/setGraphWeight';
                                      $ch2 = curl_init();
                                      //set the url, number of POST vars, POST data
                                      curl_setopt($ch2,CURLOPT_URL, $url2);
                                      curl_setopt( $ch2, CURLOPT_POST, true );
                                      curl_setopt($ch2,CURLOPT_POSTFIELDS,  $graph_json);
                                      curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
                                      //execute post
                                      $result = curl_exec($ch2);
                                      //close connection
                                      curl_close($ch2);
                                      $tracker = NOW();
                                      $tracker_update = RecordOfPregnancy::where('user_id', $user)
                                                              ->whereNull('deleted_at')
                                                              ->update([ 'data_to_ulife' =>$tracker]);
                                

                                       return $result;
                                   
            }
            
    }
    public function check_ulife_tracker_edit($user,$dt){
              
            $users_register =   (new SqlController)->users_register_select($user);
            $key = $users_register->ulife_connect;
            if($key!== '0'){
           
                                         $tracker = tracker::where('user_id',$user)
                                                           ->whereNull('deleted_at')
                                                           ->where(DB::raw("(DATE_FORMAT(created_at,'%Y-%m-%d'))"), $dt)
                                                           ->get();
                                            $tracker_api = [];
                                            foreach ( $tracker as $track) {
                                            $cre= $track->created_at;
                                            $up= $track->updated_at;
                                             $created_at = $cre->format('Y-m-d H:m:s');
                                             $updated_at =  $up->format('Y-m-d H:m:s');
                                               
                                                $tracker_api[] = array(
                                                  'id'=>$track->id,
                                                  'user_key'=> $key,
                                                  'breakfast'=>$track->breakfast,
                                                  'lunch'=>$track->lunch,
                                                  'dinner'=>$track->dinner,
                                                  'dessert_lu'=>$track->dessert_lu,
                                                  'dessert_din'=>$track->dessert_din,
                                                  'exercise'=>$track->exercise,
                                                  'vitamin'=>$track->vitamin,
                                                  'created_at'=>$created_at,
                                                  'updated_at'=>$updated_at,
                                                  'deleted_at'=>$track->deleted_at
                                                );         
                                                          
                                           }
                             
                                      $tracker_json = json_encode($tracker_api);  
                                      $url3 ='http://128.199.147.57/api/v1/peat/setTrackers';
                                      $ch3 = curl_init();
                                      //set the url, number of POST vars, POST data
                                      curl_setopt($ch3,CURLOPT_URL, $url3);
                               
                                      curl_setopt($ch3, CURLOPT_POST, 1);
                                      curl_setopt($ch3,CURLOPT_POSTFIELDS, $tracker_json);
                                      curl_setopt($ch3, CURLOPT_RETURNTRANSFER, true);
                                      // curl_setopt($ch1,CURLOPT_URL, $url2);
                                      // curl_setopt($ch1, CURLOPT_POST, 1);
                                      // curl_setopt($ch1,CURLOPT_POSTFIELDS, $graph_json);
                                      // curl_setopt($ch1, CURLOPT_RETURNTRANSFER, true);

                                      //execute post
                                      $result = curl_exec($ch3);
                                      //close connection
                                      curl_close($ch3);

                                       $tracker = NOW();
                                       $tracker_update = tracker::where('user_id', $user)
                                                                 ->whereNull('deleted_at')
                                                                 ->update([ 'data_to_ulife' =>$tracker]);


                                       return $result;
                                  
            }
    }
    

     public function api_delete($user){

           $date   = NOW();
            $deleted_at =  $date->format('Y-m-d H:m:s');
            $users_register =   (new SqlController)->users_register_select($user);
            $key = $users_register->ulife_connect;
            if($key!== 0){
                                   
                                  
                                      $RecordOfPregnancy = RecordOfPregnancy::where('user_id',$user)
                                                                           ->whereNull('deleted_at')
                                                                           ->get();
                                      $weight = [];
                                      $time = [];
                                         foreach ($RecordOfPregnancy as $object) {
                                          array_push($weight, $object->preg_weight);
                                          //$weight[] = $object->preg_weight;   
                                          array_push($time, $object->preg_week);    
                                         //$time []= $object->preg_week;     
                                           $data_graph = array(
                                                'user_key'=> $key,
                                                'OFFSPRING'=>1,
                                                'GRAPH_WEIGHT'=>$weight,
                                                'GRAPH_TIME'=> $time,
                                                'deleted_at'=>$deleted_at
                                                
                                          );         
                                        
                                      }
                        
                                      $graph_json = json_encode($data_graph);  
                                      $url2 ='http://128.199.147.57/api/v1/peat/setGraphWeight';
                                      $ch2 = curl_init();
                                      //set the url, number of POST vars, POST data
                                      curl_setopt($ch2,CURLOPT_URL, $url2);
                                      curl_setopt( $ch2, CURLOPT_POST, true );
                                      curl_setopt($ch2,CURLOPT_POSTFIELDS,  $graph_json);
                                      curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
                                      //execute post
                                      $result = curl_exec($ch2);
                                      //close connection
                                      curl_close($ch2);


                                $tracker_count = tracker::where('user_id',$user)
                                                           ->whereNull('deleted_at')
                                                           ->count();
                                   
                                if( $tracker_count >= 1 ){
                               
                                       $tracker = tracker::where('user_id',$user)
                                                           ->whereNull('deleted_at')
                                                           ->get();
                      
                                            foreach ( $tracker as $track) {
                                            $cre= $track->created_at;
                                            $up= $track->updated_at;
                                             $created_at = $cre->format('Y-m-d H:m:s');
                                             $updated_at =  $up->format('Y-m-d H:m:s');
                                               
                                                $tracker_api[] = array(
                                                  'id'=>$track->id,
                                                  'user_key'=> $key,
                                                  'breakfast'=>$track->breakfast,
                                                  'lunch'=>$track->lunch,
                                                  'dinner'=>$track->dinner,
                                                  'dessert_lu'=>$track->dessert_lu,
                                                  'dessert_din'=>$track->dessert_din,
                                                  'exercise'=>$track->exercise,
                                                  'vitamin'=>$track->vitamin,
                                                  'created_at'=>$created_at,
                                                  'updated_at'=>$updated_at,
                                                  'deleted_at'=> $deleted_at,
                                                );         
                                                          
                                           }
                             
                                      $tracker_json = json_encode($tracker_api);  
                                      $url3 ='http://128.199.147.57/api/v1/peat/setTrackers';
                                      $ch3 = curl_init();
                                      //set the url, number of POST vars, POST data
                                      curl_setopt($ch3,CURLOPT_URL, $url3);
                               
                                      curl_setopt($ch3, CURLOPT_POST, 1);
                                      curl_setopt($ch3,CURLOPT_POSTFIELDS, $tracker_json);
                                      curl_setopt($ch3, CURLOPT_RETURNTRANSFER, true);
                                      // curl_setopt($ch1,CURLOPT_URL, $url2);
                                      // curl_setopt($ch1, CURLOPT_POST, 1);
                                      // curl_setopt($ch1,CURLOPT_POSTFIELDS, $graph_json);
                                      // curl_setopt($ch1, CURLOPT_RETURNTRANSFER, true);

                                      //execute post
                                      $result2 = curl_exec($ch3);
                                      //close connection
                                      curl_close($ch3);
                                   // print($result2);

                                    }
            }
              
            
    }
    
}
