<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Config;
use Laravel\Lumen\Routing\Controller as BaseController;

/**
 * Class LanguageController
 * @package App\Http\Controllers
 */
class LanguageController extends BaseController
{
    /**
     * Render Language View (jSON)
     *
     * @param $languageFile
     * @return Response
     */
    public function render($languageFile)
    {
        $languageName = strstr($languageFile, '.json', true);

        return response(view("habbo-web-l10n.{$languageName}",
            ['azure' => Config::get('chocolatey')]), 200)->header('Content-Type', 'application/json');
    }
}
