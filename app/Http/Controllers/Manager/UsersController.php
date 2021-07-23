<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
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

        if ($request->name) {
            $query->where('name', $request->name);
        }

        if ($request->email) {
            $query->where('email', $request->email);
        }

        $users = $query->orderBy('id', 'desc')->paginate();

        return Inertia::render('Manager/Users', [
            'users' => $users,
        ]);
    }

    /**
     * Destroy a user
     *
     * @author Panayiotis Halouvas <phalouvas@kainotomo.com>
     *
     * @param User $user
     * @return \Illuminate\Http\Response|\Illuminate\Contracts\Routing\ResponseFactory
     */
    public function destroy(User $user)
    {
        $user->delete();
        return response('ok');
    }

    /**
     * Restore a user
     *
     * @author Panayiotis Halouvas <phalouvas@kainotomo.com>
     *
     * @param int $user_id
     * @return \Illuminate\Http\Response|\Illuminate\Contracts\Routing\ResponseFactory
     */
    public function restore(int $user_id)
    {
        User::onlyTrashed()->find($user_id)->restore();
        return response('ok');
    }
}
