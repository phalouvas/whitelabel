<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class CountriesController extends Controller
{
    /**
     * Get items
     *
     * @author Panayiotis Halouvas <phalouvas@kainotomo.com>
     *
     * @param Request $request
     * @see \Inertia\ResponseFactory
     */
    public function index(Request $request)
    {
        $query = Country::select('*');

        if ($request->onlyTrashed == 'true') {
            $query->onlyTrashed();
        }

        if ($request->name) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        $countries = $query->orderBy('name', 'asc')->paginate();

        return Inertia::render('Manager/Countries', [
            'countries' => $countries,
        ]);
    }

    /**
     * Destroy an item
     *
     * @author Panayiotis Halouvas <phalouvas@kainotomo.com>
     *
     * @param Country $country
     * @return \Illuminate\Http\Response|\Illuminate\Contracts\Routing\ResponseFactory
     */
    public function destroy(Country $country)
    {
        $country->delete();
        return response('ok');
    }

    /**
     * Restore an item
     *
     * @author Panayiotis Halouvas <phalouvas@kainotomo.com>
     *
     * @param int $country_id
     * @return \Illuminate\Http\Response|\Illuminate\Contracts\Routing\ResponseFactory
     */
    public function restore(int $country_id)
    {
        Country::onlyTrashed()->find($country_id)->restore();
        return response('ok');
    }

    /**
     * Update item
     *
     * @author Panayiotis Halouvas <phalouvas@kainotomo.com>
     *
     * @param Country $country
     * @return \Illuminate\Http\Response|\Illuminate\Contracts\Routing\ResponseFactory
     */
    public function update(Country $country, Request $request)
    {
        Validator::make($request->all(), [
            'price' => ['required', 'numeric'],
        ])->validateWithBag('updateCountry');

        $country->update(['price' => $request->price]);

        return $request->wantsJson()
                    ? new JsonResponse('', 200)
                    : back()->with('status', 'country-updated');
    }
}
