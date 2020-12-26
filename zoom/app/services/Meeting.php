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
        MeetingModel::saveMeeting((array)$res);
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
                // 'use_pmi' => true
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
        MeetingModel::saveMeeting((array)$request->content());
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
        $config['role'] = 1;
        $config['apiKey'] = Config::config('ZOOM_API_KEY');

        if (!$_POST['name'])
        {
            $meeting = self::getMeeting();
            if (!$user = User::user())
                return [];
            $config['meetingNumber'] = $meeting['id'];
            $config['password'] = $meeting['password'];
            $config['userName'] = $user->first_name;
        } else {
            $config['meetingNumber'] = $_POST['meetingId'];
            $config['userName'] = $_POST['name'];
            $config['password'] = MeetingModel::getPassword($_POST['meetingId']);
            $config['role'] = 0;
        }
        $config['signature'] = Foo::generateSignature(
            $config['apiKey'],
            Config::config('ZOOM_API_SECRET'),
            $config['meetingNumber'],
            $config['role']
        );
        return $config;
    }

    public static function startZoom()
    {
        if (1)
            return self::startMeetingConfig();
        else
            return self::joinMeeting();
    }

    private static function joinMeeting()
    {

    }
}
