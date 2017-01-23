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

namespace Azure\View;

use Azure\Database\Adapter;
use Azure\Mappers\System;
use Azure\Mappers\User;
use Azure\Models\Json\Badge as JsonBadge;
use Azure\Models\Json\Friend as JsonFriend;
use Azure\Models\Json\Group as JsonGroup;
use Azure\Models\Json\Preferences as JsonPreferences;
use Azure\Models\Json\Room as JsonRoom;
use Azure\Models\Json\UsedBadges as JsonUsedBadge;
use Azure\Models\Json\User as JsonUser;
use stdClass;

/**
 * Class Data
 * Control the Data of the Page
 * @package Azure\View
 */
final class Data
{
    /**
     * @var $user_instance
     * @var $system_instance
     * @var $need_database
     */
    public static $user_instance, $system_instance, $need_database;

    /**
     * @var $framework_instance
     */
    private static $framework_instance;

    /**
     * function system_create_instance
     * create instance of system data
     * @param string $server_lang
     * @return mixed
     */
    static function system_create_instance($server_lang = 'en')
    {
        // Sadly we don't have some alternatives for Arcturus. So we will need to ignore errors.
        if (!self::check_if_system_exists()):
            $row_one = Adapter::fetch_object(Adapter::query("SELECT users_online,server_ver,users_online,rooms_loaded,stamp FROM server_status"));
            $row_two = Adapter::row_count(Adapter::query("SELECT id FROM users"));
            $row_three = Adapter::row_count(Adapter::query("SELECT id FROM rooms"));
            $row_four = Adapter::row_count(EMULATOR_TYPE == 'plus' ? Adapter::query("SELECT id FROM groups") : Adapter::query("SELECT id FROM guilds"));
            $row_fifth = Adapter::row_count(Adapter::query("SELECT id FROM items"));
            $row_sixth = Adapter::row_count(Adapter::query("SELECT id FROM bans"));
            $row_seventh = Adapter::row_count(Adapter::query("SELECT id FROM server_stafflogs"));

            self::$system_instance = new System($server_lang, (($row_one->users_online == 0) ? 0 : $row_one->users_online), $row_one->server_ver, $row_one->rooms_loaded, $row_one->stamp, $row_two, $row_three, $row_four, $row_fifth, $row_sixth, $row_seventh);

            $_SESSION['hotel_data'] = serialize(self::$system_instance);

            return self::$system_instance;
        endif;

        return null;
    }

    /**
     * function check_if_system_exists
     * check if exists serialized data of system data
     * if exists return and store data locally
     * @return bool
     */
    static function check_if_system_exists()
    {
        self::$system_instance = (!empty($_SESSION['hotel_data'])) ? unserialize($_SESSION['hotel_data']) : null;
        return (!empty($_SESSION['hotel_data'])) ? true : false;
    }

    /**
     * function framework_instance
     * save a serialized of Framework
     * @param bool $return
     * @param null $sys
     * @return null
     */
    static function framework_instance($return = false, $sys = null)
    {
        if (is_null(self::$framework_instance))
            self::save_framework_instance($sys);
        if ($return)
            return self::get_framework_instance();
        return null;
    }

    /**
     * function save_framework_instance
     * save a serialized of Framework
     * @param null $sys
     */
    private static function save_framework_instance($sys = null)
    {
        if (!is_null($sys)) self::$framework_instance = $sys;
    }

    /**
     * function get_framework_instance
     * return serialized framework instance
     * @return null
     */
    private static function get_framework_instance()
    {
        if (!is_null(self::$framework_instance))
            return self::$framework_instance;
        return null;
    }

