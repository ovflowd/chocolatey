<?php

namespace App\Helpers;

use App\Facades\Session;
use App\Models\ChocolateyId;
use App\Models\User as UserModel;
use App\Singleton;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

/**
 * Class User.
 */
final class User extends Singleton
{
    /**
     * Update User Data without overwriting Session.
     *
     * @param array $parameters
     *
     * @return UserModel
     */
    public function updateSession(array $parameters)
    {
        return $this->setSession($this->updateUser($this->getUser(), $parameters));
    }

    /**
     * Set User Data on Session.
     *
     * @param UserModel $user
     *
     * @return UserModel
     */
    public function setSession(UserModel $user)
    {
        return Session::set(Config::get('chocolatey.security.session'), $user);
    }

    /**
     * Update User Data by User Model.
     *
     * @param UserModel $user
     * @param array     $parameters
     *
     * @return UserModel
     */
    public function updateUser($user, array $parameters)
    {
        $user->update($parameters);

        return $user;
    }

    /**
     * Get User Data from Session
     * If User Session doesn't exists, return null.
     *
     * @return UserModel|null
     */
    public function getUser()
    {
        return Session::get(Config::get('chocolatey.security.session')) ?? null;
    }

    /**
     * Retrieve Non Banned Users (If all Users are Banned, return the Banned user Also).
     *
     * @param Request      $request
     * @param ChocolateyId $chocolateyId
     *
     * @return UserModel
     */
    private function checkForBanAlternative(Request $request, ChocolateyId $chocolateyId)
    {
        $temporaryUsers = UserModel::where('mail', $request->json()->get('email'))->get();

        foreach ($temporaryUsers as $forUser) {
            if (!$forUser->isBanned) {
                return $forUser;
            }
        }

        return $temporaryUsers->get(0);
    }

    /**
     * Get Users.
     *
     * @param Request      $request
     * @param ChocolateyId $chocolateyId
     *
     * @return UserModel
     */
    private function retrieveUser(Request $request, ChocolateyId $chocolateyId)
    {
        if ($chocolateyId->last_logged_id != 0) {
            $temporaryUser = UserModel::find($chocolateyId->last_logged_id);

            if ($temporaryUser->isBanned) {
                return $this->checkForBanAlternative($request, $chocolateyId);
            }

            return $temporaryUser;
        }

        $temporaryUser = UserModel::where('mail', $request->json()->get('email'))->first();

        if ($temporaryUser->isBanned) {
            return $this->checkForBanAlternative($request, $chocolateyId);
        }

        return $temporaryUser;
    }

    /**
     * Set Session From Login Credentials.
     *
     * @param Request $request
     *
     * @return UserModel
     */
    public function loginUser(Request $request)
    {
        $chocolateyId = ChocolateyId::find($request->json()->get('email'));

        if ($chocolateyId == null) {
            return;
        }

        $user = $this->retrieveUser($request, $chocolateyId);

        $chocolateyId->last_logged_id = $user->uniqueId;

        return $chocolateyId->password == hash(Config::get('chocolatey.security.hash'), $request->json()->get('password'))
            ? $this->setSession($user) : null;
    }

    /**
     * Return if USer Session Exists.
     *
     * @return bool
     */
    public function hasSession()
    {
        return (bool) Session::get(Config::get('chocolatey.security.session'));
    }

    /**
     * Erase User Session.
     */
    public function eraseSession()
    {
        Session::erase(Config::get('chocolatey.security.session'));
    }
}
