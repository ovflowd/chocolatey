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
     * @param int $paymentCategory
     * @param string $countryCode
     * @param int $shopItem
     * @param int $paymentMethod
     * @return RedirectResponse|Response|Redirector|ResponseFactory
     */
    public function proceed(int $paymentCategory, string $countryCode, int $shopItem, int $paymentMethod)
    {
        $paymentCheckout = DB::table('chocolatey_shop_payment_checkout')
            ->where('category', $paymentCategory)->where('country', $countryCode)
            ->where('item', $shopItem)->where('method', $paymentMethod)->first();

        return $paymentCheckout != null ? redirect($paymentCheckout->redirect)
            : response(view('failed-payment'), 400);
    }

    /**
     * Success Payment Checkout
     *
     * @TODO: Code Business Logic
     *
     * @param Request $request
     * @param int $paymentCategory
     * @param string $countryCode
     * @param int $shopItem
     * @param int $paymentMethod
     * @return RedirectResponse|Response|Redirector|ResponseFactory
     */
    public function success(Request $request, int $paymentCategory, string $countryCode, int $shopItem, int $paymentMethod)
    {
        $paymentCheckout = DB::table('chocolatey_shop_payment_checkout')
            ->where('category', $paymentCategory)->where('country', $countryCode)
            ->where('item', $shopItem)->where('method', $paymentMethod)->first();

        $checkOutId = rand(0, 99) + $shopItem * $request->user()->uniqueId + rand(0, 99);

        //@TODO: Do Business Logic Here

        return $paymentCheckout != null ? response(view('success-payment', ['checkoutId' => $checkOutId]), 200)
            : response(view('failed-payment'), 404);
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
        //PATTERN: [{"creationTime":"2017-02-10T14:19:39.000+0000","transactionSystemName":"Paymentez Direct Products Creditcard","credits":28,"price":"BRL 9.99"}]
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
            return response()->json(null, 404);

        DB::table('users')->where('id', $request->user()->uniqueId)->increment('credits', $voucher->credits);
        DB::table('users')->where('id', $request->user()->uniqueId)->increment('pixels', $voucher->points);

        return response()->json('');
    }

    /**
     * Get Offer Wall
     *
     * @TODO: Need to Know how this really works!
     * @TODO: Ability of custom this shit
     *
     * @param Request $request
     * @return mixed
     */
    public function getWall(Request $request): JsonResponse
    {
        return response()->json(['url' => "https://www.offertoro.com/ifr/show/2150/s-hhus-bf01d11c861e8785afe95065caa7f182/1308"]);
    }
}
