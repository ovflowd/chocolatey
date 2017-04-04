<?php

namespace App\Helpers;

use App\Facades\Session;
use App\Models\User as UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

/**
 * Class User
 * @package App\Helpers
 */
class User
{
    /**
     * Quick Way to Get User Data
     *
     * @return UserModel|null
     */
    public static function getUser()
    {
        return self::getInstance()->getSession();
    }

    /**
     * Get User Data from Session
     * If User Session doesn't exists, return null
     *
     * @return UserModel|null
     */
    public function getSession()
    {
        return Session::get(Config::get('chocolatey.security.session')) ?? null;
    }

    /**
     * Create and return a User instance
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
     * Quick Way to Update User Data
     *
     * @param array $parameters
     * @return UserModel
     */
    public static function updateUser(array $parameters)
    {
        return self::getInstance()->updateSession($parameters);
    }

    /**
     * Update User Data without overwriting Session
     *
     * @param array $parameters
     * @return UserModel
     */
    public function updateSession(array $parameters)
    {
        return $this->setSession($this->updateData($this->getSession(), $parameters));
    }

    /**
     * Set User Data on Session
     *
     * @param UserModel $user
     * @return UserModel
     */
    public function setSession(UserModel $user)
    {
        return Session::set(Config::get('chocolatey.security.session'), $user);
    }

    /**
     * Update User Data by User Model
     *
     * @param UserModel $user
     * @param array $parameters
     * @return UserModel
     */
    public function updateData(UserModel $user, array $parameters)
    {
        $user->update($parameters);

        return $user;
    }

    /**
     * Set Session From Login Credentials
     *
     * @param Request $request
     * @return UserModel
     */
    public function loginUser(Request $request)
    {
        return $this->setSession(UserModel::where('mail', $request->json()->get('email'))
            ->where('password', hash(Config::get('chocolatey.security.hash'), $request->json()->get('password')))->first());
    }

    /**
     * Return if USer Session Exists
     *
     * @return bool
     */
    public function hasSession()
    {
        return (bool)Session::get(Config::get('chocolatey.security.session'));
    }

    /**
     * Erase User Session
     */
    public function eraseSession()
    {
        Session::erase(Config::get('chocolatey.security.session'));
    }
}