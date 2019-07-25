<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    //
    public function show(User $user)
    {
        $threads = $user->threads()->paginate(15);

        return view('users.show',[
            'profileUser' => $user,
            'threads' => $threads
        ]);
    }
}
