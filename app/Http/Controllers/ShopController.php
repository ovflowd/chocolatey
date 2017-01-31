<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\Purse;
use App\Models\ShopInventory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Laravel\Lumen\Http\Redirector;
use Laravel\Lumen\Http\ResponseFactory;
use Laravel\Lumen\Routing\Controller as BaseController;

/**
 * Class ShopController
 * @package App\Http\Controllers
 */
class ShopController extends BaseController
{
    /**
     * List all Shop Countries
     *
     * @return JsonResponse
     */
    public function listCountries(): JsonResponse
    {
        return response()->json(Country::all());
    }

    /**
     * Get the Shop Inventory of a Country
     *
     * @param string $countryCode
     * @return JsonResponse
     */
    public function getInventory(string $countryCode): JsonResponse
    {
        return response()->json(new ShopInventory(Country::where('countryCode', $countryCode)->first()),
            200, array(), JSON_UNESCAPED_SLASHES);
    }

    /**
     * Get User Purse
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getPurse(Request $request): JsonResponse
    {
        return response()->json(new Purse($request->user()->uniqueId));
    }

    /**
     * Proceed Payment Checkout
     *
     * @param string $paymentCategory
     * @param string $countryCode
     * @param int $shopItem
     * @param string $paymentMethod
     * @return RedirectResponse|Response|Redirector|ResponseFactory
     */
    public function proceed(string $paymentCategory, string $countryCode, int $shopItem, string $paymentMethod)
    {
        $paymentCheckout = DB::table('chocolatey_shop_payment_checkout')
            ->where('category', $paymentCategory)->where('country', $countryCode)
            ->where('item', $shopItem)->where('method', $paymentMethod)->first();

        return $paymentCheckout != null ? redirect($paymentCheckout->redirect)
            : response(view('failed-payment'), 400);
    }
}
