<?php

namespace App\Mail;

use App\Models\Order;
use App\Models\Seller;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;

/**
 * 出品者向け新規注文通知メール
 */
final class OrderNotificationMail extends Mailable
{
    use Queueable;
    use SerializesModels;

    /**
     * @param Order $order 注文情報
     * @param Seller $seller 出品者情報
     * @param Collection $sellerItems 該当出品者の注文アイテム
     */
    public function __construct(
        public readonly Order $order,
        public readonly Seller $seller,
        public readonly Collection $sellerItems
    ) {}

    /**
     * メールの件名と送信元を定義
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "【desikau】新しい注文が入りました（注文番号: {$this->order->order_number}）",
        );
    }

    /**
     * メールの本文を定義
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.order-notification',
            with: [
                'order' => $this->order,
                'seller' => $this->seller,
                'sellerItems' => $this->sellerItems,
            ],
        );
    }
}
