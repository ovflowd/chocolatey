<?php

namespace App\Http\Controllers;

use App\Facades\Session;
use App\Models\AzureId;
use App\Models\TrustedDevice;
use App\Models\User;
use App\Models\UserSecurity;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Laravel\Lumen\Http\ResponseFactory;
use Laravel\Lumen\Routing\Controller as BaseController;
use stdClass;

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
        $mailVerified = AzureId::where('user_id', $request->user()->uniqueId)->first()->emailVerified;

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
        if (User::where('id', $request->user()->uniqueId)
                ->where('password', md5($request->json()->get('password')))->count() == 0
        )
            return response()->json(['error' => 'invalid_password'], 400);

        if (UserSecurity::where('user_id', $request->user()->uniqueId)->count() > 0):
            UserSecurity::where('user_id', $request->user()->uniqueId)->update([
                'firstQuestion' => $request->json()->get('questionId1'),
                'secondQuestion' => $request->json()->get('questionId2'),
                'firstAnswer' => $request->json()->get('answer1'),
                'secondAnswer' => $request->json()->get('answer2')]);

            return response(null, 204);
        endif;

        (new UserSecurity)->store($request->user()->uniqueId,
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
        UserSecurity::where('user_id', $request->user()->uniqueId)->delete();

        return response(null, 204);
    }

    /**
     * Reset Trusted Devices
     *
     * @param Request $request
     * @return ResponseFactory
     */
    public function reset(Request $request)
    {
        TrustedDevice::where('user_id', $request->user()->uniqueId)->delete();

        return response(null, 204);
    }

    /**
     * Change User Password
     *
     * @TODO: Implement Notification E-mail of Password change
     *
     * @param Request $request
     * @return ResponseFactory
     */
    public function changePassword(Request $request)
    {
        $userId = $request->user()->uniqueId;

        if (DB::table('users')->where('id', $userId)
                ->where('password', md5($request->json()->get('currentPassword')))->count() == 0
        )
            return response()->json(['error' => 'password.current_password.invalid'], 409);

        if (DB::table('users')->where('id', $userId)
                ->where('password', md5($request->json()->get('password')))->count() == 1
        )
            return response()->json(['error' => 'password.used_earlier'], 409);

        DB::table('users')->where('id', $userId)->update(['password' => md5($request->json()->get('password'))]);

        return response(null, 204);
    }

    /**
     * Change User E-mail
     *
     * @TODO: Implement Notification of E-mail Change
     * @TODO: Implement Confirmation of E-mail Change
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function changeMail(Request $request)
    {
        if (User::where('id', $request->user()->uniqueId)->where('password', md5($request->json()->get('currentPassword')))->count() == 0)
            return response()->json(['error' => 'changeEmail.invalid_password'], 400);

        if (strpos($request->json()->get('newEmail'), '@') == false)
            return response()->json(['error' => 'registration_email'], 400);

        if (AzureId::where('mail', $request->json()->get('newEmail'))->count() > 0)
            return response()->json(['error' => 'changeEmail.email_already_in_use'], 400);

        // @TODO: In the futurue the e-mail only will be changed after e-mail confirmation
        User::where('id', $request->user()->uniqueId)->update(['mail' => $request->json()->get('newEmail')]);

        Session::set('ChocolateyWEB', User::where('id', $request->user()->uniqueId)->first());

        return response()->json(['email' => $request->json()->get('newEmail')], 200);
    }

    /**
     * Get User Security Questions
     *
     * @param Request $request
     * @return ResponseFactory
     */
    public function getQuestions(Request $request)
    {
        if (UserSecurity::query()->where('user_id', $request->user()->uniqueId)->count() == 0)
            return response(null, 200);

        $userSecurity = UserSecurity::where('user_id', $request->user()->uniqueId)->first();

        $firstQuestion = new stdClass();
        $firstQuestion->questionId = $userSecurity->firstQuestion;
        $firstQuestion->questionKey = "IDENTITY_SAFETYQUESTION_{$userSecurity->firstQuestion}";

        $secondQuestion = new stdClass();
        $secondQuestion->questionId = $userSecurity->secondQuestion;
        $secondQuestion->questionKey = "IDENTITY_SAFETYQUESTION_{$userSecurity->secondQuestion}";

        return response()->json([$firstQuestion, $secondQuestion]);
    }

    public function verifyQuestions(Request $request)
    {
        if (UserSecurity::where('user_id', $request->user()->uniqueId)
                ->where('firstAnswer', $request->json()->get('answer1'))
                ->where('secondAnswer', $request->json()->get('answer2'))->count() > 0
        ):
            if ($request->json()->get('trust') == true)
                (new TrustedDevice)->store($request->user()->uniqueId, $request->ip())->save();

            return response(null, 204);
        endif;

        return response(null, 409);
    }
}
