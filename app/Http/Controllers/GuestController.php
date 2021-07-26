<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Settings;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\File;
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
    public function update(Request $request) {

        Validator::make($request->all(), [
            'name' => ['required', 'string'],
            'email' => ['required', 'string|email'],
            'phone' => ['required', 'string'],
            'message' => ['required', 'string'],
        ])->validateWithBag('updateContactUs');

        return $request->wantsJson()
                    ? new JsonResponse('', 200)
                    : back()->with('status', 'contact-us-updated');
    }
}
