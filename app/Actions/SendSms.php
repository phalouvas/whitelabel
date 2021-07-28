<?php

namespace App\Actions;

use App\Contacts\SendSms as ContactsSendSms;
use App\Models\Settings;
use Exception;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class SendSms implements ContactsSendSms
{
    /**
     * Send sms from remote host
     *
     * @author Panayiotis Halouvas <phalouvas@kainotomo.com>
     *
     * @param  array $sms
     * @return array
     * @throws \Illuminate\Http\Client\RequestException
     */
    public function send(array $sms)
    {
        if (Session::has('smsto_token')) {
            $token = Session::get('smsto_token');
        } else {
            $token = Settings::where('name', 'token')->first()->value;
            Session::put('smsto_token', $token);
        }
        $response = Http::withToken($token)
            ->post(config('app.smsto_api_url') . 'sms/send', $sms);

        $response->throw();
        $sms = array_merge($sms, $response->json());
        Session::put('sms_estimation', json_encode($sms));
        return $sms;
    }
}
