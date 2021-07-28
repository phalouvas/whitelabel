<?php

namespace App\Http\Controllers;

use App\Actions\EstimateSms;
use App\Actions\IndexSms;
use App\Actions\SendSms;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class SmsController extends Controller
{
    /**
     * Get sms logs
     *
     * @author Panayiotis Halouvas <phalouvas@kainotomo.com>
     *
     * @param Request $request
     * @see \Inertia\ResponseFactory
     */
    public function index(Request $request)
    {
        $filter = $request->only(['status', 'to', 'created_at', 'page']);

        $indexSms = new IndexSms();
        $messages = $indexSms->index($filter);

        //Fix links
        $pathArray = $request->only(['status', 'to', 'created_at']);
        $queryString = '';
        foreach ($pathArray as $key => $value) {
            $queryString .= '&' . $key . '=' . $value;
        }
        $links = $messages['links'];
        $links[0]['label'] = '&laquo; Previous';
        $links[count($links) - 1]['label'] = 'Next &raquo;';
        foreach ($links as $key => $link) {

        }
        $messages['links'] = $links;
        foreach ($messages['links'] as $key => $link) {
            $messages['links'][$key]['url'] = config('app.url') . 'reports' . substr($link['url'], strpos($link['url'], '?page=')) . $queryString;
        }
        $messages['first_page_url'] = config('app.url') . 'reports' . substr($messages['first_page_url'], strpos($messages['first_page_url'], '?page=')) . $queryString;
        $messages['last_page_url'] = config('app.url') . 'reports' . substr($messages['last_page_url'], strpos($messages['last_page_url'], '?page=')) . $queryString;
        $messages['next_page_url'] = config('app.url') . 'reports' . substr($messages['next_page_url'], strpos($messages['next_page_url'], '?page=')) . $queryString;
        $messages['prev_page_url'] = config('app.url') . 'reports' . substr($messages['prev_page_url'], strpos($messages['prev_page_url'], '?page=')) . $queryString;

        return Inertia::render('Sms/Index', [
            'messages' => $messages,
            'filter' => $filter
        ]);
    }

    /**
     * Get sms message
     *
     * @author Panayiotis Halouvas <phalouvas@kainotomo.com>
     *
     * @param Request $request
     * @see \Inertia\ResponseFactory
     */
    public function edit()
    {
        $sms_estimation_str = Session::get('sms_estimation', null) ?? json_encode([
            'cost' => 0,
            'to' => null,
            'message' => null,
            'sender_id' => null,
            'sms_count' => 0,
            'estimated_cost' => 0,
            'contact_count' => 0,
            'invalid_count' => 0,
        ]);
        $sms_estimation = json_decode($sms_estimation_str, true);
        $sms_estimation['cost'] = $sms_estimation['to'] * 1;
        return Inertia::render('Sms/Edit', [
            'sms_estimation' => $sms_estimation
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
    public function estimate(Request $request) {

        Session::remove('sms_estimation');
        $validatedData = Validator::make($request->all(), [
            'cost' => ['required', 'numeric'],
            'to' => ['required', 'string'],
            'message' => ['required', 'string'],
            'sender_id' => ['required', 'string'],
        ])->validateWithBag('estimateSms');

        $estimateSms = new EstimateSms();
        try {
            $estimateSms->estimate($validatedData);
        } catch (\Throwable $th) {
            Validator::make([], [
                'smsto_error' => ['required'],
            ], [
                'required' => $th->getMessage(),
            ])->validateWithBag('estimateSms');
        }

        return $request->wantsJson()
                    ? new JsonResponse('', 200)
                    : back()->with('status', 'sms-estimate');
    }

    /**
     * Validate and update the given data.
     *
     * @author Panayiotis Halouvas <phalouvas@kainotomo.com>
     *
     * @param  array  $input
     * @return \Illuminate\Http\Response|\Illuminate\Contracts\Routing\ResponseFactory
     */
    public function send(Request $request) {

        $validatedData = Validator::make($request->all(), [
            'cost' => ['required', 'numeric'],
            'to' => ['required', 'string'],
            'message' => ['required', 'string'],
            'sender_id' => ['required', 'string'],
        ])->validateWithBag('sendSms');

        $sendSms = new SendSms();
        try {
            $sendSms->send($validatedData);
        } catch (\Throwable $th) {
            Validator::make([], [
                'smsto_error' => ['required'],
            ], [
                'required' => $th->getMessage(),
            ])->validateWithBag('sendSms');
        }

        return $request->wantsJson()
                    ? new JsonResponse('', 200)
                    : back()->with('status', 'sms-sent');
    }

}
