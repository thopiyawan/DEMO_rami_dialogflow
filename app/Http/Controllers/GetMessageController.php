<?php

namespace App\Http\Controllers;

require __DIR__.'/vendor/autoload.php';
use Illuminate\Http\Request;


use Google\Cloud\Dialogflow\V2\SessionsClient;
use Google\Cloud\Dialogflow\V2\TextInput;
use Google\Cloud\Dialogflow\V2\QueryInput;

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



class GetMessageController extends Controller
{


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
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
            $replyToken = $events['events'][0]['replyToken'];
            $userMessage = $events['events'][0]['message']['text'];
            
        }
        //ส่วนของคำสั่งจัดเตียมรูปแบบข้อความสำหรับส่ง
        // $textMessageBuilder = new TextMessageBuilder(json_encode($events));

        if($userMessage == 'สนใจ'){
            $a = 'ชื่ออะไร';
            $textMessageBuilder = new TextMessageBuilder($a);

        }else{
             $a =  $this->detect_intent_texts('remiai-29f47',json_encode($userMessage, JSON_UNESCAPED_UNICODE ),'123456');
                 $textMessageBuilder = new TextMessageBuilder($a);

        }

   
   
    $response = $bot->replyMessage($replyToken,$textMessageBuilder);

            }

            /**
             * Show the form for creating a new resource.
             *
             * @return \Illuminate\Http\Response
             */
  









public function detect_intent_texts($projectId, $text, $sessionId , $languageCode = 'th')
{
    // new session
    $test = array('credentials' => 'client-secret.json');
    $sessionsClient = new SessionsClient($test);
    $session = $sessionsClient->sessionName($projectId, $sessionId ?: uniqid());
    // printf('Session path: %s' . PHP_EOL, $session);
 
    // create text input
    $textInput = new TextInput();
    $textInput->setText($text);
    $textInput->setLanguageCode($languageCode);
 
    // create query input
    $queryInput = new QueryInput();
    $queryInput->setText($textInput);
 
    // get response and relevant info
    $response = $sessionsClient->detectIntent($session, $queryInput);
    $queryResult = $response->getQueryResult();
    $queryText = $queryResult->getQueryText();
    $intent = $queryResult->getIntent();
    $displayName = $intent->getDisplayName();
    $confidence = $queryResult->getIntentDetectionConfidence();
    $fulfilmentText = $queryResult->getFulfillmentText();

    // output relevant info
    // print(str_repeat("=", 20) . PHP_EOL);
    // printf('Query text: %s' . PHP_EOL, $queryText);
    // printf('Detected intent: %s (confidence: %f)' . PHP_EOL, $displayName,
    //     $confidence);
    // print(PHP_EOL);
    // printf('Fulfilment text: %s' . PHP_EOL, $fulfilmentText);
    
    $sessionsClient->close();
     return $fulfilmentText;
   
}
}
