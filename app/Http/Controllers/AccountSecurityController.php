<?php

namespace App\Http\Controllers;

use App\Models\ChocolateyId;
use App\Models\Mail;
use App\Models\TrustedDevice;
use App\Models\User;
use App\Models\UserSecurity;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
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
     * @return Response
     */
    public function featureStatus(Request $request): Response
    {
        if ($request->user()->emailVerified == false)
            return response('identity_verification_required', 200);

        $featureEnabled = UserSecurity::find($request->user()->uniqueId);

        return response($featureEnabled !== null ? 'enabled' : 'disabled', 200);
    }

    /**
     * Save Security Questions
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function saveQuestions(Request $request): JsonResponse
    {
        if (User::where('password', hash('sha256', $request->json()->get('password')))->count() == 0)
            return response()->json(['error' => 'invalid_password'], 400);

        UserSecurity::updateOrCreate([
            'user_id' => $request->user()->uniqueId,
            'firstQuestion' => $request->json()->get('questionId1'),
            'secondQuestion' => $request->json()->get('questionId2'),
            'firstAnswer' => $request->json()->get('answer1'),
            'secondAnswer' => $request->json()->get('answer2')]);

        return response()->json('', 204);
    }

    /**
     * Disable Safety Lock
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function disable(Request $request): JsonResponse
    {
        UserSecurity::find($request->user()->uniqueId)->delete();

        return response()->json('', 204);
    }

    /**
     * Reset Trusted Devices
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function reset(Request $request): JsonResponse
    {
        TrustedDevice::find($request->user()->uniqueId)->delete();

        return response()->json('', 204);
    }

    /**
     * Change User Password
     *
     * @TODO: Implement Notification E-mail of Password change
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function changePassword(Request $request): JsonResponse
    {
        if (strlen($request->json()->get('password')) < 6)
            return response()->json(['error' => 'password.current_password.invalid'], 409);

        //@TODO: This search the whole base. If anyone has the same password.. This will give error. Is this good?
        if (User::where('password', hash('sha256', $request->json()->get('currentPassword')))->count() >= 1)
            return response()->json(['error' => 'password.used_earlier'], 409);

        User::find($request->user()->uniqueId)->update(['password' => hash('sha256', $request->json()->get('password'))]);

        return response()->json('', 204);
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
    public function changeMail(Request $request): JsonResponse
    {
        if (User::where('password', hash('sha256', $request->json()->get('currentPassword')))->count() == 0)
            return response()->json(['error' => 'changeEmail.invalid_password'], 400);

        if (strpos($request->json()->get('newEmail'), '@') == false)
            return response()->json(['error' => 'registration_email'], 400);

        if (ChocolateyId::where('mail', $request->json()->get('newEmail'))->count() > 0)
            return response()->json(['error' => 'changeEmail.email_already_in_use'], 400);

        $mailController = new MailController;

        $mailController->send([
            'mail' => $request->user()->email,
            'newMail' => $request->json()->get('newEmail'),
            'name' => $request->user()->name],
            'habbo-web-mail.mail-change-alert');

        $mailController->send([
            'mail' => $request->json()->get('newEmail'),
            'name' => $request->user()->name,
            'url' => "/activate/{$mailController
            ->prepare($request->user()->email, "change-email/{$request->json()->get('newEmail')}")}"
        ], 'habbo-web-mail.confirm-mail-change');

        return response()->json(['email' => $request->json()->get('newEmail')], 200);
    }

    /**
     * Get User Security Questions
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getQuestions(Request $request): JsonResponse
    {
        if (UserSecurity::find($request->user()->uniqueId) == null)
            return response()->json('');

        $userSecurity = UserSecurity::find($request->user()->uniqueId);

        $firstQuestion = new stdClass();
        $firstQuestion->questionId = $userSecurity->firstQuestion;
        $firstQuestion->questionKey = "IDENTITY_SAFETYQUESTION_{$userSecurity->firstQuestion}";

        $secondQuestion = new stdClass();
        $secondQuestion->questionId = $userSecurity->secondQuestion;
        $secondQuestion->questionKey = "IDENTITY_SAFETYQUESTION_{$userSecurity->secondQuestion}";

        return response()->json([$firstQuestion, $secondQuestion]);
    }

    /**
     * Verify User Security Questions
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function verifyQuestions(Request $request): JsonResponse
    {
        if (UserSecurity::where('user_id', $request->user()->uniqueId)
                ->where('firstAnswer', $request->json()->get('answer1'))
                ->where('secondAnswer', $request->json()->get('answer2'))->count() > 0
        ):
            if ($request->json()->get('trust') == true)
                (new TrustedDevice)->store($request->user()->uniqueId, $request->ip())->save();

            return response()->json('', 204);
        endif;

        return response()->json('', 409);
    }

    /**
     * Confirm User Change Password
     *
     * @param Request $request
     * @return mixed
     */
    public function confirmChangePassword(Request $request): JsonResponse
    {
        $mailRequest = Mail::where('token', $request->json()->get('token'))->where('used', '0')->first();

        if ($mailRequest == null)
            return response()->json('', 404);

        if (User::where('password', hash('sha256', $request->json()->get('password')))->count() >= 1)
            return response()->json(['error' => 'password.used_earlier'], 400);

        $mailRequest->update(['used' => '1']);

        DB::table('users')->where('mail', $mailRequest->mail)
            ->update(['password' => hash('sha256', $request->json()->get('password'))]);

        return response()->json('');
    }
}
