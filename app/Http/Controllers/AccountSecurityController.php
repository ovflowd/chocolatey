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
     * @param Request $request
     *
     * @return Response
     */
    public function featureStatus(Request $request): Response
    {
        if ($request->user()->emailVerified == false) {
            return response('identity_verification_required', 200);
        }

        $featureEnabled = UserSecurity::find($request->user()->uniqueId);

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
            'user_id'        => $request->user()->uniqueId,
            'firstQuestion'  => $request->json()->get('questionId1'),
            'secondQuestion' => $request->json()->get('questionId2'),
            'firstAnswer'    => $request->json()->get('answer1'),
            'secondAnswer'   => $request->json()->get('answer2'), ]);

        return response()->json(null, 204);
    }

    /**
     * Disable Safety Lock.
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function disable(Request $request): JsonResponse
    {
        UserSecurity::find($request->user()->uniqueId)->delete();

        return response()->json(null, 204);
    }

    /**
     * Reset Trusted Devices.
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function reset(Request $request): JsonResponse
    {
        TrustedDevice::find($request->user()->uniqueId)->delete();

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

        UserFacade::updateUser(['password' => hash(Config::get('chocolatey.security.hash'), $request->json()->get('password'))]);

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
        Mail::send(['email' => $request->user()->email,
            'name'          => $request->user()->name, 'subject' => 'Email change alert',
        ], 'habbo-web-mail.mail-change-alert');

        $generatedToken = Mail::store($request->user()->email,
            "change-email/{$request->json()->get('newEmail')}");

        Mail::send(['email' => $request->json()->get('newEmail'), 'name' => $request->user()->name,
            'subject'       => 'Email change confirmation', 'url' => "/activate/{$generatedToken}",
        ], 'habbo-web-mail.confirm-mail-change');
    }

    /**
     * Get User Security Questions.
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function getQuestions(Request $request): JsonResponse
    {
        if (UserSecurity::find($request->user()->uniqueId) == null) {
            return response()->json('');
        }

        $userSecurity = UserSecurity::find($request->user()->uniqueId);

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
        $questions = UserSecurity::find($request->user()->uniqueId);

        if ($questions->firstAnswer == $request->json()->get('answer1') && $questions->secondAnswer == $request->json()->get('answer2')):
            if ($request->json()->get('trust') == true) {
                (new TrustedDevice())->store($request->user()->uniqueId, $request->ip())->save();
            }

        return response()->json(null, 204);
        endif;

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

        UserFacade::updateData(User::where('mail', Mail::getMail()->mail), ['password' => hash(Config::get('chocolatey.security.hash'), $request->json()->get('password'))]);

        return response()->json(null);
    }
}
