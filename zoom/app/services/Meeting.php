<?php
namespace app\services;

use app\models\Config;

class Meeting
{
    const ZOOM_USERS_MEETINGS = '/users/{userId}/meetings';
    const ZOOM_MEETING_TYPE = ['scheduled', 'live', 'upcoming'];

    static public function queryMeeting(): array
    {
dump(self::class.'::queryMeeting()');
hr();
        $zoom = ZoomApi::zoom(\Uncgits\ZoomApi\Clients\Users::class);
        dump(current($zoom->listUsers()->content()));
        return [];
        $user = ZoomUser::user();
        if (empty($user))
            return [];
        $url = Foo::getUrl(self::ZOOM_USERS_MEETINGS, $user['id']);
        $data['type'] = 'scheduled';
        foreach (self::ZOOM_MEETING_TYPE as $key => $value) {
            $data['type'] = $value;
            $basic[] = json_decode(Foo::httpsCurl($url, $data, Header::headerBasic()), true);
            $bearer[] = json_decode(Foo::httpsCurl($url, $data, Header::headerBearer()), true);
            # code...
        }
        dump($user);
        dump($basic);
        dump($bearer);
        return [];
        //
    }

    static public function createMeetings()
    {
dump(self::class.'::createMeetings()');
hr();
        $user = ZoomUser::user();
        if (empty($user))
            return [];
dump($user);
exit;
        $url = Foo::getUrl(self::ZOOM_USERS_MEETINGS, $user['id']);
dump($url);
        $data['topic'] = $user['first_name'].'\'s meeting';
        $data['type'] = 3;
        $data['start_time'] = date('Y-m-d H:i:s');
        $data['duration'] = 24*60*60;
        // $data = Foo::build_post_fields(self::foo());
        $curl = Foo::httpsCurl($url, $data, Header::headerBearer());
        $res = json_decode($curl, true);
        dump($data);
        dump($res);
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

    static public function foo()
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
