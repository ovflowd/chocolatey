<?php

/*
 * * azure project presents:
                                          _
                                         | |
 __,   __          ,_    _             _ | |
/  |  / / _|   |  /  |  |/    |  |  |_|/ |/ \_
\_/|_/ /_/  \_/|_/   |_/|__/   \/ \/  |__/\_/
        /|
        \|
				azure web
				version: 1.0a
				azure team
 * * be carefully.
 */

namespace Azure\Mappers;

use Azure\Database\Adapter;
use Azure\Models\User as Model;
use Azure\View\Data;
use Azure\View\Mailer;
use Azure\View\Misc;

/**
 * Class User
 * @package Azure\Mappers
 */
class User extends Model
{
    /**
     * function register user
     * register and store an user in the database
     * @param array $array [username,password]
     * @param bool $added_avatar
     * @return null|void
     */
    static function register_user($array = [], $added_avatar = false)
    {
        if ($added_avatar):
            $fetch = Adapter::fetch_object(Adapter::secure_query('SELECT * FROM users WHERE mail = :usermail', [':usermail' => Data::$user_instance->user_email]));

            Adapter::insert_array('users', ['account_created' => time(), 'username' => $array['name'], 'novato' => 1, 'mail' => $fetch->mail, 'password' => $fetch->password]);
            Data::user_create_instance($array['name']);

            return null;
        endif;

        if ((strlen($array['password']) >= 5 && strlen($array['password']) <= 30) && preg_match('`[a-z]`', $array['password']) && preg_match('`[0-9]`', $array['password']) && (substr_count($array['password'], ' ') == 0)):
            if (Adapter::row_count(Adapter::secure_query("SELECT * FROM cms_azure_id WHERE mail = :email LIMIT 1", [':email' => $array['email']])) == 0):
                Adapter::insert_array('cms_azure_id', ['mail' => $array['email']]);
                Adapter::insert_array('users', ['account_created' => time(), 'username' => $array['username'], 'novato' => 1, 'mail' => $array['email'], 'password' => password_hash($array['password'], PASSWORD_BCRYPT)]);

                Mailer::send_nux_mail($array['email']);

                self::user_login($array['username'], $array['password'], 1);

                return;
            else:
                header('HTTP/1.1 409 Conflict');
                echo '{"error":"registration_email_in_use"}';
                return null;
            endif;
        else:
            header('HTTP/1.1 400 Bad Request');
            echo '{"error":"registration_email_in_use"}';
            return null;
        endif;
    }

