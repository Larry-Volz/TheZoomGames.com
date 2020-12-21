<?php
namespace app\services;

use app\models\Config;

class Meeting
{

    public function queryMeeting()
    {
        //
    }

    public function joinMeeting()
    {
        if (Validation::validate([
            'meetingNumber' => ['require', 'integer'],
            'role' => ['require', ['in', [0, 1]]]
        ])) {
            $arr['apiKey'] = Config::config('ZOOM_API_KEY');
            $arr['signature'] = Foo::generateSignature(
                $arr['apiKey'],
                Config::config('ZOOM_API_SECRET'),
                $_POST['meetingNumber'],
                $_POST['role']
            );
            Foo::json($arr);
        } else {
            $this->fail('from data validation fail!');
        }
    }
}
