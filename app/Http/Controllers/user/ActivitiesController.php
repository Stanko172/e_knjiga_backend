<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ActivitiesController extends Controller
{
    public function index(){
        $user = Auth::user();

        return Activity::where('user_id', '=', $user->id)->get();
    }
}
