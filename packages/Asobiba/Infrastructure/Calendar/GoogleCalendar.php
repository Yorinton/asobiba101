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

    public function createEvent(string $startDateTime,string $endDateTime,string $summary = '',string $location = '',string $desc = ''): bool
    {
        try {
            $event = new \Google_Service_Calendar_Event([
                'summary' => $summary,
                'location' => $location,
                'description' => $desc,
                'start' => [
                    'dateTime' => $startDateTime,
                    'timeZone' => 'Asia/Tokyo',
                ],
                'end' => [
                    'dateTime' => $endDateTime,
                    'timeZone' => 'Asia/Tokyo',
                ]
            ]);
            $new_event = $this->service->events->insert($this->calendarId, $event);

            return true;
        }catch(\Exception $e){
            return false;
        }
    }
}