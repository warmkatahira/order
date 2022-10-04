<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ShippingActualMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($order_info)
    {
        $this->order_info = $order_info;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $to = array('t.katahira@warm.co.jp');
        return $this->to($to)
            ->subject('≪自動配信≫≪発注システム≫出荷完了通知')
            ->view('mail.shipping_actual_mail')
            ->with([
                'order_info' => $this->order_info,
            ]);
    }
}
