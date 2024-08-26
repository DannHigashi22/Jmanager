<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AuditReport extends Mailable
{
    use Queueable, SerializesModels;

    public $chartErrors;
    public $chartUsers;
    public $chartType;
    public $auditsMonth;
    public $auditsDay;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($chartErrors, $chartUsers, $chartType,$auditsMonth, $auditsDay)
    {
        $this->chartErrors=$chartErrors;
        $this->chartUsers=$chartUsers;
        $this->chartType=$chartType;
        $this->auditsMonth=$auditsMonth;
        $this->auditsDay=$auditsDay;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Reporte Pedidos J411')->view('emails.report');
    }
}
