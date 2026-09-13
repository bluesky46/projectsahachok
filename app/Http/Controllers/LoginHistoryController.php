<?php
namespace App\Http\Controllers;

use App\Models\LoginHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginHistoryController extends Controller
{
    public function store(Request $request)
{
    $credentials = $request->only('email', 'password');

    if (Auth::attempt($credentials)) {
        $user = Auth::user();
        LoginHistory::create([
            'user_id' => $user->id,
            'login_at' => now(),
        ]);

        return redirect()->intended('/login-history'); // หรือหน้าไหนก็ได้
    }

    return redirect()->back()->withErrors(['email' => 'Invalid credentials']);
}



    public function logout(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            return redirect('/');
        }

        // อัปเดตเวลา logout
        $loginHistory = LoginHistory::where('user_id', $user->id)
            ->whereNull('logout_at')
            ->latest()
            ->first();

        if ($loginHistory) {
            $loginHistory->update(['logout_at' => now()]);
        }

        Auth::logout();
        return redirect('/');
    }

    public function showLoginHistory()
    {
        $loginHistories = LoginHistory::with('user') // โหลดข้อมูล user ที่เกี่ยวข้อง
            ->orderBy('login_at', 'desc')
            ->get();
        return view('logHis', compact('loginHistories'));
    }
}
