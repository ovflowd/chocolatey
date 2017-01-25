<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use App\Models\PhotoLike;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
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
        $habboWebPhotos = Photo::all();

        foreach ($habboWebPhotos as $photo):
            $likes = [];

            foreach (PhotoLike::query()->select('username')->where('photo_id', $photo->id)->get() as $like)
                $likes[] = $like->username;

            $photo->likes = $likes;
        endforeach;

        return response()->json($habboWebPhotos, 200, array(), JSON_UNESCAPED_SLASHES);
    }

    /**
     * Register a Report of a Photo
     * Observation.: We will not create a limit of max reports.
     * Since it's a retro we don't really care about reports.
     *
     * @param Request $request
     * @param int $photoIdentifier
     * @return Response
     */
    public function report(Request $request, $photoIdentifier)
    {
        DB::table('azure_user_photos_reported')->insert([
            'photo_id' => $photoIdentifier, 'reason_id' => $request->json()->get('reason'),
            'reported_by' => $request->user()->uniqueId, 'approved' => 0
        ]);

        return response(null, 200);
    }
}
