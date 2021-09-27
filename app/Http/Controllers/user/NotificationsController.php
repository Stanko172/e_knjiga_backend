<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationsController extends Controller
{
    public function index(Request $request){
        switch($request->filter){
            case 'sve':
                return Auth::user()->notifications;
                break;
            
            case 'nepročitano':
                return Auth::user()->unreadNotifications;
                break;
            
            case 'pročitano':
                $notifications = Auth::user()->notifications->where('read_at', '!=', null)->flatten();
                return $notifications;
                break;
        }
    }
}
