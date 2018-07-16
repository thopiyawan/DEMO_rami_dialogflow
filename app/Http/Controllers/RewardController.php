<?php

namespace App\Http\Controllers;

use App\Models\pregnants as pregnants;
use App\Models\RecordOfPregnancy as RecordOfPregnancy;
use App\Models\sequents as sequents;
use App\Models\sequentsteps as sequentsteps;
use App\Models\users_register as users_register;
use App\Models\tracker as tracker;

use App\Http\Controllers\checkmessageController;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\SqlController;
use App\Http\Controllers\CalController;
use App\Http\Controllers\ReplyMessageController;

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
class RewardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response

    /**
     * @var GetMessageService
     */
    public function getmessage()
    {         
    
           $httpClient = new CurlHTTPClient('qFLN6cTuyvSWdbB1FHgUBEsD9hM66QaW3+cKz/LsNkwzMrBNZrBkH9b1zuCGp9ks0IpGRLuT6W1wLOJSWQFAlnHT/KbDBpdpyDU4VTUdY6qs5o1RTuCDsL3jTxLZnW1qbgmLytIpgi1X1vqKKsYywAdB04t89/1O/w1cDnyilFU=');
            $bot = new LINEBot($httpClient, array('channelSecret' => '949b099c23a7c9ca8aebe11ad9b43a52'));
            // คำสั่งรอรับการส่งค่ามาของ LINE Messaging API
            $content = file_get_contents('php://input');
            // แปลงข้อความรูปแบบ JSON  ให้อยู่ในโครงสร้างตัวแปร array
            $events = json_decode($content, true);
            if(!is_null($events)){
            // ถ้ามีค่า สร้างตัวแปรเก็บ replyToken ไว้ใช้งาน
            $replyToken  = $events['events'][0]['replyToken'];
            $user = $events['events'][0]['source']['userId'];
            // $userMessage = $events['events'][0]['message']['text'];
            $type_message = $events['events'][0]['message']['type'];
            }
          
            // $case = 1;
            //  $userMessage =  $content;
            //  return $this->replymessage($replyToken,$userMessage,$case);
            // $key = 'uP8NenSIfB0KiTinYfVy9SUnT';
            // $this->setgraph_api($key,$user);
            // $delete = $this->delete_data_all($user);
            $sequentsteps =  (new SqlController)->sequentsteps_seqcode($user);
            if($type_message =='text'){
                if(!is_null($events)){
            // ถ้ามีค่า สร้างตัวแปรเก็บ replyToken ไว้ใช้งาน
            $replyToken  = $events['events'][0]['replyToken'];
            $user = $events['events'][0]['source']['userId'];
            $userMessage = $events['events'][0]['message']['text'];
            $type_message = $events['events'][0]['message']['type'];
            }
                return $this->checkmessage($replyToken,$userMessage,$user,$bot );
            }elseif($type_message =='sticker' && $sequentsteps->seqcode == '0000'){
               $case = 29 ;
               $userMessage= '0';
                return (new ReplyMessageController)->replymessage($replyToken,$userMessage,$case);
            }
   
    }
      public function checkmessage($replyToken,$userMessage,$user,$bot)
    {          
         
             $httpClient = new CurlHTTPClient('qFLN6cTuyvSWdbB1FHgUBEsD9hM66QaW3+cKz/LsNkwzMrBNZrBkH9b1zuCGp9ks0IpGRLuT6W1wLOJSWQFAlnHT/KbDBpdpyDU4VTUdY6qs5o1RTuCDsL3jTxLZnW1qbgmLytIpgi1X1vqKKsYywAdB04t89/1O/w1cDnyilFU=');
            $bot = new LINEBot($httpClient, array('channelSecret' => '949b099c23a7c9ca8aebe11ad9b43a52'));

       
           $sequentsteps =  (new SqlController)->sequentsteps_seqcode($user);
           //$sequentsteps->seqcode
        
            if ($userMessage =='สนใจ') {
                      $textMessage1 = new TextMessageBuilder($userMessage1);
                      $textMessage2 = new TextMessageBuilder($userMessage2);

                      $multiMessage = new MultiMessageBuilder;
                      $multiMessage->add($textMessage1);
                      $multiMessage->add($textMessage2);
                      $textMessageBuilder = $multiMessage; 
     
          
             
                $response = $bot->replyMessage($replyToken,$textMessageBuilder); 
                  
            }


        

          
         
}



