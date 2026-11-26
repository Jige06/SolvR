<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

/**
 * Contenu de l'e-mail de contact : objet, version HTML, version texte.
 * Le point essentiel : rien de ce que tape le visiteur ne devient du HTML dans le mail.
 */
final class ContactEmailTest extends TestCase
{
    private const VALID = [
        'name'    => 'Pierre Durand',
        'email'   => 'pierre.durand@exemple.fr',
        'phone'   => '06 12 34 56 78',
        'type'    => 'vitrine',
        'message' => 'Bonjour, je voudrais un site vitrine pour mon entreprise.',
    ];

    private function email(array $input = []): ContactEmail
    {
        $form = new ContactForm($input + self::VALID);

        return new ContactEmail($form, new DateTimeImmutable('2026-11-26 19:52', new DateTimeZone('Europe/Paris')));
    }

    public function testSubjectNamesVisitorAndProject(): void
    {
        $this->assertSame('Nouvelle demande : Pierre Durand (Site vitrine)', $this->email()->subject());
    }

    public function testSubjectWithoutProjectTypeHasNoParentheses(): void
    {
        $this->assertSame('Nouvelle demande : Pierre Durand', $this->email(['type' => ''])->subject());
    }

    public function testHtmlEscapesVisitorInput(): void
    {
        $html = $this->email([
            'name'    => '<script>alert(1)</script>',
            'message' => 'Un lien <a href="https://piege.example">ici</a> & des "guillemets"',
        ])->html();

        $this->assertStringNotContainsString('<script>', $html);
        $this->assertStringNotContainsString('href="https://piege.example"', $html);
        $this->assertStringContainsString('&lt;script&gt;alert(1)&lt;/script&gt;', $html);
        $this->assertStringContainsString('&amp; des &quot;guillemets&quot;', $html);
    }

    public function testHtmlKeepsLineBreaksOfMessage(): void
    {
        $html = $this->email(['message' => "Première ligne\nDeuxième ligne"])->html();

        $this->assertStringContainsString("Première ligne<br>\nDeuxième ligne", $html);
    }

    public function testHtmlLinksToReplyAndCall(): void
    {
        $html = $this->email()->html();

        $this->assertStringContainsString('href="mailto:pierre.durand@exemple.fr?subject=', $html);
        $this->assertStringContainsString('href="tel:0612345678"', $html);
    }

    public function testNoCallButtonWithoutPhone(): void
    {
        $html = $this->email(['phone' => ''])->html();

        $this->assertStringNotContainsString('tel:', $html);
        $this->assertStringContainsString('Non renseigné', $html);
    }

    public function testTextVersionContainsEverything(): void
    {
        $text = $this->email()->text();

        $expected = [
            'Pierre Durand',
            'pierre.durand@exemple.fr',
            '06 12 34 56 78',
            'Site vitrine',
            'site vitrine pour mon entreprise',
            '26/11/2026 à 19:52',
        ];

        foreach ($expected as $part) {
            $this->assertStringContainsString($part, $text);
        }
    }
}
