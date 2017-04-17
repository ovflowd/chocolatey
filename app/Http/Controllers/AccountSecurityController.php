<?php

namespace App\Http\Controllers;

use App\Facades\Mail;
use App\Facades\User as UserFacade;
use App\Models\ChocolateyId;
use App\Models\Question;
use App\Models\TrustedDevice;
use App\Models\User;
use App\Models\UserSecurity;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Config;
use Laravel\Lumen\Routing\Controller as BaseController;

/**
 * Class AccountSecurityController.
 */
class AccountSecurityController extends BaseController
{
    /**
     * Check if Feature Status is Enabled.
     *
     * @return Response
     */
    public function featureStatus(): Response
    {
        if (UserFacade::getUser()->emailVerified == false) {
            return response('identity_verification_required', 200);
        }

        $featureEnabled = UserSecurity::find(UserFacade::getUser()->uniqueId);

        return response($featureEnabled !== null ? 'enabled' : 'disabled', 200);
    }

    /**
     * Save Security Questions.
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function saveQuestions(Request $request): JsonResponse
    {
        if (User::where('password', hash(Config::get('chocolatey.security.hash'), $request->json()->get('password')))->count() == 0) {
            return response()->json(['error' => 'invalid_password'], 400);
        }

        UserSecurity::updateOrCreate([
            'user_id' => UserFacade::getUser()->uniqueId,
            'firstQuestion' => $request->json()->get('questionId1'),
            'secondQuestion' => $request->json()->get('questionId2'),
            'firstAnswer' => $request->json()->get('answer1'),
            'secondAnswer' => $request->json()->get('answer2'),]);

        return response()->json(null, 204);
    }

    /**
     * Disable Safety Lock.
     *
     * @return JsonResponse
     */
    public function disable(): JsonResponse
    {
        UserSecurity::find(UserFacade::getUser()->uniqueId)->delete();

        return response()->json(null, 204);
    }

    /**
     * Reset Trusted Devices.
     *
     * @return JsonResponse
     */
    public function reset(): JsonResponse
    {
        TrustedDevice::find(UserFacade::getUser()->uniqueId)->delete();

        return response()->json(null, 204);
    }

    /**
     * Change User Password.
     *
     * @TODO: Implement Notification E-mail of Password change
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function changePassword(Request $request): JsonResponse
    {
        if (strlen($request->json()->get('password')) < 6) {
            return response()->json(['error' => 'password.current_password.invalid'], 409);
        }

        UserFacade::updateSession(['password' => hash(Config::get('chocolatey.security.hash'), $request->json()->get('password'))]);

        return response()->json(null, 204);
    }

    /**
     * Change User E-mail.
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function changeMail(Request $request): JsonResponse
    {
        if (User::where('password', hash(Config::get('chocolatey.security.hash'), $request->json()->get('currentPassword')))->count() == 0) {
            return response()->json(['error' => 'changeEmail.invalid_password'], 400);
        }

        if (ChocolateyId::where('mail', $request->json()->get('newEmail'))->count() > 0) {
            return response()->json(['error' => 'changeEmail.email_already_in_use'], 400);
        }

        $this->sendChangeMailConfirmation($request);

        return response()->json(['email' => $request->json()->get('newEmail')], 200);
    }

    /**
     * Send the E-Mail confirmation.
     *
     * @param Request $request
     */
    protected function sendChangeMailConfirmation(Request $request)
    {
        Mail::send(['email' => UserFacade::getUser()->email,
            'name' => UserFacade::getUser()->name, 'subject' => 'Email change alert',
        ], 'habbo-web-mail.mail-change-alert');

        $generatedToken = Mail::store(UserFacade::getUser()->email,
            "change-email/{$request->json()->get('newEmail')}");

        Mail::send(['email' => $request->json()->get('newEmail'), 'name' => UserFacade::getUser()->name,
            'subject' => 'Email change confirmation', 'url' => "/activate/{$generatedToken}",
        ], 'habbo-web-mail.confirm-mail-change');
    }

    /**
     * Get User Security Questions.
     *
     * @return JsonResponse
     */
    public function getQuestions(): JsonResponse
    {
        if (UserSecurity::find(UserFacade::getUser()->uniqueId) == null) {
            return response()->json('');
        }

        $userSecurity = UserSecurity::find(UserFacade::getUser()->uniqueId);

        return response()->json([
            new Question($userSecurity->firstQuestion,
                "IDENTITY_SAFETYQUESTION_{$userSecurity->firstQuestion}"),
            new Question($userSecurity->secondQuestion,
                "IDENTITY_SAFETYQUESTION_{$userSecurity->secondQuestion}"),
        ]);
    }

    /**
     * Verify User Security Questions.
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function verifyQuestions(Request $request): JsonResponse
    {
        $questions = UserSecurity::find(UserFacade::getUser()->uniqueId);

        if ($questions->firstAnswer == $request->json()->get('answer1') && $questions->secondAnswer == $request->json()->get('answer2')) {
            if ($request->json()->get('trust') == true) {
                (new TrustedDevice)->store(UserFacade::getUser()->uniqueId, $request->ip());
            }

            return response()->json(null, 204);
        }

        return response()->json(null, 409);
    }

    /**
     * Confirm User Change Password.
     *
     * @param Request $request
     *
     * @return mixed
     */
    public function confirmChangePassword(Request $request): JsonResponse
    {
        if (Mail::getByToken($request->json()->get('token')) == null) {
            return response()->json(null, 404);
        }

        UserFacade::updateUser(User::where('mail', Mail::getMail()->mail), ['password' => hash(Config::get('chocolatey.security.hash'), $request->json()->get('password'))]);

        return response()->json(null);
    }
}
