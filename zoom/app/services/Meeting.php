<?php
namespace app\services;

use app\models\Config;
use app\models\Meeting as MeetingModel;
use app\models\User as UserModel;
use \Uncgits\ZoomApi\Clients\Meetings as MeetingClient;

class Meeting
{
    const ZOOM_USERS_MEETINGS = '/users/{userId}/meetings';
    const ZOOM_MEETING_TYPE = ['scheduled', 'live', 'upcoming'];
    private static $savedMeeting = null;

    private static function checkSavedMeeting()
    {
        if (self::$savedMeeting)
            return self::$savedMeeting;
        $foo = MeetingModel::getMeeting();
        if (empty($foo['meeting_id']))
            return self::$savedMeeting;
        $zoom = Zoom::api(MeetingClient::class);
        $foo = $zoom->getMeeting($foo['meeting_id']);
        if (!Zoom::status($foo))
            return self::$savedMeeting;
        self::$savedMeeting = (array)$foo->content();
        return self::$savedMeeting;
    }

    // query first meeting from meeting list.
    public static function queryMeeting()
    {
        if (self::checkSavedMeeting())
            return self::checkSavedMeeting();
        $user = User::user();
        if (!$user)
            return [];
        $zoom = Zoom::api(MeetingClient::class);
        $res = $zoom->listMeetings($user->id);
        if (!Zoom::status($res))
            return [];
        $res = $res->content();
        if (!$res)
            return $res;
        $res = current($res);
        $res = $zoom->getMeeting($res->id)->content();
        MeetingModel::saveMeeting($res);
        return (array)$res;
    }

    private static function createMeetingConfig(): array
    {
        $user = User::user();
        if (!User::user())
            return [];
        return [
            'topic' => User::user()->first_name . '\'s meeting',
            'type' => 3,
            'start_time' => date('Y-m-d H:i:s'),
            'duration' => 24 * 60 * 60,
            'settings' => [
                'host_video' => true,
                'participant_video' => true,
                'join_before_host' => true,
                'use_pmi' => true
            ]
        ];
    }

    public static function createMeetings()
    {
        if (self::checkSavedMeeting())
            return self::checkSavedMeeting();
        if (!UserModel::getUserId())
            return false;
        if (!User::user())
            return false;
        $zoom = Zoom::api(MeetingClient::class);
        $zoom->setParameters(self::createMeetingConfig());
        $request = $zoom->createMeeting(User::user()->id);
        if (!Zoom::status($request))
            return false;
        MeetingModel::saveMeeting($request->content());
        return (array)$request->content();
    }



    // get functional meeting.
    private static function getMeeting()
    {
        if ($meeting = self::queryMeeting())
            return $meeting;
        if ($meeting = self::createMeetings())
            return $meeting;
        return [];
    }

    private static function startMeetingConfig(): array
    {
        $meeting = self::getMeeting();
        $user = User::user();
        if (!User::user())
            return [];
        $config['meetingId'] = $meeting['id'];
        $config['password'] = $meeting['password'];
        $config['name'] = User::user()->first_name;
        $config['apikey'] = Config::config('ZOOM_API_KEY');
        $config['role'] = 1;
        if (0)
            $config['role'] = 0;
        $config['lang'] = $_POST['lang'];
        $config['china'] = 0;
        // if ($config['lang'] === 'zh-cn')
        //     $config['china'] = 1;
        $config['signature'] = Foo::generateSignature(
            $config['apikey'],
            Config::config('ZOOM_API_SECRET'),
            $config['meetingId'],
            $config['role']
        );
        return $config;
    }

    public static function startZoom()
    {
        return self::startMeetingConfig();
    }

    // public static function checkWaiting()
    // {

    // }

    public static function foo()
    {
        return [
          "topic"=> "string",
          "type"=> 1,
          "start_time"=> date('Y-m-d H:i:s'),
          "duration"=> 24*60*60,
          "schedule_for"=> "string",
          "timezone"=> "string",
          "password"=> "string",
          "agenda"=> "string",
          "recurrence"=> [
            "type"=> 1,
            "repeat_interval"=> 1,
            "weekly_days"=> "string",
            "monthly_day"=> 1,
            "monthly_week"=> 1,
            "monthly_week_day"=> 1,
            "end_times"=> 1,
            "end_date_time"=> date('Y-m-d H:i:s',time()+24*60*60)
          ],
          "settings"=> [
            "host_video"=> true,
            "participant_video"=> true,
            "cn_meeting"=> false,
            "in_meeting"=> false,
            "join_before_host"=> false,
            "mute_upon_entry"=> false,
            "watermark"=> false,
            "use_pmi"=> false,
            "approval_type"=> 1,
            "registration_type"=> 1,
            "audio"=> "string",
            "auto_recording"=> "string",
            "enforce_login"=> false,
            "enforce_login_domains"=> "string",
            "alternative_hosts"=> "string",
            "global_dial_in_countries"=> [
              "string"
            ],
            "registrants_email_notification"=> false
          ]
        ];
    }
}
