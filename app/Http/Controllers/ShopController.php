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

    /**
     * Get User Purchase History
     *
     * @TODO: User Purchase History will be coded on the Future
     * @TODO: All Purchases of the CMS are Manually, so will be difficult track.
     * @TODO: Probably Administrators will Manually Insert History Through HK
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getHistory(Request $request): JsonResponse
    {
        return response()->json([]);
    }

    /**
     * Redeem Voucher
     *
     * @TODO: Need to Test if really works
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function redeem(Request $request): JsonResponse
    {
        $voucher = DB::table('vouchers')->where('code', $request->json()->get('voucherCode'))->first();

        if ($voucher == null)
            return response()->json('', 404);

        DB::table('users')->where('id', $request->user()->uniqueId)->increment('credits', $voucher->credits);
        DB::table('users')->where('id', $request->user()->uniqueId)->increment('pixels', $voucher->points);

        return response()->json();
    }
}
