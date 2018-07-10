<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;




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


use Google\Cloud\Dialogflow\V2\SessionsClient;
use Google\Cloud\Dialogflow\V2\TextInput;
use Google\Cloud\Dialogflow\V2\QueryInput;



class GetMessageController extends Controller
{

      require __DIR__.'/vendor/autoload.php';
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

            //   $a = 'ชื่ออะไร';
            // $textMessageBuilder = new TextMessageBuilder($a);
            $text =  json_encode($userMessage, JSON_UNESCAPED_UNICODE );
            $projectId = 'remiai-29f47';
            $sessionId = '123456';
            $languageCode = 'th';
            $a =  $this->detect_intent_texts($projectId, $text, $sessionId,$languageCode);
            $textMessageBuilder = new TextMessageBuilder($a);

        }

   
   
    $response = $bot->replyMessage($replyToken,$textMessageBuilder);

            }










function detect_intent_texts($projectId, $text, $sessionId , $languageCode)
{
    // new session
    $test = array(
  "type"=> "service_account",
  "project_id"=> "remiai-29f47",
  "private_key_id"=> "5c4b712d73397da16ec4dbb71a60663a07fec5fe",
  "private_key"=> "-----BEGIN PRIVATE KEY-----\nMIIEvgIBADANBgkqhkiG9w0BAQEFAASCBKgwggSkAgEAAoIBAQDYyxrHA4qyHjrf\nFyvnfGNX3sXRz5YCXKk7o6EFjKIGWktoTc/sl289ICNuCjai7xGe2U3ykUZkIJyr\nCUsS3S3+C/a8eCIJNhFtt/QPtw7egsMKXPhRRs4od8nLFBLzgmz3CU7o9D5cC4nP\nPG8Rxcje/kT/FqlfxnNAnuH7j+tn1uurVIBGZ5JbHJrxUDuhxQPUg9+S4Vc2nb36\n+EpFl9qdO+p8uoAkkn/rqspJNnkVD4eqkcJmpwT1BBNIjpi4oZ9o6C687A0y330d\niqb9cJeVsgpqzPsQN/oBz62psq/1Rq9Oma7c04jqBpRNkCs1EvwKVUvfKK3RyhMI\nKyT0k+jdAgMBAAECggEAQhRmbRLfS7t7JlThxQVdIoN8uJ8VklK8IrmVcyOSn20W\nXwyYu/zMo00Qf5INZUyJimmiILW3Rv3Jwzhp8a4JPs5Wvsu/VB9u4IqZkdCyb5Bb\n8uSzq9JxNFSO5Z+QxziSDhqAOvF3sIaz0r8Q+9HVkGLglQBLUC4lIyVKrGsJzfRc\nmPEn3/iipSiCUm2EMbIPICg/iT5Z/aFkSfk9YokP7MDtOmeNGyMHA4g4IC8m6tmt\nYDVVEgO0itx8VgXaRld9ruR/3ljb5Dk2GY9xZzlC62/BgEiH/qsz3AAxJDfrcvZt\nrvIz3LyD9EBXIyhkoA1EQMqW3x7sgLn92ZjLJ8g44QKBgQD8uA8kSGb7XvLDjob0\nOVnldo/clPPB3BRqjzZYDF7xEChX10tgwx06jGCkPRYMfaxPD/wpdktMbXeZwK+K\nArr/3120O1MfiRrURRB+sPTWGrrzcH6Oy+JivS4c4ZzewpvV4xyURG8MICo1yR5a\nSHmGBi90y3PcaZm1GuZ2Oa1QSwKBgQDbm6R9gLZunoT9sR2sTPbzEuoSJW0u4dLP\nbj/0iH4VdXw5NBW6kOyuyMuw2767M2uFx46pJVpN0kZb+NLaePrExhqkTJVp9V1j\nm2eqUKcYdlE/KpGSam6S+OrNuexm8nbCYsaTsEaKuMl2J8URTY/fBlDNNn1ovEbw\nsZ4Fj0kCdwKBgQCoGKW5tI8LVLSVbxBFEoDBKIO4bTtWD1VlK60yE8hzABRVmVcC\nHcYrU4RUum0YEd+zFybbTVv4kjejhY89dWN9Hs3tPCimKUQ3PVkjbADvCQihNIp5\n4RPMKZmqjEcTxM5zDoXL+VkD78Ej1Yri8qIii6q1PT7rtTIQTLxOlz640QKBgER4\n6PbAtSEUh/7ZxJi+fpkXoqf5x2tAugw3IfXKwRVLxmnHlabQHRv6O5hvS67uv228\n5PxUSy3MjGeM06GO6xGDezcTMdsRyAaQo+f0scTszzRUv4LZcJSezAdNGyqWGvVM\n+wF9iuEh8J7Ik6dreZpeS79QaBXJ7oyJtO2i2W7NAoGBAK1/19KiArsO3sM5hzs+\n9VKJzSFliBgtSCxRjKetJu9/L9u+ilD+7n91u7MoDx6QIiBksv1zI+IeikggMvFG\nV1x8SYOfjPb07O9sru91JJqQ7AlIFAkILGKg6qxKnnaaBei1BfUj8VljLx2UyGKr\nkDy3PoffZ74yVvTzATKiiu7J\n-----END PRIVATE KEY-----\n",
  "client_email"=> "remiai@remiai-29f47.iam.gserviceaccount.com",
  "client_id"=> "110021667307859172958",
  "auth_uri"=> "https://accounts.google.com/o/oauth2/auth",
  "token_uri=> "https://accounts.google.com/o/oauth2/token",
  "auth_provider_x509_cert_url"=> "https://www.googleapis.com/oauth2/v1/certs",
  "client_x509_cert_url"=> "https://www.googleapis.com/robot/v1/metadata/x509/remiai%40remiai-29f47.iam.gserviceaccount.com");


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
