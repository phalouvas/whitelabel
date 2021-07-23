<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Settings;
use Illuminate\Http\Request;
use Inertia\Inertia;

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
}
