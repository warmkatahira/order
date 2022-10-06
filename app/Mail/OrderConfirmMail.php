<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderConfirmMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($order_id, $shipping_store_name, $delivery_date, $email)
    {
        $this->order_id = $order_id;
        $this->shipping_store_name = $shipping_store_name;
        $this->delivery_date = $delivery_date;
        $this->email = $email;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $to = $this->email;
        return $this->to($to)
            ->subject('≪自動配信≫≪発注システム≫発注通知 発注ID:'.$this->order_id)
            ->view('mail.order_confirm_mail')
            ->with([
                'order_id' => $this->order_id,
                'shipping_store_name' => $this->shipping_store_name,
                'delivery_date' => $this->delivery_date,
            ]);
    }
}
