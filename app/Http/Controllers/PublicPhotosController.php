<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use App\Models\PhotoReport;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
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
     * @return Response
     */
    public function show()
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
     * @return Response
     */
    public function report(Request $request, $photoIdentifier)
    {
        if (PhotoReport::query()->where('photo_id', $photoIdentifier)
                ->where('reported_by', $userId = $request->user()->uniqueId)
                ->where('approved', 0)->count() > 0
        )
            return response(null, 429);

        (new PhotoReport)->store($photoIdentifier, $request->json()->get('reason'), $userId)->save();

        return response(null, 200);
    }
}
