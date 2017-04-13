<?php

namespace App\Http\Controllers;

use App\Facades\Nux;
use App\Facades\User as UserFacade;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Laravel\Lumen\Routing\Controller as BaseController;

/**
 * Class NuxController
 * @package App\Http\Controllers
 */
class NuxController extends BaseController
{
    /**
     * Check an User Name.
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function checkName(Request $request): JsonResponse
    {
        if (UserFacade::where('username', $request->json()->get('name'))->count() > 0 && $request->json()->get('name') != UserFacade::getUser()->name) {
            return response()->json(['code' => 'NAME_IN_USE', 'validationResult' => null, 'suggestions' => []]);
        }

        if (strlen($request->json()->get('name')) > 50 || !UserFacade::filterName($request->json()->get('name'))) {
            return response()->json(['code' => 'INVALID_NAME', 'validationResult' => ['resultType' => 'VALIDATION_ERROR_ILLEGAL_WORDS'], 'suggestions' => []]);
        }

        return response()->json(['code' => 'OK', 'validationResult' => null, 'suggestions' => []]);
    }

    /**
     * Select an User Name.
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function selectName(Request $request): JsonResponse
    {
        UserFacade::updateSession(['username' => $request->json()->get('name')]);

        return response()->json(['code' => 'OK', 'validationResult' => null, 'suggestions' => []]);
    }

    /**
     * Select a Room.
     *
     * @TODO: Generate the Room for the User
     * @TODO: Get Room Models.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function selectRoom(Request $request): Response
    {
        if (!in_array($request->json()->get('roomIndex'), [1, 2, 3])) {
            return response('', 400);
        }

        UserFacade::updateSession(['traits' => (Nux::generateRoom($request) ? ['USER'] : ['USER', 'NEW_USER'])]);

        return response(null, 200);
    }
}