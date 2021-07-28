<?php

namespace App\Actions;

use App\Contacts\EstimateSms as ContactsEstimateSms;
use App\Models\Settings;
use Exception;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class EstimateSms implements ContactsEstimateSms
{
    /**
     * Estimate sms from remote host
     *
     * @author Panayiotis Halouvas <phalouvas@kainotomo.com>
     *
     * @param  array $sms
     * @return array
     * @throws \Illuminate\Http\Client\RequestException
     */
    public function estimate(array $sms)
    {
        if (Session::has('smsto_token')) {
            $token = Session::get('smsto_token');
        } else {
            $token = Settings::where('name', 'token')->first()->value;
            Session::put('smsto_token', $token);
        }
        $response = Http::withToken($token)
            ->post(config('app.smsto_api_url') . 'sms/estimate', $sms);

        $response->throw();
        if ($response->json(['message'])) {
            throw new RequestException($response->json(['message'], 400));
        }
        $sms = array_merge($sms, $response->json());
        Session::put('sms_estimation', json_encode($sms));
        return $sms;
    }
}
