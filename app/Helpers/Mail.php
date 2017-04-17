<?php

namespace App\Helpers;

use App\Models\Mail as MailModel;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Mail as MailFacade;

/**
 * Class Mail.
 */
final class Mail
{
    /**
     * Stored Mail Model.
     *
     * @var MailModel|null
     */
    protected $mailModel = null;

    /**
     * Quick Way to get Cached MailModel.
     *
     * @return MailModel|null
     */
    public function getMail()
    {
        return self::getInstance()->get();
    }

    /**
     * Return cached Mail Model.
     *
     * @return MailModel|null
     */
    public function get()
    {
        return $this->mailModel;
    }

    /**
     * Create and return a Mail instance.
     *
     * @return Mail
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
     * Send an Email.
     *
     * @param array  $configuration
     * @param string $view
     */
    public function send(array $configuration, string $view = 'habbo-web-mail.confirm-mail')
    {
        if (Config::get('mail.enable') == false) {
            return;
        }

        MailFacade::send($view, $configuration, function ($message) use ($configuration) {
            $message->from(Config::get('mail.from.address'), Config::get('mail.from.name'));
            $message->to($configuration['email'])->subject($configuration['subject']);
        });
    }

    /**
     * Store an E-mail.
     *
     * @param string $email
     * @param string $url
     *
     * @return string
     */
    public function store(string $email, string $url): string
    {
        (new MailModel)->store($token = uniqid('HabboMail', true), $url, $email);

        return $token;
    }

    /**
     * Update Mail Model Data.
     *
     * @param string $token
     * @param array  $parameters
     *
     * @return MailModel
     */
    public function update(string $token, array $parameters)
    {
        $mail = $this->get($token);

        $mail->update($parameters);

        return $mail;
    }

    /**
     * Return if Exists E-Mail with that Token.
     *
     * @param string $token
     *
     * @return bool
     */
    public function has(string $token)
    {
        return self::getInstance()->getByToken($token) !== null;
    }

    /**
     * Get an E-mail by Token.
     *
     * @param string $token
     *
     * @return MailModel
     */
    public function getByToken(string $token)
    {
        $mailRequest = MailModel::where('token', $token)->where('used', '0')->first();

        $mailRequest->update(['used' => '1']);

        return $this->set($mailRequest);
    }

    /**
     * Set Mail Model in Cache.
     *
     * @param MailModel $model
     *
     * @return MailModel
     */
    public function set(MailModel $model)
    {
        return $this->mailModel = $model;
    }
}