    /**
     * function user_login
     * create a instance of the user and log-in
     * @param $user_name
     * @param $pass_word
     * @param int $newbie
     */
    static function user_login($user_name, $pass_word, $newbie = 0)
    {
        if (!Data::check_if_user_exists()):
            if (($rok = Adapter::fetch_object(Adapter::secure_query("SELECT * FROM users WHERE mail = :mail OR username = :mail LIMIT 1", [':mail' => $user_name]))) != null):
                if ((password_verify($pass_word, $rok->password) == true) || ($newbie == 1)):

                    $query = EMULATOR_TYPE == 'plus' ?
                        Adapter::secure_query("SELECT * FROM bans WHERE `value` = :username LIMIT 1;", [':username' => $rok->username]) :
                        Adapter::secure_query("SELECT * FROM bans WHERE user_id = :userid LIMIT 1;", [':userid' => $rok->id]);

                    if (Adapter::row_count($query) == 0):

                        Data::user_create_instance($rok->id);

                        $verified_email = Adapter::row_count(Adapter::secure_query("SELECT * FROM cms_users_verification WHERE user_id = :userid AND verified = 'true'", [':userid' => $rok->id])) == 1 ? 'true' : 'false';

                        if (($newbie == 1) && ($rok->novato == 1)):
                            $_SESSION['is_newbie'] = true;
                            header('HTTP/1.1 201 Created');
                            echo '{"uniqueId":"' . $rok->id . '","name":"' . $rok->username . '","figureString":"' . $rok->look . '","selectedBadges":[],"motto":"","memberSince":"' . (date('Y-m-d', $rok->account_created) . 'T' . date('H:i:s', $rok->account_created)) . '.000+0000","profileVisible":true,"sessionLogId":' . $rok->id . ',"loginLogId":' . $rok->id . ',"email":"' . $rok->mail . '","identityId":' . $rok->id . ',"emailVerified":' . $verified_email . ',"trusted":true,"accountId":' . $rok->id . ',"traits":"NEW_USER,USER"}';
                            return;
                        elseif (($newbie == 0) && ($rok->novato == 1)):
                            $_SESSION['is_newbie'] = true;
                            header('HTTP/1.1 200 OK');
                            echo '{"uniqueId":"' . $rok->id . '","name":"' . $rok->username . '","figureString":"' . $rok->look . '","selectedBadges":[],"motto":"","memberSince":"' . (date('Y-m-d', $rok->account_created) . 'T' . date('H:i:s', $rok->account_created)) . '.000+0000","profileVisible":true,"sessionLogId":' . $rok->id . ',"loginLogId":' . $rok->id . ',"email":"' . $rok->mail . '","identityId":' . $rok->id . ',"emailVerified":' . $verified_email . ',"trusted":true,"accountId":' . $rok->id . ',"traits":"USER"}';
                            return;
                        else:
                            header('HTTP/1.1 200 OK');
                            echo '{"uniqueId":"' . $rok->id . '","name":"' . $rok->username . '","figureString":"' . $rok->look . '","selectedBadges":[],"motto":"","memberSince":"' . (date('Y-m-d', $rok->account_created) . 'T' . date('H:i:s', $rok->account_created)) . '.000+0000","profileVisible":true,"sessionLogId":' . $rok->id . ',"loginLogId":' . $rok->id . ',"email":"' . $rok->mail . '","identityId":' . $rok->id . ',"emailVerified":' . $verified_email . ',"trusted":true,"accountId":' . $rok->id . ',"traits":"USER"}';
                            return;
                        endif;
                    endif;
                endif;
            endif;
        endif;
	    
        header('HTTP/1.1 401 Unauthorized');
        echo '{"message":"login.invalid_password"}';
        return;
    }

    static function check_banned_account()
    {
        if ((Adapter::get_instance() != null) && (Data::check_if_user_exists()) && (INSTALLED)):

            $query = EMULATOR_TYPE == 'plus' ?
                Adapter::secure_query("SELECT * FROM bans WHERE `value` = :username LIMIT 1;", [':username' => Data::$user_instance->username]) :
                Adapter::secure_query("SELECT * FROM bans WHERE userid = :userid LIMIT 1;", [':userid' => Data::$user_instance->id]);

            if (Adapter::row_count($query) == 1):
                session_destroy();
                header("Location: /api/public/authentication/logout");
            endif;
        endif;
    }

    /**
     * function generate_newbie_username
     * create a newbie username
     * @param string $mail
     * @return string
     */
    static function generate_newbie_username($mail = '')
    {
        $email = explode('@', $mail);
        $mail = $email[0];

        restart:
        $username = '';
        $username .= self::symbols(rand(0, 9));
        $username .= self::symbols(rand(0, 9));

        if (sizeof($mail) > 10)
            $mail = substr($mail, 0, 10);

        $username .= $mail;

        $username .= self::symbols(rand(0, 9));
        $username .= self::symbols(rand(0, 9));

        if (Adapter::row_count(Adapter::secure_query("SELECT * FROM users WHERE username = :username LIMIT 1", [':username' => $username])) == 0) return $username;
        goto restart;
    }

    /**
     * function symbols
     * create symbols names
     * @param int $rand
     * @return string
     */
    private static function symbols($rand = 1)
    {
        switch ($rand):
            case 1:
                return '!';
            case 2:
                return '@';
            case 3:
                return '#';
            case 4:
                return '_';
            case 5:
                return '-';
            case 6:
                return '=';
            case 7:
                return '.';
            case 8:
                return '<';
            case 9:
                return '>';
            default:
                return '*';
        endswitch;
    }

