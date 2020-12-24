<?php
namespace app\services;

use app\models\Config;
use app\models\Meeting as MeetingModel;
use app\models\User as UserModel;
use \Uncgits\ZoomApi\Clients\Meetings;

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
        if (!$foo['meeting_id'])
            return self::$savedMeeting;
        $zoom = Zoom::api(Meetings::class);
        $foo = $zoom->getMeeting($foo['meeting_id']);
        if (!Zoom::status($foo))
            return self::$savedMeeting;
        self::$savedMeeting = $foo->content();
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
        $zoom = Zoom::api(Meetings::class);
        $res = $zoom->listMeetings($user->id);
        if (!Zoom::status($res))
            return [];
        $res = $res->content();
        if (!$res)
            return $res;
        $res = current($res);
        return $zoom->getMeeting($res->id)->content();
    }

    private static function configMeeting(): array
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
        $zoom = Zoom::api(Meetings::class);
        $zoom->setParameters(self::configMeeting());
        $request = $zoom->createMeeting(User::user()->id);
        if (!Zoom::status($request))
            return false;
        return MeetingModel::saveMeeting($request->content());
    }

    public static function joinMeeting()
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
