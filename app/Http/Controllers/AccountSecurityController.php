<?php

namespace App\Http\Controllers;

use App\Models\AzureId;
use App\Models\UserSecurity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Laravel\Lumen\Http\ResponseFactory;
use Laravel\Lumen\Routing\Controller as BaseController;

/**
 * Class AccountSecurityController
 * @package App\Http\Controllers
 */
class AccountSecurityController extends BaseController
{
    /**
     * Check if Feature Status is Enabled
     *
     * @param Request $request
     * @return ResponseFactory
     */
    public function featureStatus(Request $request)
    {
        $mailVerified = AzureId::query()->where('user_id', $request->user()->uniqueId)->first()->mail_verified;

        if ($mailVerified == 1)
            return response('identity_verification_required', 200);

        $featureEnabled = UserSecurity::query()->where('user_id', $request->user()->uniqueId)->count();

        return response($featureEnabled > 0 ? 'enabled' : 'disabled', 200);
    }

    /**
     * Save Security Questions
     *
     * @param Request $request
     * @return ResponseFactory
     */
    public function saveQuestions(Request $request)
    {
        $userId = $request->user()->uniqueId;

        if (DB::table('users')->where('id', $userId)->where('password',
                md5($request->json()->get('password')))->count() == 0
        )
            return response()->json(['error' => 'invalid_password'], 400);

        if (UserSecurity::query()->where('user_id', $userId)->count() > 0):
            $userSecurity = UserSecurity::query()->where('user_id', $userId)->first();
            $userSecurity->firstQuestion = $request->json()->get('questionId1');
            $userSecurity->secondQuestion = $request->json()->get('questionId2');
            $userSecurity->firstAnswer = $request->json()->get('answer1');
            $userSecurity->secondAnswer = $request->json()->get('answer2');
            $userSecurity->save();

            return response(null, 204);
        endif;

        (new UserSecurity)->store($userId,
            $request->json()->get('questionId1'),
            $request->json()->get('questionId2'),
            $request->json()->get('answer1'),
            $request->json()->get('answer2'))->save();

        return response(null, 204);
    }

    /**
     * Disable Safety Lock
     *
     * @param Request $request
     * @return ResponseFactory
     */
    public function disable(Request $request)
    {
        UserSecurity::query()->where('user_id', $request->user()->uniqueId)->delete();

        return response(null, 204);
    }

    /**
     * Reset Trusted Devices
     *
     * @TODO: Implement Trusted Devices System
     *
     * @param Request $request
     * @return ResponseFactory
     */
    public function reset(Request $request)
    {
        return response(null, 204);
    }
}
