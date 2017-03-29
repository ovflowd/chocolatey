<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\Purse;
use App\Models\ShopHistory;
use App\Models\ShopInventory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Config;
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
     * @param int $countryCode
     * @param int $shopItem
     * @param int $paymentMethod
     * @return RedirectResponse|Response|Redirector|ResponseFactory
     */
    public function proceed(string $paymentCategory, int $countryCode, int $shopItem, int $paymentMethod)
    {
        $paymentCheckout = DB::table('chocolatey_shop_payment_checkout')
            ->where('category', $paymentCategory)->where('country', $countryCode)
            ->where('item', $shopItem)->where('method', $paymentMethod)->first();

        return $paymentCheckout != null ? response(view('habbo-web-payments.proceed', ['payment' => $paymentCheckout]))
            : response(view('habbo-web-payments.failed-payment'), 400);
    }

    /**
     * Success Payment Checkout
     *
     * @TODO: Code Business Logic
     *
     * @param Request $request
     * @param string $paymentCategory
     * @param int $countryCode
     * @param int $shopItem
     * @param int $paymentMethod
     * @return RedirectResponse|Response|Redirector|ResponseFactory
     */
    public function success(Request $request, string $paymentCategory, int $countryCode, int $shopItem, int $paymentMethod)
    {
        $paymentCheckout = DB::table('chocolatey_shop_payment_checkout')
            ->where('category', $paymentCategory)->where('country', $countryCode)
            ->where('item', $shopItem)->where('method', $paymentMethod)->first();

        $purchaseItem = (new ShopHistory)->store($paymentMethod, $request->user()->uniqueId, $shopItem);
        $purchaseItem->save();

        (new MailController)->send(['email' => $request->user()->email, 'purchaseId' => $purchaseItem->transactionId,
            'product' => DB::table('chocolatey_shop_items')->where('id', $shopItem)->first(), 'subject' => 'Purchase completed'
        ], 'habbo-web-mail.purchase-confirmation');

        return $paymentCheckout != null ? response(view('habbo-web-payments.success-payment', [
            'checkoutId' => $purchaseItem->transactionId]), 200)
            : response(view('habbo-web-payments.canceled-payment'), 500);
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
        return response()->json(ShopHistory::where('user_id', $request->user()->uniqueId)->get());
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

        DB::table('vouchers')->where('code', $request->json()->get('voucherCode'))->delete();

        return response()->json(null, 204);
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
        return response()->json(['url' => Config::get('chocolatey.earn_link')]);
    }
}
