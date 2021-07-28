<?php

namespace App\Actions;

use App\Contacts\IndexSms as ContactsIndexSms;
use App\Models\Settings;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class IndexSms implements ContactsIndexSms
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
    public function index(array $sms)
    {
        if (Session::has('smsto_token')) {
            $token = Session::get('smsto_token');
        } else {
            $token = Settings::where('name', 'token')->first()->value;
            Session::put('smsto_token', $token);
        }
        $response = Http::withToken($token)
            ->get(config('app.smsto_api_url') . 'messages', $sms);

        $response->throw();
        return $response->json();
    }
}
