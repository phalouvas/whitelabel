<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UsersController extends Controller
{
    /**
     * Get users
     *
     * @author Panayiotis Halouvas <phalouvas@kainotomo.com>
     *
     * @param Request $request
     * @see \Inertia\ResponseFactory
     */
    public function index(Request $request)
    {
        $query = User::where('id', '>', 1);

        if ($request->onlyTrashed == 'true') {
            $query->onlyTrashed();
        }

        $users = $query->orderBy('id', 'desc')->paginate();

        return Inertia::render('Manager/Users', [
            'users' => $users,
        ]);
    }

    public function destroy(User $user)
    {
        $user->delete();
        return response('ok');
    }
}
