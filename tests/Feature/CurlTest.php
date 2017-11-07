<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Asobiba\Domain\Models\Reservation\Curl;

class CurlTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testLogin()
    {
        $this->assertTrue(true);
    }

    public function testGetContent()
    {
        $url = 'http://asobiba101.com/';
        $cookie = dirname(__FILE__) . '/cookie_curl.txt';
        $curl = new Curl();
        $rs = $curl->get_content($url,$cookie);
        echo $rs;
//        $this->assertTrue(true);
    }
}
