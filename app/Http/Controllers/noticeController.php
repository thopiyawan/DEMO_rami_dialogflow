<?php

namespace App\Http\Controllers;

use DateTime;
use Spatie\Browsershot\Browsershot;
use Image; 

use Illuminate\Http\Request;
use View;
use DB;

use App\Models\pregnants as pregnants;
use App\Models\RecordOfPregnancy as RecordOfPregnancy;
use App\Models\sequents as sequents;
use App\Models\sequentsteps as sequentsteps;
use App\Models\users_register as users_register;
use App\Models\tracker as tracker;
use App\Models\question as question;
use App\Models\quizstep as quizstep;
use App\Models\reward as reward;

use Carbon\Carbon;




use Storage;


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


class noticeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {       

       $user = 'U2dc636d2cd052e82c29f5284e00f69b9';
       $url = "https://peat.none.codes/graph/".$user; 
          // $tracker = tracker::where('user_id',$user)
          //                                                  ->where('deleted_status','1')
          //                                                  ->where('data_to_ulife','0')
          //                                                  ->get();

          //   print($tracker);
        // $week = Carbon::now()->subDays(7);
        // echo $week;
       // $input= '22-03-2018';

     
       //  echo $tracker;              
                   // foreach ( $tracker as $track) {
                   //         $cre = $track->created_at;
                   //         $created_at =  $cre->format('Y-m-d');

                   //       if($created_at == $input){
                   //        echo 'คุณต้องการแก้ไขวันนี้ใช่หรือไม่';
                   //        // $tracker_update = tracker::where('user_id', $user)
                   //        //                   ->where('created_at', $cre)
                   //        //                   ->update([ $column =>$tracker]);

