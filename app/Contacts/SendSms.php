<?php

namespace App\Contacts;

use App\Models\User;

interface SendSms
{
    /**
     * Estimate sms from remote host
     *
     * @author Panayiotis Halouvas <phalouvas@kainotomo.com>
     *
     * @param  array $sms
     * @param User $user
     * @return void
     */
    public function send(array $sms, User $user);
}
