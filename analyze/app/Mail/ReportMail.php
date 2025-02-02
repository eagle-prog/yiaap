<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ReportMail extends Mailable
{
    use Queueable, SerializesModels;

    private $stats;
    private $range;

    /**
     * Create a new message instance.
     *
     * @param $stats
     * @param $range
     */
    public function __construct($stats, $range)
    {
        $this->stats = $stats;
        $this->range = $range;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $this->subject(formatTitle([__('Periodic report'), config('settings.title')]));

        return $this->markdown('emails.report', [
            'level' => null,
            'introLines' => [__('Your periodic report is ready.')],
            'stats' => $this->stats,
            'range' => $this->range,
        ]);
    }
}