    /**
     * function user_create_instance
     * create instance and get data of a user
     * @param $user_id
     * @param bool $return
     * @return User
     */
    static function user_create_instance($user_id, $return = false)
    {
        $row = (((is_numeric($user_id))) ? Adapter::fetch_object(Adapter::secure_query("SELECT * FROM users WHERE id = :userid LIMIT 1", [':userid' => $user_id])) : Adapter::fetch_object(Adapter::secure_query("SELECT * FROM users WHERE username = :userid LIMIT 1", [':userid' => $user_id])));

        $verified = Adapter::fetch_array(Adapter::secure_query('SELECT verified FROM cms_users_verification WHERE user_id = :userid', [':userid' => $row->id]));
        $new_verify = $verified['verified'];

        if (($new_verify != 'false') && ($new_verify != 'true')):
            Mailer::send_nux_mail($row->mail);
            $new_verify = 'false';
        endif;

        $is_admin = ($row->rank >= 7) ? true : false;

        $pref = new JsonPreferences(true, $row->hide_online, $row->hide_inroom, $row->block_newfriends);
        $user_preferences = json_decode($pref->get_json());

        $count = 0;
        $badge = [];
        foreach (Adapter::secure_query(EMULATOR_TYPE == 'plus' ? "SELECT * FROM user_badges WHERE user_id = :userid" : "SELECT * FROM users_badges WHERE user_id = :userid", [':userid' => $row->id]) as $row_a):
            $f = new JsonBadge($row_a['badge_id'], $row_a['badge_id'], $row_a['badge_id']);
            $badge[$count] = json_decode($f->get_json());

            if (!empty($badge[$count]))
                $count++;
            else
                unset($badge[$count]);
        endforeach;

        $count = 0;
        $badge_used = [];
        foreach (Adapter::secure_query(EMULATOR_TYPE == 'plus' ? "SELECT * FROM user_badges WHERE user_id = :userid AND badge_slot != 0" : "SELECT * FROM users_badges WHERE user_id = :userid AND slot_id != 0", [':userid' => $row->id]) as $row_a):
            $f = new JsonUsedBadge($row_a['badge_slot'], $row_a['badge_id'], $row_a['badge_id'], $row_a['badge_id']);
            $badge_used[$count] = json_decode($f->get_json());

            if (!empty($badge_used[$count]))
                $count++;
            else
                unset($badge_used[$count]);
        endforeach;

        $count = 0;
        $user_friends = [];
        foreach (Adapter::secure_query("SELECT user_two_id FROM messenger_friendships WHERE user_one_id = :userid", [':userid' => $row->id]) as $row_a):
            $row_b = Adapter::fetch_object(Adapter::secure_query("SELECT username,motto,id,look FROM users WHERE id = :userid LIMIT 1", [':userid' => $row_a['user_two_id']]));
            $f = new JsonFriend($row_b->username, $row_b->motto, $row_b->id, $row_b->look);
            $user_friends[$count] = json_decode($f->get_json());

            if (!empty($user_friends[$count]))
                $count++;
            else
                unset($user_friends[$count]);
        endforeach;

        $count = 0;
        $user_rooms = [];
        foreach (Adapter::secure_query(EMULATOR_TYPE == 'plus' ? "SELECT * FROM rooms WHERE owner = :userid" : "SELECT * FROM rooms WHERE owner_id = :userid", [':userid' => $row->id]) as $row_a):
            $f = new JsonRoom($row_a['id'], $row_a['caption'], $row_a['description'], $row->id);
            $user_rooms[$count] = json_decode($f->get_json());

            if (!empty($user_rooms[$count]))
                $count++;
            else
                unset($user_rooms[$count]);
        endforeach;

        $count = 0;
        $user_groups = [];
        foreach (Adapter::secure_query(EMULATOR_TYPE == 'plus' ? "SELECT * FROM group_memberships WHERE user_id = :userid" : "SELECT * FROM guilds_members WHERE user_id = :userid", [':userid' => $row->id]) as $row_a):

            if (EMULATOR_TYPE == 'plus'):
                $row_b = Adapter::fetch_object(Adapter::secure_query("SELECT * FROM groups WHERE id = :userid LIMIT 1", [':userid' => $row_a['group_id']]));

                $f = new JsonGroup($row_a['group_id'], $row_b->name, $row_b->desc, 'NORMAL', $row_b->badge, $row_b->room_id, $row_b->colour1, $row_b->colour2, false);
            else:
                $row_b = Adapter::fetch_object(Adapter::secure_query("SELECT * FROM guilds WHERE id = :userid LIMIT 1", [':userid' => $row_a['group_id']]));

                $f = new JsonGroup($row_a['group_id'], $row_b->name, $row_b->description, 'NORMAL', $row_b->badge, $row_b->room_id, $row_b->color_one, $row_b->color_two, false);
            endif;

            $user_groups[$count] = json_decode($f->get_json());

            if (!empty($user_groups[$count]))
                $count++;
            else
                unset($user_groups[$count]);
        endforeach;

        $user_json = new JsonUser($row->id, $row->username, $row->mail, $row->gender, $row->motto, $row->look, $badge_used, date('Y-m-d', $row->account_created) . 'T' . date('H:i:s', $row->account_created) . '.000+0000', $new_verify);
        self::$user_instance = new User($user_id, $row->username, $row->mail, $row->gender, $row->motto, $row->credits, $row->activity_points, "127.0.0.1", "Default", $row->look, $is_admin, $row->builders_expire, $badge, $user_friends, $user_rooms, $badge_used, $user_groups, $user_json, $user_preferences, $new_verify, $row->novato);

        if ($return)
            return self::$user_instance;

        $_SESSION['user_data'] = serialize(self::$user_instance);

        return null;
    }

