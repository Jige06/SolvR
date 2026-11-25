<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

/**
 * Limitation des envois : piège temporel, délai entre deux envois, quota horaire.
 * Une fausse horloge permet de simuler le temps qui passe sans attendre.
 */
final class SubmissionLimiterTest extends TestCase
{
    private int $now = 1_000_000;
    private SubmissionLimiter $limiter;

    protected function setUp(): void
    {
        $_SESSION = [];
        $this->limiter = new SubmissionLimiter(fn(): int => $this->now);
    }

    private function wait(int $seconds): void
    {
        $this->now += $seconds;
    }

    public function testSubmissionRightAfterDisplayIsTooFast(): void
    {
        $this->limiter->markFormDisplayed();
        $this->wait(1);

        $this->assertTrue($this->limiter->isTooFast());
    }

    public function testSubmissionAfterMinFillTimeIsNotTooFast(): void
    {
        $this->limiter->markFormDisplayed();
        $this->wait(SubmissionLimiter::MIN_FILL_TIME);

        $this->assertFalse($this->limiter->isTooFast());
    }

    public function testUnknownDisplayTimeIsNotTooFast(): void
    {
        // Session ouverte avant la mise en place de la protection : on laisse passer
        $this->assertFalse($this->limiter->isTooFast());
    }

    public function testFirstSendIsAllowed(): void
    {
        $this->assertTrue($this->limiter->canSend());
    }

    public function testSecondSendTooSoonIsRefused(): void
    {
        $this->limiter->recordSend();
        $this->wait(SubmissionLimiter::MIN_INTERVAL - 1);

        $this->assertFalse($this->limiter->canSend());
    }

    public function testSecondSendAfterIntervalIsAllowed(): void
    {
        $this->limiter->recordSend();
        $this->wait(SubmissionLimiter::MIN_INTERVAL);

        $this->assertTrue($this->limiter->canSend());
    }

    public function testHourlyQuotaIsEnforced(): void
    {
        for ($i = 0; $i < SubmissionLimiter::MAX_PER_HOUR; $i++) {
            $this->assertTrue($this->limiter->canSend(), "L'envoi n° " . ($i + 1) . ' doit être autorisé');
            $this->limiter->recordSend();
            $this->wait(60);
        }

        $this->assertFalse($this->limiter->canSend(), 'Le quota horaire est atteint');
    }

    public function testQuotaIsFreedAfterAnHour(): void
    {
        for ($i = 0; $i < SubmissionLimiter::MAX_PER_HOUR; $i++) {
            $this->limiter->recordSend();
            $this->wait(60);
        }

        $this->wait(3600);

        $this->assertTrue($this->limiter->canSend());
    }
}
