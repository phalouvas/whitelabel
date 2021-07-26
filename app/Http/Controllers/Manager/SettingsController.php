<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Settings;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
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
                'api_key' => $settings->where('name', 'ApiKey')->first()->value,
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
            'logo' => ['nullable', 'mimes:jpg,jpeg,png', 'max:1024'],
        ])->validateWithBag('updateProfileInformation');

        if ($request->logo) {
            $name = $request->file('logo')->getClientOriginalName();
            $path = $request->file('logo')->storeAs('public/images', 'logo.png');
            File::move(storage_path('app/public/images/logo.png'), public_path('images/logo.png'));
        }

        Settings::where('name', 'ApiKey')->update(['value' => $request->api_key]);
        Settings::where('name', 'Welcome')->update(['value' => $request->welcome]);

        return $request->wantsJson()
                    ? new JsonResponse('', 200)
                    : back()->with('status', 'site-settings-updated');
    }
}
