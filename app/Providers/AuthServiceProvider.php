<?php

namespace App\Providers;

use App\Models\EBook;
use App\Models\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('ebook-purchased', function (User $user, EBook $ebook) {
            $check = DB::table('orders')
            ->join('order_ebooks', 'order_ebooks.order_id', '=', 'orders.id')
            ->where([['user_id', '=', $user->id], ['e_book_id', '=', $ebook->id]])
            ->get();

            return count($check) <= 0 ? false : true;
        });
    }
}
