<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

/**
 * Traitement complet d'une requête par le contrôleur de la page Contact,
 * avec un faux expéditeur (aucun e-mail envoyé) et une fausse horloge.
 */
final class ContactControllerTest extends TestCase
{
    private int $now = 1_000_000;
    private FakeMailer $mailer;
    private array $post;

    protected function setUp(): void
    {
        $_SESSION = [];
        $this->mailer = new FakeMailer();
        $this->post = [
            'csrf_token' => CsrfToken::get(),
            'nom'        => 'Pierre Durand',
            'email'      => 'pierre.durand@exemple.fr',
            'message'    => 'Bonjour, je voudrais un site vitrine pour mon entreprise.',
            'site_web'   => '',
        ];
    }

    private function controller(): ContactController
    {
        return new ContactController([], $this->mailer, new SubmissionLimiter(fn(): int => $this->now));
    }

    /** Affiche le formulaire, laisse le temps de le remplir, puis l'envoie */
    private function submit(array $changes = [], int $fillTime = 40): ContactController
    {
        $this->controller()->handle('GET', []);
        $this->now += $fillTime;

        $controller = $this->controller();
        $controller->handle('POST', $changes + $this->post);

        return $controller;
    }

    public function testFirstDisplayHasNoStatus(): void
    {
        $controller = $this->controller();

        $this->assertFalse($controller->handle('GET', []));
        $this->assertNull($controller->getStatus());
    }

    public function testValidSubmissionSendsAndRedirects(): void
    {
        $this->controller()->handle('GET', []);
        $this->now += 40;

        $this->assertTrue($this->controller()->handle('POST', $this->post));
        $this->assertSame(1, $this->mailer->sentCount);
    }

    public function testSuccessMessageIsShownOnlyOnce(): void
    {
        $this->submit();

        $afterRedirect = $this->controller();
        $afterRedirect->handle('GET', []);
        $this->assertSame(ContactStatus::Success, $afterRedirect->getStatus());

        $afterReload = $this->controller();
        $afterReload->handle('GET', []);
        $this->assertNull($afterReload->getStatus());
    }

    public function testInvalidSubmissionKeepsInput(): void
    {
        $controller = $this->submit(['nom' => 'A']);

        $this->assertSame(ContactStatus::Invalid, $controller->getStatus());
        $this->assertSame('pierre.durand@exemple.fr', $controller->getForm()->get('email'));
        $this->assertSame(0, $this->mailer->sentCount);
    }

    public function testInvalidCsrfTokenIsRefused(): void
    {
        $controller = $this->submit(['csrf_token' => 'jeton-forge']);

        $this->assertSame(ContactStatus::Csrf, $controller->getStatus());
        $this->assertSame(0, $this->mailer->sentCount);
    }

    public function testHoneypotFakesSuccessWithoutSending(): void
    {
        $this->controller()->handle('GET', []);
        $this->now += 40;

        $this->assertTrue($this->controller()->handle('POST', ['site_web' => 'http://spam.example'] + $this->post));
        $this->assertSame(0, $this->mailer->sentCount);
    }

    public function testTooFastSubmissionFakesSuccessWithoutSending(): void
    {
        $this->controller()->handle('GET', []);
        $this->now += 1;

        $this->assertTrue($this->controller()->handle('POST', $this->post));
        $this->assertSame(0, $this->mailer->sentCount);
    }

    public function testTooManySubmissionsAreRefused(): void
    {
        $this->submit();
        $controller = $this->submit([], 10);   // 2e envoi moins de 30 s après le 1er

        $this->assertSame(ContactStatus::TooManyRequests, $controller->getStatus());
        $this->assertTrue($controller->getStatus()->isError());
        $this->assertSame(1, $this->mailer->sentCount);
    }

    public function testSmtpFailureIsReportedAndNotCounted(): void
    {
        $this->mailer->failing = true;
        $controller = $this->submit();

        $this->assertSame(ContactStatus::SendError, $controller->getStatus());

        // Le serveur revient : l'envoi suivant n'est pas bloqué par le délai de 30 s
        $this->mailer->failing = false;
        $this->now += 40;
        $this->assertTrue($this->controller()->handle('POST', $this->post));
        $this->assertSame(1, $this->mailer->sentCount);
    }
}
