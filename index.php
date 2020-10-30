<?php


$API_URL = 'https://api.line.me/v2/bot/message';
$ACCESS_TOKEN = '9zXbwHL9WNTUhc9IYBPrqDw52murzuBM5m2HpCLXbVsHIw+93PA9mqUCVmerURvwEQOm+teTX6jffAEgO7JBXfDoi4eQ54wp+Ci7Ix+Wo2a/YxwAcwWeV/tepDzcYbM6XM6vDw1pj6191z00GDC+SQdB04t89/1O/w1cDnyilFU='; 
$channelSecret = 'b4bb95098c786b41bd3dd6f6889b5c0b';


$POST_HEADER = array('Content-Type: application/json', 'Authorization: Bearer ' . $ACCESS_TOKEN);

$request = file_get_contents('php://input');   // Get request content
$request_array = json_decode($request, true);   // Decode JSON to Array



if ( sizeof($request_array['events']) > 0 ) {

    foreach ($request_array['events'] as $event) {

        $reply_message = '';
        $reply_token = $event['replyToken'];

        $text = $event['message']['text'];
        $a = '';
        if($text =='กินข้าวกับอะไร'){
            $a = 'กินกับไก่ทอด';
        }
        else{
            $a = 'ถามฉันสิ';
        }
        $data = [
            'replyToken' => $reply_token,
            // 'messages' => [['type' => 'text', 'text' => json_encode($request_array) ]]  Debug Detail message
            'messages' => [['type' => 'text', 'text' => $text ]]
        ];
        $post_body = json_encode($data, JSON_UNESCAPED_UNICODE);

        $send_result = send_reply_message($API_URL.'/reply', $POST_HEADER, $post_body);

        echo "Result: ".$send_result."\r\n";
    }
}

echo "OK";




function send_reply_message($url, $post_header, $post_body)
{
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $post_header);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_body);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    $result = curl_exec($ch);
    curl_close($ch);

    return $result;
}

?>
