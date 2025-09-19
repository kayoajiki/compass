<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Cashier\WebhookController;

class StripeWebhookController extends Controller
{
    /**
     * Handle Stripe webhook
     */
    public function handle(Request $request)
    {
        // CashierのWebhookControllerを使用
        $cashierController = new WebhookController();
        return $cashierController->handleWebhook($request);
    }
}
