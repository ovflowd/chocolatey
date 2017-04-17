<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use Laravel\Lumen\Routing\Controller as BaseController;

/**
 * Class LanguageController.
 */
class LanguageController extends BaseController
{
    /**
     * Render Language View (jSON).
     *
     * @param $languageFile
     *
     * @return Response
     */
    public function render($languageFile): Response
    {
        $languageName = strstr($languageFile, '.json', true);

        return response(view("habbo-web-l10n.{$languageName}"))->header('Content-Type', 'application/json');
    }
}
