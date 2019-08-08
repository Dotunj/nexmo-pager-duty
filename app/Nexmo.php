<?php

namespace App;

use GuzzleHttp\Client;

class Nexmo
{
    protected $client;

    public function __construct()
    {
        $this->client = $this->setUpClient();
    }

    protected function setUpClient()
    {
        $authBearer = 'Bearer ' . config('services.nexmo.jwt');

        return new Client([
            'base_uri' => 'https://api.nexmo.com',
            'headers' => [
                'Authorization' => $authBearer,
                'Content-Type' => 'application/json',
                'Accept' => 'application/json'
            ]
        ]);
    }


    public function dispatch()
    {
        $response  = $this->client->request('POST', '/v0.1/dispatch', [
            'json' => [
                'template' => 'failover',
                'workflow' => [
                 [
                    'from' => [ 'type' => 'messenger','id' => config('services.nexmo.fb_recipient_id')],
                    'to' => ['type' => 'messenger', 'id' => config('services.nexmo.fb_sender_id')],
                    'message' => [
                      'content' => [
                        'type' => 'text',
                        'text' => 'An incident just occurred',
                      ]
                     ],
                    'failover' =>[
                      'expiry_time' => 15,
                      'condition_status' => 'read',
                    ]
                   ],
                  [
                    'from' => ['type' => 'sms','number' => config('services.nexmo.sms_from')],
                    'to' => ['type' => 'sms','number' => config('services.nexmo.sms_to')],
                    'message' => [
                      'content' => [
                        'type' => 'text',
                        'text' => 'An incident just occurred',
                      ]
                    ]
                  ]
                ]
            ]
        ]);

        return json_decode($response->getBody());
    }
}
