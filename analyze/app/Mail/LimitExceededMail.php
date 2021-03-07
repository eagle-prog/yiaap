<?php

namespace App\Mail;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class LimitExceededMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $this->subject(formatTitle([__('Account limit exceeded'), config('settings.title')]));

        return $this->markdown('emails.limit', [
            'level' => null,
            'introLines' => [__('Your account has exceeded the Pageviews limit.') . ' ' . __('If you wish to continue tracking your visitors, upgrade your account.')],
            'actionText' => __('Upgrade'),
            'actionUrl' => route('pricing')
        ]);
    }
}
