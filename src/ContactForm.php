<?php
declare(strict_types=1);

/**
 * Formulaire de contact : contient les données saisies et sait les valider.
 */
class ContactForm
{
    /** Types de projet proposés dans la liste déroulante (valeur => libellé) */
    public const PROJECT_TYPES = [
        'vitrine'     => 'Site vitrine',
        'ecommerce'   => 'Site e-commerce',
        'application' => 'Application sur mesure',
        'autre'       => 'Autre / je ne sais pas encore',
    ];

    /** Données du formulaire, initialisées à vide */
    private array $data = [
        'nom'       => '',
        'email'     => '',
        'telephone' => '',
        'type'      => '',
        'message'   => '',
    ];

    /** Erreurs de validation : champ => message */
    private array $errors = [];

    /**
     * @param array $input Les données brutes reçues (en pratique : $_POST)
     */
    public function __construct(array $input = [])
    {
        // On ne garde que les champs attendus, nettoyés des espaces en trop.
        // Une valeur qui n'est pas une chaîne (ex. un tableau envoyé par un robot) devient vide.
        foreach (array_keys($this->data) as $field) {
            $value = $input[$field] ?? '';
            $this->data[$field] = is_string($value) ? trim($value) : '';
        }
    }

    /** Valide toutes les données et retourne true si tout est correct */
    public function validate(): bool
    {
        $this->errors = [];

        // Nom : obligatoire, longueur raisonnable, pas de retour à la ligne
        $nom = $this->data['nom'];
        if ($nom === '') {
            $this->errors['nom'] = 'Indiquez votre nom.';
        } elseif (mb_strlen($nom) < 2 || mb_strlen($nom) > 100) {
            $this->errors['nom'] = 'Votre nom doit contenir entre 2 et 100 caractères.';
        } elseif (preg_match('/[\r\n]/', $nom)) {
            $this->errors['nom'] = 'Votre nom ne doit pas contenir de retour à la ligne.';
        }

        // E-mail : obligatoire et au bon format
        $email = $this->data['email'];
        if ($email === '') {
            $this->errors['email'] = 'Indiquez votre adresse e-mail.';
        } elseif (mb_strlen($email) > 254 || filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
            $this->errors['email'] = 'Indiquez une adresse e-mail valide, par exemple nom@exemple.fr.';
        }

        // Téléphone : facultatif, mais s'il est rempli ce doit être un numéro français
        // (10 chiffres commençant par 0, ou +33 suivi de 9 chiffres ; espaces, points ou tirets acceptés)
        $telephone = $this->data['telephone'];
        if ($telephone !== '' && !preg_match('/^(0|\+33 ?)[1-9]([ .\-]?\d{2}){4}\z/', $telephone)) {
            $this->errors['telephone'] = 'Indiquez un numéro à 10 chiffres, par exemple 06 12 34 56 78.';
        }

        // Type de projet : facultatif, mais doit être une des valeurs proposées
        $type = $this->data['type'];
        if ($type !== '' && !array_key_exists($type, self::PROJECT_TYPES)) {
            $this->errors['type'] = 'Choisissez un type de projet dans la liste.';
        }

        // Message : obligatoire, ni trop court ni trop long
        $message = $this->data['message'];
        if ($message === '') {
            $this->errors['message'] = 'Décrivez votre projet en quelques mots.';
        } elseif (mb_strlen($message) < 10) {
            $this->errors['message'] = 'Votre message doit contenir au moins 10 caractères.';
        } elseif (mb_strlen($message) > 5000) {
            $this->errors['message'] = 'Votre message ne doit pas dépasser 5 000 caractères.';
        }

        return $this->errors === [];
    }

    /** Valeur d'un champ (pour pré-remplir le formulaire après une erreur) */
    public function get(string $field): string
    {
        return $this->data[$field] ?? '';
    }

    /** Libellé du type de projet choisi (ou « Non précisé ») */
    public function getProjectTypeLabel(): string
    {
        return self::PROJECT_TYPES[$this->data['type']] ?? 'Non précisé';
    }

    /** Message d'erreur d'un champ, ou null s'il n'y en a pas */
    public function getError(string $field): ?string
    {
        return $this->errors[$field] ?? null;
    }

    /** Toutes les erreurs : champ => message */
    public function getErrors(): array
    {
        return $this->errors;
    }
}