    /**
     * function generate_ticket
     * generate a client ticket.
     * @return string
     */
    static function generate_ticket()
    {
        Adapter::secure_query("UPDATE users SET auth_ticket = :ticket WHERE id = :id", [':ticket' => ($ticket = User::client_ticket()), ':id' => Data::$user_instance->user_id]);
        return $ticket;
    }

    /**
     * function change mail
     * chgange the email
     * @param array $data
     * @param int $user_id
     * @return bool
     */
    static function change_email($data = [], $user_id = 0)
    {
        if (self::change_password($data, $user_id, true, false) == true):
            $query_two = Adapter::secure_query("SELECT * FROM users WHERE `mail` = :mail LIMIT 1", [':mail' => Misc::escape_text($data['newEmail'])]);
            if (Adapter::row_count($query_two) == 0):
                $row_two = Adapter::fetch_array(Adapter::secure_query('SELECT * FROM users WHERE id = :userid', [':userid' => $user_id]));
                Mailer::send_change_email($row_two['mail'], $data['newEmail']);
                Adapter::secure_query("UPDATE cms_azure_id SET `mail` = :newmail WHERE `mail` = :oldmail", [':newmail' => Misc::escape_text($data['newEmail']), ':oldmail' => $row_two['mail']]);
                Adapter::secure_query("UPDATE users SET `mail` = :newmail WHERE `mail` = :oldmail", [':newmail' => Misc::escape_text($data['newEmail']), ':oldmail' => $row_two['mail']]);
                header('HTTP/1.1 204 No Content');
                echo '{"email":"' . (Misc::escape_text($data['newEmail'])) . '"}';
                return true;
            endif;
        endif;
        header('HTTP/1.1 400 Bad Request');
        echo '{"error":"registration_email"}';
        return false;
    }

    /**
     * function change password
     * change user password
     * @param array $data
     * @param int $user_id
     * @param bool $need_verify
     * @param bool $update_in_db
     * @return null
     */
    static function change_password($data = [], $user_id = 0, $need_verify = true, $update_in_db = true)
    {
        $query = Adapter::secure_query("SELECT * FROM users WHERE id = :userid  LIMIT 1", [':userid' => $user_id]);
        if (Adapter::row_count($query) == 1):
            $l = Adapter::fetch_object($query);
            if ((password_verify($data['currentPassword'], $l->password)) || (!$need_verify)):
                if ($update_in_db)
                    if ($need_verify)
                        Adapter::secure_query("UPDATE users SET password = :newpass WHERE id = :userid AND password = :password", [':newpass' => password_hash(Misc::escape_text($data['password']), PASSWORD_BCRYPT), ':userid' => Data::$user_instance->user_id, ':password' => password_hash(Misc::escape_text($data['currentPassword']), PASSWORD_BCRYPT)]);
                    else
                        Adapter::secure_query("UPDATE users SET password = :newpass WHERE id = :userid", [':newpass' => password_hash(Misc::escape_text($data['password']), PASSWORD_BCRYPT), ':userid' => Data::$user_instance->user_id]);
                header('HTTP/1.1 204 No Content');
                return true;
            endif;
        endif;
        header('HTTP/1.1 409 Conflict');
        return false;
    }

    /**
     * function get_user_data
     * return a json of the users
     * @param int $type
     * @param bool $user_name
     * @param bool $is_numeric
     * @return null|string
     */
    function get_user_data($type = 4, $user_name = false, $is_numeric = false)
    {
        if (Data::check_if_user_exists()):
            if ($user_name)
                Data::user_create_instance($user_name, true);
            switch ($type):
                case 4:
                case 3:
                    return Data::$user_instance->user_json->get_json();
                case 2:
                    return '{"user":' . (Data::$user_instance->user_json->get_json()) . ',"friends":' . json_encode(Data::$user_instance->user_friends) . ',"groups":' . json_encode(Data::$user_instance->user_groups) . ',"rooms":' . json_encode(Data::$user_instance->user_rooms) . ',"badges":' . json_encode(Data::$user_instance->user_badges) . '}';
            endswitch;
        endif;
        return null;
    }
}
