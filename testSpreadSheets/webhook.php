<?php

/**
 * Copyright 2016 LINE Corporation
 *
 * LINE Corporation licenses this file to you under the Apache License,
 * version 2.0 (the "License"); you may not use this file except in compliance
 * with the License. You may obtain a copy of the License at:
 *
 *   https://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS, WITHOUT
 * WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied. See the
 * License for the specific language governing permissions and limitations
 * under the License.
 */

require_once('./LINEBotTiny.php');

$channelAccessToken = 'hYvsYlGU203xGfDuxrnrr6YnFm5M1Z84JDp45BBt+Q1NIVJ8RnTQWJZSeIMJTL1sIXjkqlqUG1Q8eDqdBK5JyELOd4q4vd2glzNpD+sRyHCe19q0BJbVk0FIVxZoeYSvrDhxs6idiZjeksOecgsw7QdB04t89/1O/w1cDnyilFU=';
$channelSecret = 'ad4d60d04b94d7e017aa2082fe05ecea';
//https://app.rakuten.co.jp/services/api/Recipe/CategoryList/20170426?[parameter]=[value]
$client = new LINEBotTiny($channelAccessToken, $channelSecret);
foreach ($client->parseEvents() as $event) {
    switch ($event['type']) {
        case 'message':
            $message = $event['message'];
            switch ($message['type']) {
                case 'text':
                    $client->replyMessage([
                        'replyToken' => $event['replyToken'],
                        'messages' => [
                            [
                                'type' => 'text',
                                'text' => $message['text']
                            ]
                        ]
                    ]);
                    break;
                default:
                    error_log('Unsupported message type: ' . $message['type']);
                    break;
            }
            break;
        default:
            error_log('Unsupported event type: ' . $event['type']);
            break;
    }
};
