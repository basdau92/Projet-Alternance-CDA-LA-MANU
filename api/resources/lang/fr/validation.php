<?php
return [
    'custom' => [
        'password' => [
            'required' => 'Ce champ ne peut être vide.',
            'min' => 'Votre mot de passe doit contenir au moins :min caractères.',
            'regex' =>  'Votre mot de passe doit contenir au moins 1 majuscule, 1 minuscule, 1 chiffre, 1 caractère spécial.',
        ],
        'mail' => [
            'required' => 'Ce champ ne peut être vide.',
            'email' => 'Veuillez vérifier le format de votre mail.',
            'unique' => 'Cette adresse mail existe déjà.'
        ],
        'lastname' => [
            'required' => 'Ce champ ne peut être vide.',
            'string' => 'Les caractères spéciaux ne sont pas autorisés.'
        ],
        'firstname' => [
            'required' => 'Ce champ ne peut être vide.',
            'string' => 'Les caractères spéciaux ne sont pas autorisés.'
        ],
        'phone' => [
            'required' => 'Ce champ ne peut être vide.',
            'numeric' => 'Le téléphone ne peut être composé que de chiffres.'
        ],
        'id_agency' => [
            'required' => 'Ce champ ne peut être vide.',
            'numeric' => 'Le n° de l\'agence ne peut être composé que de chiffres.'
        ],
        'matricule' => [
            'numeric' => 'Le matricule n\'est composé que de chiffres.',
            'unique' => 'Ce numéro d\'employé existe déjà.'
        ],
        'name' => [
            'required' => 'Ce champ ne peut être vide.',
            'string' => 'Les caractères spéciaux ne sont pas autorisés.'
        ],
        'price' => [
            'required' => 'Ce champ ne peut être vide.',
            'numeric' => 'Le prix n\'est composé que de chiffres.'
        ],
        'address' => [
            'required' => 'Ce champ ne peut être vide.',
            'string' => 'Les caractères spéciaux ne sont pas autorisés.'
        ],
        'addition_address' => [
            'required' => 'Ce champ ne peut être vide.',
            'string' => 'Les caractères spéciaux ne sont pas autorisés.'
        ],
        'zipcode' => [
            'required' => 'Ce champ ne peut être vide.',
            'string' => 'Les caractères spéciaux ne sont pas autorisés.'
        ],
        'city' => [
            'required' => 'Ce champ ne peut être vide.',
            'string' => 'Les caractères spéciaux ne sont pas autorisés.'
        ],
        'description' => [
            'required' => 'Ce champ ne peut être vide.'
        ],
        'surface' => [
            'required' => 'Ce champ ne peut être vide.',
            'numeric' => 'La surface n\'est composée que de chiffres.'
        ],
        'floor' => [
            'required' => 'Ce champ ne peut être vide.',
            'numeric' => 'L\'étage n\'est composé que de chiffres.'
        ],
        'is_furnished' => [
            'required' => 'Ce champ ne peut être vide.'
        ],
        'is_available' => [
            'required' => 'Ce champ ne peut être vide.'
        ],
        'id_property' => [
            'unique' => 'Ce bien immobilier est déjà dans votre liste de favoris.'
        ]
    ],

];