                   //       }else{
                   //          echo 'ไม่มีวันที่นี้ที่สามารถแก้ไขได้';
                   //       }                      
                                 
                                               
                   //  }
                       

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function graph($id)
    {

        $record = DB::table('RecordOfPregnancy')
                     ->select('preg_week','preg_weight')
                     ->where('user_id', $id)
                     ->whereNull('deleted_at')
                     ->distinct()
                     ->orderBy('preg_week', 'asc')
                     ->get();
        $record1 = DB::table('users_register')
                     ->select('user_Pre_weight')
                     ->where('user_id', $id)
                     ->whereNull('deleted_at')
                     ->get();
        $user = DB::table('users_register')
                     // ->select('user_Pre_weight')
                     ->where('user_id', $id)
                     ->whereNull('deleted_at')
                     ->first();
        $preg_week= DB::table('RecordOfPregnancy')
                     ->select('preg_week')
                     ->where('user_id', $id)
                     ->whereNull('deleted_at')
                     ->orderBy('preg_week', 'asc')
                     ->get();
        $preg_weight = DB::table('RecordOfPregnancy')
                     ->select('preg_weight')
                     ->where('user_id', $id)
                     ->whereNull('deleted_at')
                     ->orderBy('preg_week', 'asc')
                     ->get();
        $preg_week = $preg_week->pluck('preg_week');
        $preg_weight = $preg_weight ->pluck('preg_weight');

        $user_height = $user->user_height;
        $user_weight = $user->user_Pre_weight;
        $height = $user_height*0.01;
        $bmi = $user_weight/($height*$height);
        $bmi = number_format($bmi, 2, '.', '');


        return View::make('graph1')->with('record',$record)->with('record1',$record1)->with('bmi',$bmi)->with('preg_week', $preg_week)->with('preg_weight', $preg_weight);
    }
    // public function bmi_calculator($user_weight,$user_height){
    //             $height = $user_height*0.01;
    //             $bmi = $user_weight/($height*$height);
    //             $bmi = number_format($bmi, 2, '.', '');
    //         return $bmi;
    // }
    public function notice_monday()
    {
        $httpClient = new CurlHTTPClient('qFLN6cTuyvSWdbB1FHgUBEsD9hM66QaW3+cKz/LsNkwzMrBNZrBkH9b1zuCGp9ks0IpGRLuT6W1wLOJSWQFAlnHT/KbDBpdpyDU4VTUdY6qs5o1RTuCDsL3jTxLZnW1qbgmLytIpgi1X1vqKKsYywAdB04t89/1O/w1cDnyilFU=');
            $bot = new LINEBot($httpClient, array('channelSecret' => '949b099c23a7c9ca8aebe11ad9b43a52'));

       $status = 2;
       $user_select = $this->user_select($status);

       $arrlength = count($user_select);
       for($x = 0; $x < $arrlength ; ++$x) {
          $user_id = $user_select[$x];
          // $user_id = 'U2dc636d2cd052e82c29f5284e00f69b9';

          // $RecordOfPregnancy = $this->RecordOfPregnancy($user_id);
          // $preg_week = $RecordOfPregnancy->preg_week;
          // $preg_week = $preg_week+1;
          $user_re = $this->users_register_select($user_id);
          $preg_week = $user_re->preg_week;
          $preg_week = $preg_week+1;

             if($preg_week>41){
                    $users_register = users_register::where('user_id', $user_id)
                                                   ->update(['status'=>'0']);


             }else{
          $pregnants = $this->pregnants($preg_week);
          $descript = $pregnants->descript;
          
          // $picFullSize = 'https://peat.none.codes/week/'.$preg_week.'.jpg';
          // $picThumbnail = 'https://peat.none.codes/week/'.$preg_week.'.jpg';
          
          $Message1 =  'สัปดาห์นี้คุณมีอายุครรภ์'.$preg_week.'สัปดาห์แล้วนะคะ';
          // $Message3 =  $descript;
          $Message4 = 'สัปดาห์นี้คุณแม่มีน้ำหนักเท่าไรแล้วคะ?';

          $textMessage1 = new TextMessageBuilder($Message1);
          // $textMessage2 = new ImageMessageBuilder($picFullSize,$picThumbnail);
          // $textMessage3 = new TextMessageBuilder($Message3);
          $textMessage4 = new TextMessageBuilder($Message4);
          
          $multiMessage = new MultiMessageBuilder;
          $multiMessage->add($textMessage1);
          // $multiMessage->add($textMessage2);
          // $multiMessage->add($textMessage3);
          $multiMessage->add($textMessage4);
          $textMessageBuilder = $multiMessage; 
       
          $seqcode     = 1003;
          $nextseqcode = 0000;
          $sequentsteps_insert =  $this->sequentsteps_update($user_id,$seqcode,$nextseqcode);

          $user_weight  = 'NULL';
          $RecordOfPregnancy = $this->RecordOfPregnancy_insert($preg_week, $user_weight,$user_id);

          $response = $bot->pushMessage( $user_id ,$textMessageBuilder);
          $response->getHTTPStatus() . ' ' . $response->getRawBody();
             }

        
             $up= $this->user_update($preg_week,$user_id);

       }
      
    }
      public function users_register_select($user_id){
        $users_register = users_register::where('user_id',$user_id)
                                        ->whereNull('deleted_at')
                                        ->first();
        return $users_register;

    }
        public function tracker_insert1($user_id,$tracker)
    {          
          $tracker = tracker::insert(['user_id'=>$user_id,'breakfast' => $tracker,'lunch' => 'NULL','dinner' => 'NULL','dessert_lu' => 'NULL' ,'dessert_din' => 'NULL' ,'exercise' => 'NULL','vitamin'=>'NULL','created_at'=>NOW(),'updated_at' =>NOW(),'data_to_ulife'=>'0']);
    }
     public function user_select($status)
    {
       $user_select = users_register::select('user_id')
                      ->whereIn('preg_week', ['1','2','3','4','5','6','7','8','9','10','11','12','13','14','15','16','17','18','19','20','21','22','23','24','25','26','27','28','29','30','31','32','33','34','35','36','37','38','39','40'])
                       ->whereNull('deleted_at')
                       ->whereIn('status', [1, $status])
                       //->where('user_id', 'U2dc636d2cd052e82c29f5284e00f69b9')
                       //->where('user_id', 'Udb5efc89a4729c093051ce8813454223')
                       //->where('user_id', 'Uaafbb71ac91f028b6db1e6151d9db31b')
                       //->where('user_id', 'Ub849bb4dd4d399b4c5d6f89976fbe157')
                       ->distinct()
                       ->pluck('user_id')
                       ->all();
          
       //print_r($user_select);
       return  $user_select;
    }
    public function RecordOfPregnancy($user_id){

        $RecordOfPregnancy = RecordOfPregnancy::where('user_id',$user_id)
                                         ->whereBetween('preg_week', ['1','41'])
                                         ->orderBy('updated_at', 'desc')
                                         ->first();
        return $RecordOfPregnancy;

    }
      public function user_update($preg_week,$user_id)
    {
       $user_select = users_register::where('user_id', $user_id)
                      ->update(['preg_week' =>$preg_week]);
          
       //print_r($user_select);
       return  $user_select;
    }

