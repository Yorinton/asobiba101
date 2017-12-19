<?php

namespace Asobiba\Infrastructure\Calendar;

use Asobiba\Domain\Models\Calendar\CalendarInterface;
use Google_Client;
use Google_Service_Calendar;
use Google_Service_Calendar_FreeBusyRequest;
use Google_Service_Calendar_FreeBusyRequestItem;

class GoogleCalendar implements CalendarInterface
{

    private $client;
    private $service;
    private $calendarId;
    private $freebusyReq;
    private $freebusyReqItem;

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


    public function isBusy(string $startDateTime,string $endDateTime): bool
    {
        $this->freebusyReq = new Google_Service_Calendar_FreeBusyRequest(
            [
                'timeMin' => $startDateTime,
                'timeMax' => $endDateTime,
                'timeZone' => 'Asia/Tokyo',
                'items' => [
                    ['id' => $this->calendarId]
                ]
            ]
        );

        $result = $this->service->freebusy->query($this->freebusyReq);
        if($result->getCalendars()[$this->calendarId]->getBusy() === []){
            return false;
        }
        return true;
    }

    public function createEvent(string $startDateTime,string $endDateTime,string $summary = '',string $location = '',string $desc = '')
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
            $eventId = $new_event->getId();

            return $eventId;
        }catch(\Exception $e){
            return false;
        }
    }
}