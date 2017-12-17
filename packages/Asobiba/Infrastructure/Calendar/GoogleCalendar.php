<?php

namespace Asobiba\Infrastructure\Calendar;

use Asobiba\Domain\Models\Calendar\CalendarInterface;
use Google_Client;
use Google_Service_Calendar;

class GoogleCalendar implements CalendarInterface
{

    private $client;
    private $service;
    private $calendarId;

    public function __construct()
    {
        $key_path = storage_path('json/google_api_secret_key.json');//指定ファイルへのフルパス
        putenv('GOOGLE_APPLICATION_CREDENTIALS='. $key_path);//カレントリクエスト実行時のみの環境変数を設定
        $this->client = new Google_Client();
        $this->client->useApplicationDefaultCredentials();
        $this->client->addScope(Google_Service_Calendar::CALENDAR);//https://www.googleapis.com/auth/calendar
        $this->service = new \Google_Service_Calendar($this->client);
        $this->calendarId = env('GOOGLE_CALENDAR_ID');
    }


    public function isEvent(string $date,int $start,int $end): bool
    {
        // TODO: Implement isEvent() method.
        return false;
    }

    public function createEvent(string $date,int $start,int $end): bool
    {
        try {
            $event = new \Google_Service_Calendar_Event([
                'summary' => '仮押さえ',
                'location' => '東京都墨田区押上１丁目１−２',
                'description' => '東京スカイツリー・バンジージャンプイベント！',
                'start' => [
                    'dateTime' => '2017-05-16T09:00:00-07:00',
                    'timeZone' => 'Asia/Tokyo',
                ],
                'end' => [
                    'dateTime' => '2017-05-16T17:00:00-07:00',
                    'timeZone' => 'Asia/Tokyo',
                ]
            ]);
            $new_event = $this->service->events->insert($this->calendarId, $event);

            //空き状況の永続化？

            return true;
        }catch(\Exception $e){
            return false;
        }
    }
}