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
                'token' => $settings->where('name', 'token')->first()->value,
                'welcome' => $settings->where('name', 'welcome')->first()->value,
                'email' => $settings->where('name', 'email')->first()->value,
                'phone' => $settings->where('name', 'phone')->first()->value,
                'address' => $settings->where('name', 'address')->first()->value,
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
            'token' => ['required', 'string'],
            'welcome' => ['required', 'string'],
            'email' => ['required', 'email'],
            'phone' => ['required', 'string'],
            'address' => ['required', 'string'],
            'logo' => ['nullable', 'mimes:jpg,jpeg,png', 'max:1024'],
        ])->validateWithBag('updateProfileInformation');

        if ($request->logo) {
            $name = $request->file('logo')->getClientOriginalName();
            $path = $request->file('logo')->storeAs('public/images', 'logo.png');
            File::move(storage_path('app/public/images/logo.png'), public_path('images/logo.png'));
        }

        Settings::where('name', 'token')->update(['value' => $request->token]);
        Settings::where('name', 'welcome')->update(['value' => $request->welcome]);
        Settings::where('name', 'email')->update(['value' => $request->email]);
        Settings::where('name', 'phone')->update(['value' => $request->phone]);
        Settings::where('name', 'address')->update(['value' => $request->address]);

        return $request->wantsJson()
                    ? new JsonResponse('', 200)
                    : back()->with('status', 'site-settings-updated');
    }
}