    /**
     * function check_if_user_exists
     * check existence of the serialized class
     * and store on local class
     * @return bool
     */
    static function check_if_user_exists()
    {
        self::$user_instance = (!empty($_SESSION['user_data'])) ? unserialize($_SESSION['user_data']) : null;
        return (!empty($_SESSION['user_data'])) ? true : false;
    }

    /**
     * function compose_news
     * get articles ;)
     * @param bool $return
     * @param bool $article_id
     * @return null|string
     */
    static function compose_news($return = false, $article_id = false)
    {
        if (!$article_id):
            $count = 0;
            $code = [];
            foreach (Adapter::query("SELECT * FROM cms_articles WHERE `type` = 'article' ORDER BY id ASC") as $row):
                $code[$count] = new stdClass();
                $code[$count]->title = $row['title'];
                $code[$count]->body = html_entity_decode(strip_tags(substr(str_replace(['\r', '\n', '\\'], '', $row['text']), 0, 200)));
                $code[$count]->articleIndex = 0;
                $code[$count]->linkUrl = ($row['external_link'] != 'default') ? $row['external_link'] : "/news/{$row['internal_link']}";
                $code[$count]->linkLabel = $row['link_text'];
                $code[$count]->imageUrl = $row['image'];
                $code[$count]->start = null;
                $count++;
            endforeach;
            return (($return) ? json_encode($code) : null);
        else:
            $article_id = str_replace('_', '-', $article_id);
            if (Adapter::row_count(Adapter::secure_query("SELECT * FROM cms_articles WHERE internal_link = :article_url", [':article_url' => $article_id])) == 1):
                $row = Adapter::fetch_object(Adapter::secure_query("SELECT * FROM cms_articles WHERE internal_link = :article_url", [':article_url' => $article_id]));
            else:
                $row = Adapter::fetch_object(Adapter::query("SELECT * FROM cms_articles WHERE `type` = 'article' ORDER BY id ASC LIMIT 1"));
            endif;
            if ($row->type == 'article'):
                $text = str_replace(['\r', '\n', '\\'], '', $row->text);
                $code = "<h1>{$row->title}</h1>";
                $code = $code . "<p>{$text}</p>";
                $code = $code . '<blockquote><p>See more news on the <a href="/">Home page</a>!</p></blockquote>';
            else:
                $code = $row->text;
            endif;
            return ($return) ? $code : null;
        endif;
    }

    /**
     * function compose_campaigns
     * get campaigns (minimail)
     * @param bool $return
     * @return null|string
     */
    static function compose_campaigns($return = false)
    {
        $count = 0;
        $code = [];
        foreach (Adapter::query('SELECT id,title,text,external_link FROM cms_campaigns ORDER BY id ASC') as $row):
            $code[$count] = new stdClass();
            $code[$count]->id = $row['id'];
            $code[$count]->type = 1;
            $code[$count]->active = true;
            $code[$count]->archived = false;
            $code[$count]->welcomeMessage = false;
            $code[$count]->name = $row['title'];
            $code[$count]->message = str_replace(['\r', '\n', '\\'], '', $row['text']);
            $code[$count]->linkUrl = $row['external_link'];
            $code[$count]->linkText = "Check more visiting the url";
            $code[$count]->startTime = "2000-03-16T06:34:16.000+0000";
            $code[$count]->endTime = "2400-03-16T06:34:16.000+0000";
            $code[$count]->targets = [];
            $count++;
        endforeach;
        return (($return) ? json_encode($code) : null);
    }

    /**
     * function database_is_available
     * check if database is turned on yea modafucka
     * @param int $is_set
     * @return bool
     */
    static function database_is_available($is_set = 0)
    {
        return ($is_set == 1) ? ((Adapter::get_instance() != null) ? true : ((self::$need_database == true) ? true : false)) : false;
    }
}