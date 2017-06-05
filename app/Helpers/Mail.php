<?php

namespace App\Helpers;

use App\Models\Mail as MailModel;
use App\Singleton;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Mail as MailFacade;

/**
 * Class Mail.
 */
final class Mail extends Singleton
{
    /**
     * Stored Mail Model.
     *
     * @var MailModel
     */
    protected $mailModel;

    /**
     * Send an Email.
     *
     * @param array  $configuration
     * @param string $view
     */
    public function send(array $configuration, string $view = 'habbo-web-mail.confirm-mail')
    {
        if (Config::get('mail.enable')) {
            MailFacade::send($view, $configuration, function ($message) use ($configuration) {
                $message->from(Config::get('mail.from.address'), Config::get('mail.from.name'));
                $message->to($configuration['email'])->subject($configuration['subject']);
            });
        }
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
        (new MailModel())->store($token = uniqid('HabboMail', true), $url, $email);

        return $token;
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
        return $this->get($token) !== null;
    }

    /**
     * Get an E-mail by Token.
     *
     * @param string $token
     *
     * @return MailModel
     */
    public function get(string $token = '')
    {
        if ($this->mailModel == null && !empty($token)) {
            $mailModel = MailModel::where('token', $token)->where('used', '0')->first();

            if ($mailModel !== null) {
                if (strtotime($mailModel->created_at) + (Config::get('mail.expire') * 24 * 60 * 60) >= time()) {
                    $this->set($mailModel);

                    $this->update(['used' => '1']);
                }
            }
        }

        return $this->mailModel;
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

    /**
     * Update Mail Model Data.
     *
     * @param array $parameters
     *
     * @return MailModel
     */
    public function update(array $parameters)
    {
        $this->mailModel->update($parameters);

        return $this->mailModel;
    }
}
