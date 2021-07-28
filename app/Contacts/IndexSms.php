<?php

namespace App\Contacts;

interface IndexSms
{
    /**
     * Estimate sms from remote host
     *
     * @author Panayiotis Halouvas <phalouvas@kainotomo.com>
     *
     * @param  array $sms
     * @return void
     */
    public function index(array $sms);
}
