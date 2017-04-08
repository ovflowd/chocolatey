<?php

namespace App\Http\Controllers;

use App\Models\EmulatorSettings;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Intervention\Image\Facades\Image;
use Laravel\Lumen\Http\Redirector;
use Laravel\Lumen\Routing\Controller as BaseController;

/**
 * Class ImagingController.
 */
class ImagingController extends BaseController
{
    /**
     * Get User Figure for Big Header
     * based on User Name or Figure.
     *
     * @param Request $request
     *
     * @return Redirector
     */
    public function getUserHead(Request $request)
    {
        return redirect(Config::get('chocolatey.imaging').'avatarimage?figure='.($request->has('figure') ? $request->input('figure') :
                User::where('username', $request->input('user'))->first()->figureString).'&size=l&headonly=1');
    }

    /**
     * Get User Figure for Body
     * based on User Figure.
     *
     * @param string $figure
     *
     * @return Redirector
     */
    public function getUserBody(string $figure)
    {
        return redirect(Config::get('chocolatey.imaging')."avatar/{$figure}");
    }

    /**
     * Get Youtube Thumbnail.
     *
     * @param Request $request
     *
     * @return string
     */
    public function getYoutubeThumbnail(Request $request)
    {
        return Image::make($request->input('url'))->response('jpg');
    }

    /**
     * Return Group Badge.
     *
     * @param string $badgeCode
     *
     * @return mixed
     */
    public function getGroupBadge(string $badgeCode)
    {
        $imagePath = EmulatorSettings::where('key', 'imager.location.output.badges')->first();

        $badgeCode = str_replace('.gif', '', $badgeCode);

        return Image::make("{$imagePath->value}/{$badgeCode}.png")->response('gif');
    }
}
