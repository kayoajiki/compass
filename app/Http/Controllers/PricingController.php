<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PricingController extends Controller
{
    /**
     * 価格ページを表示
     */
    public function index()
    {
        $user = Auth::user();
        $hasActiveSubscription = $user ? $user->hasActiveSubscription() : false;
        
        return view('pricing', compact('hasActiveSubscription'));
    }
}
