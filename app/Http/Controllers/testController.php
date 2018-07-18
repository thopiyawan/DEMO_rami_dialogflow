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
use App\Models\presenting_gift as presenting_gift;
use App\Models\reward_gift as reward_gift;
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


class testController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {       
     $user ='U2dc636d2cd052e82c29f5284e00f69b9';
     // $re = [];
     $record = tracker::select('user_id')
                         ->where('user_id',$id)
                               // ->whereNull('deleted_at')
                               ->orderBy('created_at', 'DESC')
                               ->get()->toArray();
    echo var_dump($record);
                                //   foreach( $record as $item1){
                              

                                //   $re= $item1->user_id;

                                //    echo$re ;
                             
                                                          
                                // }

      // $record->toArray
     // print($re);

     // $record1 = $record->breakfast  ;

    // $str = "ปลา";
    // // echo $str;
    // $d = explode(" ",$str);
    // $u = [];
    // $da= [];

    //   $json1 = file_get_contents('calfood.json');
    //   $json= json_decode($json1);
    //             foreach($json->data as $item)
    //               {
                    
    //                 foreach($d as $item1)
    //                   if(strpos( $item1, $item->id ) !== false )
    //                   {

    //                     $da[]= $item->content;
    //                     $u[] = $item->cal;
    //                     // $sum =  array_sum($u);
                                                
    //                   }   
    // }

    // if($u==null){
    //   echo '555';
    // }
    //   print_r($u);  
    //   // print_r($sum);   
     
    //      for ($i = 0, $c = count($da); $i < $c; $i++) {
    //                       // $da1 = $da[$i];
    //                        echo $da[$i],",";
                        // }
    //               // }
       //  $data = presenting_gift::where('presenting_gift.presenting_status',1)
       //           ->where('presenting_gift.user_id',$user)
       //           ->join('reward_gift', 'reward_gift.code_gift', '=', 'presenting_gift.code_gift')
       //           ->select('reward_gift.name_gift','presenting_gift.code_gift', DB::raw('count(*) as total'))
       //           ->groupBy('presenting_gift.code_gift')
       //           // ->orderBy('presenting_gift.id','asc')
       //           ->get();
       // print_r($data);

///////////////////////////////////////////////////////////////////////////

 // $id ='U2dc636d2cd052e82c29f5284e00f69b9';
//      $record = reward_gift::get();
//      //print $record;






// $user_update = (new SqlController)->reward_gift(); 
// print $user_update;
          //  $actionBuilder=[];
          // $user_update = (new SqlController)->reward_gift();  
          // print($user_update);
          // foreach($user_update as $value){
          //       // echo($value->name_gift);
             

          //   $actionBuilder[] = array(
          //                           new CarouselColumnTemplateBuilder(
          //                               $value->name_gift,
          //                               $value->point,
          //                               'https://peat.none.codes/image/diary4.jpg',
          //                               array(
          //                                   new MessageTemplateActionBuilder(
          //                                       'แลก',// ข้อความแสดงในปุ่ม
          //                                        $value->code_gift // ข้อความที่จะแสดงฝั่งผู้ใช้ เมื่อคลิกเลือก
          //                                   ),
          //                                  )
          //                           ),                                  
          //                       );

          //    $textMessageBuilder = new TemplateMessageBuilder('Carousel',
          //                   new CarouselTemplateBuilder(
          //                       $actionBuilder
          //                   )
          //               );

          //   }
 
        

//////////////////////////////////////////////////////////////////
}



}
