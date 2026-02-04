<?php

namespace App\Actions\User;

use App\Services\StripeService;

/**
 * Stripe Webhook処理アクション
 */
final class HandleWebhookAction
{
    public function __construct(
        private readonly StripeService $stripeService
    ) {}

    /**
     * Webhookを処理
     *
     * @return bool 処理成功ならtrue
     */
    public function execute(string $payload, string $signature): bool
    {
        return (bool) $this->stripeService->handleWebhook($payload, $signature);
    }
}
