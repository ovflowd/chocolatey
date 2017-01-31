<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use App\Models\PhotoLike;
use App\Models\PhotoReport;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller as BaseController;

/**
 * Class PublicPhotosController
 * @package App\Http\Controllers
 */
class PublicPhotosController extends BaseController
{
    /**
     * Render a set of Public HabboWEB Photos
     *
     * @TODO: Exclude Approved Reported Photos from the List
     *
     * @return JsonResponse
     */
    public function show(): JsonResponse
    {
        return response()->json(Photo::all(), 200, array(), JSON_UNESCAPED_SLASHES);
    }

    /**
     * Register a Report of a Photo
     * Observation.: We will not create a limit of max reports.
     * Since it's a retro we don't really care about reports.
     *
     * @MODERATION: Reporting Status (0 = Not Reviewed, 1 = Report Approved, 2 = Report Not Approved
     *
     * @param Request $request
     * @param int $photoIdentifier
     * @return JsonResponse
     */
    public function report(Request $request, $photoIdentifier): JsonResponse
    {
        (new PhotoReport)->store($photoIdentifier, $request->json()->get('reason'), $request->user()->uniqueId)->save();

        return response()->json('');
    }

    /**
     * Like a Photo
     *
     * @param Request $request
     * @param int $photoId
     * @return JsonResponse
     */
    public function likePhoto(Request $request, $photoId): JsonResponse
    {
        if (PhotoLike::where('username', $request->user()->name)->where('photo_id', $photoId)->count() > 0)
            return response()->json('');

        (new PhotoLike)->store($photoId, $request->user()->name)->save();

        return response()->json('');
    }

    /**
     * Unlike a Photo
     *
     * @param Request $request
     * @param int $photoId
     * @return JsonResponse
     */
    public function unlikePhoto(Request $request, $photoId): JsonResponse
    {
        if (PhotoLike::where('username', $request->user()->name)->where('photo_id', $photoId)->count() == 0)
            return response()->json('');

        PhotoLike::where('username', $request->user()->name)->where('photo_id', $photoId)->delete();

        return response()->json('');
    }
}
