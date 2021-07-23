<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Settings;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Validator;

class SettingsController extends Controller
{
    /**
     * Get users
     *
     * @author Panayiotis Halouvas <phalouvas@kainotomo.com>
     *
     * @param Request $request
     * @see \Inertia\ResponseFactory
     */
    public function edit()
    {
        $settings = Settings::select('name', 'value')->get();
        return Inertia::render('Manager/Settings', [
            'settings' => [
                'welcome' => $settings->where('name', 'Welcome')->first()->value
            ],
        ]);
    }

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
            'welcome' => ['required', 'string'],
        ])->validateWithBag('updateProfileInformation');

        Settings::where('name', 'Welcome')->update(['value' => $request->welcome]);
        return response('ok');
    }
}
