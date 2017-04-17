<?php

namespace App\Http\Controllers;

use App\Facades\User as UserFacade;
use App\Models\Photo;
use App\Models\PhotoLike;
use App\Models\PhotoReport;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Laravel\Lumen\Routing\Controller as BaseController;

/**
 * Class PhotosController.
 */
class PhotosController extends BaseController
{
    /**
     * Render a set of Public HabboWEB Photos.
     *
     * @TODO: Exclude Approved Reported Photos from the List
     *
     * @return JsonResponse
     */
    public function show(): JsonResponse
    {
        return response()->json(Photo::all(), 200, [], JSON_UNESCAPED_SLASHES);
    }

    /**
     * Register a Report of a Photo
     * Observation.: We will not create a limit of max reports.
     * Since it's a retro we don't really care about reports.
     *
     * @MODERATION: Reporting Status (0 = Not Reviewed, 1 = Report Approved, 2 = Report Not Approved
     *
     * @param Request $request
     * @param int     $photoId
     *
     * @return Response
     */
    public function report(Request $request, int $photoId): Response
    {
        (new PhotoReport())->store($photoId, $request->json()->get('reason'), UserFacade::getUser()->uniqueId);

        return response(null);
    }

    /**
     * Like a Photo.
     *
     * @param int $photoId
     *
     * @return Response
     */
    public function likePhoto(int $photoId): Response
    {
        if (PhotoLike::where('username', UserFacade::getUser()->name)->where('photo_id', $photoId)->count() > 0) {
            return response(null);
        }

        (new PhotoLike())->store($photoId, UserFacade::getUser()->name);

        return response(null);
    }

    /**
     * Unlike a Photo.
     *
     * @param int $photoId
     *
     * @return Response
     */
    public function unlikePhoto(int $photoId): Response
    {
        if (PhotoLike::where('username', UserFacade::getUser()->name)->where('photo_id', $photoId)->count() == 0) {
            return response(null);
        }

        PhotoLike::where('username', UserFacade::getUser()->name)->where('photo_id', $photoId)->delete();

        return response(null);
    }

    /**
     * Delete a Photo.
     *
     * @param int $photoId
     *
     * @return Response
     */
    public function delete(int $photoId): Response
    {
        $photo = Photo::find($photoId);

        if ($photo == null || $photo->creator_id != UserFacade::getUser()->uniqueId) {
            return response(null, 401);
        }

        $photo->delete();

        return response(null);
    }
}
