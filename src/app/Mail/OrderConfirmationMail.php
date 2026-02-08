<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

/**
 * 購入者向け注文確認メール
 */
final class OrderConfirmationMail extends Mailable
{
    use Queueable;
    use SerializesModels;

    public function __construct(
        public readonly Order $order
    ) {}

    /**
     * メールの件名と送信元を定義
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "【desikau】ご注文ありがとうございます（注文番号: {$this->order->order_number}）",
        );
    }

    /**
     * メールの本文を定義
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.order-confirmation',
            with: [
                'order' => $this->order,
                'items' => $this->order->items,
            ],
        );
    }
}