    public function RecordOfPregnancy_asc($user_id){

        $RecordOfPregnancy = RecordOfPregnancy::where('user_id',$user_id)
                                         ->orderBy('updated_at', 'asc')
                                         ->first();
        return $RecordOfPregnancy;

    }
    


    public function  pregnants($preg_week){
         $pregnants = pregnants::where('week', $preg_week)->first();
        return $pregnants;

    }
    public function sequentsteps_update($user_id,$seqcode,$nextseqcode)
    {          
         $sequentsteps = sequentsteps::where('sender_id', $user_id)
                       ->update(['seqcode' =>$seqcode,'nextseqcode' => $nextseqcode]);
    }
    public function RecordOfPregnancy_insert($preg_week, $user_weight,$user_id){
     $RecordOfPregnancy = RecordOfPregnancy::insert(['user_id'=>$user_id,'preg_week' => $preg_week,'preg_weight' => $user_weight,  'created_at'=>NOW(),'updated_at' =>NOW(),'data_to_ulife'=>'0']);
    }

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


 public function notice_day()
    {
        $httpClient = new CurlHTTPClient('qFLN6cTuyvSWdbB1FHgUBEsD9hM66QaW3+cKz/LsNkwzMrBNZrBkH9b1zuCGp9ks0IpGRLuT6W1wLOJSWQFAlnHT/KbDBpdpyDU4VTUdY6qs5o1RTuCDsL3jTxLZnW1qbgmLytIpgi1X1vqKKsYywAdB04t89/1O/w1cDnyilFU=');
            $bot = new LINEBot($httpClient, array('channelSecret' => '949b099c23a7c9ca8aebe11ad9b43a52'));

       $status = 3;
       $user_select = $this->user_select($status);

       $arrlength = count($user_select);
       for($x = 0; $x < $arrlength ; ++$x) {
          $user_id = $user_select[$x];
          $Message1 =  'วันนี้คุณทานอะไรไปบ้างคะ';
          $textMessageBuilder = new TextMessageBuilder($Message1);
          
          $seqcode     = 2001;
          $nextseqcode = 2002;
          $sequentsteps_insert =  $this->sequentsteps_update($user_id,$seqcode,$nextseqcode);

          $response = $bot->pushMessage( $user_id ,$textMessageBuilder);
          $response->getHTTPStatus() . ' ' . $response->getRawBody();


       }

    }
 public function notice_breakfast()
    {
          $httpClient = new CurlHTTPClient('qFLN6cTuyvSWdbB1FHgUBEsD9hM66QaW3+cKz/LsNkwzMrBNZrBkH9b1zuCGp9ks0IpGRLuT6W1wLOJSWQFAlnHT/KbDBpdpyDU4VTUdY6qs5o1RTuCDsL3jTxLZnW1qbgmLytIpgi1X1vqKKsYywAdB04t89/1O/w1cDnyilFU=');
            $bot = new LINEBot($httpClient, array('channelSecret' => '949b099c23a7c9ca8aebe11ad9b43a52'));

       $status = 3;
       $user_select = $this->user_select($status);

       $arrlength = count($user_select);
       for($x = 0; $x < $arrlength ; ++$x) {
          $user_id = $user_select[$x];

          $a = array("สวัสดีตอนเเช้าค่ะคุณแม่😊 ตอนเช้าคุณแม่ทานอะไรไปบ้างคะ?","มอนิ่งนะคะ😁 คุณแม่ทานอะไรหรือยังคะ ทานอะไรไปบ้างเอ่ย?","สวัสดีค่ะ☀ เช้านี้คุณแม่ทานอะไรบ้างคะ?","สวัสดีตอนเช้าค่ะคุณแม่😊 ทานข้าวเช้าหรือยังค่ะ ทานอะไรไปบ้างคะ?");
          $random_keys= array_rand($a,2) ;
          $Message1 =  $a[$random_keys[0]];
          $textMessageBuilder = new TextMessageBuilder($Message1);
          
          $seqcode     = 2005;
          $nextseqcode = 2006;
          $sequentsteps_insert =  $this->sequentsteps_update($user_id,$seqcode,$nextseqcode);

          $response = $bot->pushMessage( $user_id ,$textMessageBuilder);
          $response->getHTTPStatus() . ' ' . $response->getRawBody();
          $tracker= 'NULL';
          $tracker_insert =  $this->tracker_insert1($user_id,$tracker);

       }

          // $reward_se =  (new SqlController)->reward_select1($user);

          //             if($reward_se == null){
          //               $point = 0;
          //               $feq_ans_meals = 0;
          //               $feq_ans_week =0;
          //               $reward_ins =  (new SqlController)->ins_reward1($user,$point,$feq_ans_week,$feq_ans_meals);

          //             }else{
          //               $point = $reward_se->point;
          //               $feq_ans_week = $reward_se->feq_ans_week;
          //               $feq_ans_meals = 0 ;
          //               $select_qs =  (new SqlController)->update_reward1($user,$point,$feq_ans_week,$feq_ans_meals);
          //             }    
      
    }
public function notice_lunch()
    {
          $httpClient = new CurlHTTPClient('qFLN6cTuyvSWdbB1FHgUBEsD9hM66QaW3+cKz/LsNkwzMrBNZrBkH9b1zuCGp9ks0IpGRLuT6W1wLOJSWQFAlnHT/KbDBpdpyDU4VTUdY6qs5o1RTuCDsL3jTxLZnW1qbgmLytIpgi1X1vqKKsYywAdB04t89/1O/w1cDnyilFU=');
            $bot = new LINEBot($httpClient, array('channelSecret' => '949b099c23a7c9ca8aebe11ad9b43a52'));

       $status = 3;
       $user_select = $this->user_select($status);
      


       $arrlength = count($user_select);
       for($x = 0; $x < $arrlength ; ++$x) {
          $user_id = $user_select[$x];

          $a = array("😊มื้อเที่ยงนี้ทานข้าวหรือยังคะ ทานอะไรบ้างคะ? ","มื้อเที่ยงแล้ว😁 คุณแม่ทานอะไรหรือยังคะ ทานอะไรไปบ้างเอ่ย?","☀มื้อเที่ยงคุณแม่ทานอะไรบ้างคะ?","สวัสดีตอนเที่ยงค่ะคุณแม่😊 ทานข้าวหรือยังค่ะ ทานอะไรไปบ้างคะ?");
          
          
          $random_keys= array_rand($a,2) ;
          $Message1 =  $a[$random_keys[0]];
          $textMessageBuilder = new TextMessageBuilder($Message1);
          
          $seqcode     = 2006;
          $nextseqcode = 2007;
          $sequentsteps_insert =  $this->sequentsteps_update($user_id,$seqcode,$nextseqcode);

          $response = $bot->pushMessage( $user_id ,$textMessageBuilder);
          $response->getHTTPStatus() . ' ' . $response->getRawBody();


       }
      
    }
public function notice_dinner()
    {
         $httpClient = new CurlHTTPClient('qFLN6cTuyvSWdbB1FHgUBEsD9hM66QaW3+cKz/LsNkwzMrBNZrBkH9b1zuCGp9ks0IpGRLuT6W1wLOJSWQFAlnHT/KbDBpdpyDU4VTUdY6qs5o1RTuCDsL3jTxLZnW1qbgmLytIpgi1X1vqKKsYywAdB04t89/1O/w1cDnyilFU=');
            $bot = new LINEBot($httpClient, array('channelSecret' => '949b099c23a7c9ca8aebe11ad9b43a52'));

       $status = 3;
       $user_select = $this->user_select($status);

       $arrlength = count($user_select);
       for($x = 0; $x < $arrlength ; ++$x) {
          $user_id = $user_select[$x];
            $a = array("มื้อเย็นแล้ว ทานข้าวหรือยังคะ ทานอะไรบ้างคะ?😊","มื้อเย็นแล้ว😁 คุณแม่ทานอะไรหรือยังคะ ทานอะไรไปบ้างเอ่ย?","มื้อเย็นคุณแม่ทานอะไรบ้างคะ?","สวัสดีตอนเย็นค่ะคุณแม่😊 ทานข้าวหรือยังค่ะ ทานอะไรไปบ้างคะ?");
          
          $random_keys= array_rand($a,2) ;
          $Message1 =  $a[$random_keys[0]];

          $textMessageBuilder = new TextMessageBuilder($Message1);
          
          $seqcode     = 2001;
          $nextseqcode = 2002;
          $sequentsteps_insert =  $this->sequentsteps_update($user_id,$seqcode,$nextseqcode);

          $response = $bot->pushMessage( $user_id ,$textMessageBuilder);
          $response->getHTTPStatus() . ' ' . $response->getRawBody();


       }
      
    }


}
