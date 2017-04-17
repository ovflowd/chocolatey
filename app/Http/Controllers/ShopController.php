<?php

namespace App\Http\Controllers;

use App\Facades\Mail;
use App\Facades\User as UserFacade;
use App\Models\Country;
use App\Models\PaymentCheckout;
use App\Models\Purse;
use App\Models\ShopHistory;
use App\Models\ShopInventory;
use App\Models\ShopItem;
use App\Models\Voucher;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Laravel\Lumen\Http\Redirector;
use Laravel\Lumen\Http\ResponseFactory;
use Laravel\Lumen\Routing\Controller as BaseController;

/**
 * Class ShopController.
 */
class ShopController extends BaseController
{
    /**
     * List all Shop Countries.
     *
     * @return JsonResponse
     */
    public function listCountries(): JsonResponse
    {
        return response()->json(Country::all());
    }

    /**
     * Get the Shop Inventory of a Country.
     *
     * @param string $countryCode
     *
     * @return JsonResponse
     */
    public function getInventory(string $countryCode): JsonResponse
    {
        return response()->json(new ShopInventory(Country::where('countryCode', $countryCode)->first()),
            200, [], JSON_UNESCAPED_SLASHES);
    }

    /**
     * Get User Purse.
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function getPurse(Request $request): JsonResponse
    {
        return response()->json(new Purse(UserFacade::getUser()->uniqueId));
    }

    /**
     * Proceed Payment Checkout.
     *
     * @param string $paymentCategory
     * @param int    $countryCode
     * @param int    $shopItem
     * @param int    $paymentMethod
     *
     * @return RedirectResponse|Response|Redirector|ResponseFactory
     */
    public function proceed(string $paymentCategory, int $countryCode, int $shopItem, int $paymentMethod)
    {
        $paymentCheckout = PaymentCheckout::where('category', $paymentCategory)->where('country', $countryCode)
            ->where('item', $shopItem)->where('method', $paymentMethod)->first();

        if ($paymentCheckout == null) {
            return response(view('habbo-web-payments.failed-payment'), 400);
        }

        if ((strtotime($paymentCheckout->generated_at) + 172800) < time()) {
            return response(view('habbo-web-payments.canceled-payment'), 400);
        }

        return response(view('habbo-web-payments.proceed', ['payment' => $paymentCheckout]));
    }

    /**
     * Success Payment Checkout.
     *
     * @TODO: Code Business Logic
     *
     * @param Request $request
     * @param string  $paymentCategory
     * @param int     $countryCode
     * @param int     $shopItem
     * @param int     $paymentMethod
     *
     * @return RedirectResponse|Response|Redirector|ResponseFactory
     */
    public function success(Request $request, string $paymentCategory, int $countryCode, int $shopItem, int $paymentMethod)
    {
        $paymentCheckout = PaymentCheckout::where('category', $paymentCategory)->where('country', $countryCode)
            ->where('item', $shopItem)->where('method', $paymentMethod)->first();

        if ($paymentCheckout == null) {
            return response(view('habbo-web-payments.canceled-payment'), 500);
        }

        $purchaseItem = (new ShopHistory())->store($paymentMethod, UserFacade::getUser()->uniqueId, $shopItem);

        Mail::send(['email' => UserFacade::getUser()->email, 'purchaseId' => $purchaseItem->transactionId,
            'product'       => ShopItem::find($shopItem), 'subject' => 'Purchase completed',
        ], 'habbo-web-mail.purchase-confirmation');

        $paymentCheckout->delete();

        return response(view('habbo-web-payments.success-payment', ['checkoutId' => $purchaseItem->transactionId]), 200);
    }

    /**
     * Get User Purchase History.
     *
     * @TODO: User Purchase History will be coded on the Future
     * @TODO: All Purchases of the CMS are Manually, so will be difficult track.
     * @TODO: Probably Administrators will Manually Insert History Through HK
     *
     * @return JsonResponse
     */
    public function getHistory(): JsonResponse
    {
        return response()->json(ShopHistory::where('user_id', UserFacade::getUser()->uniqueId)->get());
    }

    /**
     * Redeem Voucher.
     *
     * @TODO: Need to Test if really works
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function redeem(Request $request): JsonResponse
    {
        if (($voucher = Voucher::where('code', $request->json()->get('voucherCode'))->first()) == null) {
            return response()->json(null, 404);
        }

        UserFacade::getUser()->increment('credits', $voucher->credits);
        UserFacade::getUser()->increment('pixels', $voucher->points);

        $voucher->delete();

        return response()->json(null, 204);
    }
}
