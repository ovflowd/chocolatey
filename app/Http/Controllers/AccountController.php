<?php

namespace App\Http\Controllers;

use App\Facades\Session;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Laravel\Lumen\Http\ResponseFactory;
use Laravel\Lumen\Routing\Controller as BaseController;

/**
 * Class AccountController
 * @package App\Http\Controllers
 */
class AccountController extends BaseController
{

    /**
     * Check an User Name
     *
     * @param Request $request
     * @param string $selectType
     * @return JsonResponse
     */
    public function checkName(Request $request, $selectType)
    {
        if ($selectType != 'select' && $selectType != 'check')
            return response(null, 400);

        $desiredUsername = $request->json()->get('name');

        if (DB::table('users')->where('username', $desiredUsername)->count() > 0)
            return response()->json(['code' => 'NAME_IN_USE', 'validationResult' => null, 'suggestions' => []]);

        if ($selectType == 'select'):
            $userData = $request->user();
            $userData->name = $desiredUsername;

            DB::table('users')->where('id', $userData->uniqueId)->update(['username' => $userData->name]);

            Session::set('azureWEB', $userData);
        endif;

        return response()->json(['code' => 'OK', 'validationResult' => null, 'suggestions' => []]);
    }

    /**
     * Save User Look
     *
     * @param Request $request
     * @return ResponseFactory
     */
    public function saveLook(Request $request)
    {
        if ($request->json()->get('gender') != 'm' && $request->json()->get('gender') != 'f')
            return response(null, 400);

        $userData = $request->user();
        $userData->figureString = $request->json()->get('figure');
        $userData->gender = $request->json()->get('gender');

        DB::table('users')->where('id', $userData->uniqueId)->update(
            ['look' => $userData->figureString, 'gender' => $userData->gender]);

        Session::set('azureWEB', $userData);

        return response()->json($userData);
    }

    /**
     * Select a Room
     *
     * @TODO: Generate the Room for the User
     * @TODO: Get Room Models.
     *
     * @param Request $request
     * @return ResponseFactory
     */
    public function selectRoom(Request $request)
    {
        $roomIndex = $request->json()->get('roomIndex');

        if ($roomIndex != 1 && $roomIndex != 2 && $roomIndex != 3)
            return response(null, 400);

        return response(null, 200);
    }
}
