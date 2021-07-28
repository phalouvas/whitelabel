<?php

namespace App\Contacts;

interface EstimateSms
{
    /**
     * Estimate sms from remote host
     *
     * @author Panayiotis Halouvas <phalouvas@kainotomo.com>
     *
     * @param  array $sms
     * @return void
     */
    public function estimate(array $sms);
}
