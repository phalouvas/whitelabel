<?php

namespace App\Contacts;

interface SendSms
{
    /**
     * Estimate sms from remote host
     *
     * @author Panayiotis Halouvas <phalouvas@kainotomo.com>
     *
     * @param  array $sms
     * @return void
     */
    public function send(array $sms);
}
