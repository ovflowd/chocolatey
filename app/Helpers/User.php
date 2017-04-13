<?php

namespace App\Helpers;

use App\Facades\Session;
use App\Models\User as UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

/**
 * Class User.
 */
class User
{
    /**
     * Create and return a User instance.
     *
     * @return User
     */
    public static function getInstance()
    {
        static $instance = null;

        if ($instance === null) {
            $instance = new static();
        }

        return $instance;
    }

    /**
     * Update User Data without overwriting Session.
     *
     * @param array $parameters
     *
     * @return UserModel
     */
    public function updateSession(array $parameters)
    {
        return $this->setSession($this->updateData($this->getUser(), $parameters));
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
    public function updateData(UserModel $user, array $parameters)
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
     * Set Session From Login Credentials.
     *
     * @param Request $request
     *
     * @return UserModel
     */
    public function loginUser(Request $request)
    {
        $user = UserModel::where('mail', $request->json()->get('email'))->where('password',
            hash(Config::get('chocolatey.security.hash'), $request->json()->get('password')))->first();

        return $user != null ? $this->setSession($user) : null;
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

    /**
     * Filter an Username from the Invalid Names Base.
     *
     * @param string $userName
     *
     * @return bool
     */
    public function filterName(string $userName): bool
    {
        return (count(array_filter(Config::get('chocolatey.invalid'), function ($username) use ($userName) {
            return stripos($userName, $username) !== false;
        })) == 0) && strlen($userName) <= 50 && strlen($userName) >= 4;
    }
}
