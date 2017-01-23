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
use PHPMailer;

final class Mailer
{
    static function send_nux_mail($email = null)
    {
        if (Adapter::row_count(Adapter::secure_query('SELECT mail FROM users WHERE mail = :mail', [':mail' => $email])) == 1):

            $mail = new PHPMailer();

            $mail->IsSMTP();
            $mail->CharSet = 'UTF-8';

            $system_settings = unserialize(SYSTEM_SETTINGS);

            $mail->Host = $system_settings['smtp_server'];

            $mail->From = 'contato@eabbu.com';
            $mail->FromName = $system_settings['hotel_name'];

            $mail->AddAddress($email);

            $mail->IsHTML(true);

            $mail->Subject = 'Bem-Vindo ao ' . $system_settings['hotel_name'];
            $mail->Body = Page::include_content('new_account', 'others/mail');

            $get_details = Adapter::fetch_object(Adapter::secure_query('SELECT id,username,mail FROM users WHERE mail = :mail', [':mail' => $email]));

            $mail->Body = str_replace('{{mail_username}}', $get_details->username, $mail->Body);

            $mail->Body = str_replace('{{mail_email}}', $get_details->mail, $mail->Body);

            $hash = md5($get_details->mail . '_' . $get_details->username . '_' . rand(0, 9));

            Adapter::secure_query('INSERT INTO cms_users_verification (user_id,user_hash) VALUES (:userid,:userhash)', [':userid' => $get_details->id, ':userhash' => $hash]);

            $mail->Body = str_replace('{{confirm_url}}', $system_settings['global_url'] . '/activate/' . $hash, $mail->Body);

            $mail->Body = str_replace('{{hotel_name}}', $system_settings['hotel_name'], $mail->Body);

            $mail->Send();

            $mail->ClearAllRecipients();
            $mail->ClearAttachments();
        endif;
    }

    static function send_change_email($email = null, $new_email = null)
    {
        if (Adapter::row_count(Adapter::secure_query('SELECT mail FROM users WHERE mail = :mail', [':mail' => $email])) == 1):

            $mail = new PHPMailer();

            $mail->IsSMTP();
            $mail->CharSet = 'UTF-8';

            $system_settings = unserialize(SYSTEM_SETTINGS);

            $mail->Host = $system_settings['smtp_server'];

            $mail->From = 'contato@eabbu.com';
            $mail->FromName = $system_settings['hotel_name'];

            $mail->AddAddress($email);

            $mail->IsHTML(true);

            $mail->Subject = 'Requisição de Alteração de E-mail';
            $mail->Body = Page::include_content('change_email', 'others/mail');

            $get_details = Adapter::fetch_object(Adapter::secure_query('SELECT id,username,mail FROM users WHERE mail = :mail', [':mail' => $email]));

            $mail->Body = str_replace('{{mail_username}}', $get_details->username, $mail->Body);

            $mail->Body = str_replace('{{mail_email}}', $new_email, $mail->Body);

            $mail->Body = str_replace('{{hotel_name}}', $system_settings['hotel_name'], $mail->Body);

            $mail->Send();

            $mail->ClearAllRecipients();
            $mail->ClearAttachments();
        endif;
    }

    static function send_reset_password($email = null)
    {
        if (Adapter::row_count(Adapter::secure_query('SELECT mail FROM users WHERE mail = :mail', [':mail' => $email])) == 1):

            $mail = new PHPMailer();

            $mail->IsSMTP();
            $mail->CharSet = 'UTF-8';

            $system_settings = unserialize(SYSTEM_SETTINGS);

            $mail->Host = $system_settings['smtp_server'];

            $mail->From = 'contato@eabbu.com';
            $mail->FromName = $system_settings['hotel_name'];

            $mail->AddAddress($email);

            $mail->IsHTML(true);

            $mail->Subject = 'Requisição de Alteração de Senha';
            $mail->Body = Page::include_content('reset_password', 'others/mail');

            $get_details = Adapter::fetch_object(Adapter::secure_query('SELECT id,username,mail FROM users WHERE mail = :mail', [':mail' => $email]));

            $mail->Body = str_replace('{{mail_username}}', $get_details->username, $mail->Body);

            $mail->Body = str_replace('{{mail_email}}', $get_details->mail, $mail->Body);

            $hash = md5($get_details->mail . '_' . $get_details->username . '_' . rand(0, 9));

            Adapter::secure_query('INSERT INTO cms_restore_password (user_id,user_hash) VALUES (:userid,:userhash)', [':userid' => $get_details->id, ':userhash' => $hash]);

            $mail->Body = str_replace('{{confirm_url}}', $system_settings['global_url'] . '/reset-password/' . $hash, $mail->Body);

            $mail->Body = str_replace('{{hotel_name}}', $system_settings['hotel_name'], $mail->Body);

            $mail->Send();

            $mail->ClearAllRecipients();
            $mail->ClearAttachments();
        endif;
    }
}

