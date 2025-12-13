<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use App\Services\LogMonitorService;

class LoginController extends Controller
{
    protected $logMonitor;

    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected function redirectTo()
    {
        $user = Auth::user();
        $this->logMonitor->logLogin($user);

        switch ($user->role->nama_role) {
            case 'Admin':
                return '/adminx/dashboard';
            case 'Karyawan':
                return '/karyawan/dashboard';
            case 'Kasir':
                return '/kasir/dashboard';
        }
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->logMonitor = app(LogMonitorService::class);
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }
}
