<?php

declare(strict_types=1);

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

/**
 * Validation des données du formulaire de contact.
 */
final class ContactFormTest extends TestCase
{
    /** Une saisie correcte, modifiée champ par champ dans les tests */
    private const VALID = [
        'name'    => 'Pierre Durand',
        'email'   => 'pierre.durand@exemple.fr',
        'phone'   => '06 12 34 56 78',
        'type'    => 'vitrine',
        'message' => 'Bonjour, je voudrais un site vitrine pour mon entreprise.',
    ];

    public function testValidDataPasses(): void
    {
        $form = new ContactForm(self::VALID);

        $this->assertTrue($form->validate());
        $this->assertSame([], $form->getErrors());
    }

    public function testOptionalFieldsCanBeEmpty(): void
    {
        $form = new ContactForm(['phone' => '', 'type' => ''] + self::VALID);

        $this->assertTrue($form->validate());
    }

    /** Valeurs refusées : [champ, valeur] */
    public static function invalidValues(): array
    {
        return [
            'nom vide'                  => ['name', ''],
            'nom d\'une lettre'         => ['name', 'A'],
            'nom trop long'              => ['name', str_repeat('a', 101)],
            'nom avec retour à la ligne' => ['name', "Pierre\nDurand"],
            'e-mail vide'                => ['email', ''],
            'e-mail mal formé'           => ['email', 'pierre.durand'],
            'téléphone trop court'       => ['phone', '06 12 34'],
            'téléphone étranger'         => ['phone', '+44 20 7946 0958'],
            'téléphone avec lettres'     => ['phone', '06 12 AB 56 78'],
            'type inconnu'               => ['type', 'piratage'],
            'message vide'               => ['message', ''],
            'message trop court'         => ['message', 'Bonjour'],
            'message trop long'          => ['message', str_repeat('a', 5001)],
        ];
    }

    #[DataProvider('invalidValues')]
    public function testInvalidValueIsRejected(string $field, string $value): void
    {
        $form = new ContactForm([$field => $value] + self::VALID);

        $this->assertFalse($form->validate());
        $this->assertNotNull($form->getError($field));
        $this->assertCount(1, $form->getErrors(), 'Seul le champ modifié doit être en erreur');
    }

    /** Formats de numéros français acceptés */
    public static function validPhones(): array
    {
        return [
            'espaces'             => ['06 12 34 56 78'],
            'collé'               => ['0612345678'],
            'points'              => ['06.12.34.56.78'],
            'tirets'              => ['06-12-34-56-78'],
            'fixe'                => ['04 93 12 34 56'],
            'international'       => ['+33 6 12 34 56 78'],
            'international collé' => ['+33612345678'],
        ];
    }

    #[DataProvider('validPhones')]
    public function testFrenchPhoneFormatsAreAccepted(string $phone): void
    {
        $form = new ContactForm(['phone' => $phone] + self::VALID);

        $this->assertTrue($form->validate());
    }

    public function testInputIsTrimmed(): void
    {
        $form = new ContactForm(['name' => '   Pierre Durand  '] + self::VALID);

        $this->assertSame('Pierre Durand', $form->get('name'));
    }

    public function testNonStringValueBecomesEmpty(): void
    {
        // Un robot peut envoyer name[]=… : PHP reçoit alors un tableau au lieu d'une chaîne
        $form = new ContactForm(['name' => ['Pierre', 'Durand']] + self::VALID);

        $this->assertSame('', $form->get('name'));
        $this->assertFalse($form->validate());
    }

    public function testUnknownFieldsAreIgnored(): void
    {
        $form = new ContactForm(['admin' => '1'] + self::VALID);

        $this->assertSame('', $form->get('admin'));
    }

    public function testProjectTypeLabel(): void
    {
        $this->assertSame('Site vitrine', (new ContactForm(self::VALID))->getProjectTypeLabel());
        $this->assertSame('Non précisé', (new ContactForm(['type' => ''] + self::VALID))->getProjectTypeLabel());
    }
}
