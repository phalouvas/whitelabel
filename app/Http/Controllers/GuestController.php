<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Notifications\ContactUsNotification;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Validator;

class GuestController extends Controller
{
    /**
     * Validate and update the given data.
     *
     * @author Panayiotis Halouvas <phalouvas@kainotomo.com>
     *
     * @param  array  $input
     * @return \Illuminate\Http\Response|\Illuminate\Contracts\Routing\ResponseFactory
     */
    public function contactUs(Request $request) {

        $data = Validator::make($request->all(), [
            'name' => ['required', 'string'],
            'email' => ['required', 'email'],
            'phone' => ['required', 'string'],
            'message' => ['required', 'string'],
        ])->validateWithBag('updateContactUs');

        Notification::send(User::find(1), new ContactUsNotification($data));

        return $request->wantsJson()
                    ? new JsonResponse('', 200)
                    : back()->with('status', 'contact-us-updated');
    }
}
