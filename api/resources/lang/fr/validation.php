<?php
return [
    'custom' => [
        'password' => [
            'required' => 'Le mot de passe est obligatoire',
            'min' => 'Votre mot de passe doit contenir au moins :min caractères.',
            'regex' =>  'Votre mot de passe doit contenir au moins 1 majuscule, 1 minuscule, 1 chiffre, 1 caractère spécial.',
        ],
        'mail' => [
            'required' => 'Le mail est obligatoire',
            'email' => 'Veuillez vérifier le format de votre mail.',
            'unique' => 'Cette adresse mail existe déjà.'
        ],
        'lastname' => [
            'required' => 'Le nom de famille est obligatoire.',
            'string' => 'Le nom de famille ne peut être composé que de lettres.'
        ],
        'firstname' => [
            'required' => 'Le prénom est obligatoire.',
            'string' => 'Le prénom ne peut être composé que de lettres.'
        ],
        'phone' => [
            'required' => 'Le téléphone est obligatoire.',
            'numeric' => 'Le téléphone ne peut être composé que de chiffres.'
        ],
        'id_agency' => [
            'required' => 'Le n° de l\'agence est obligatoire.',
            'numeric' => 'Le n° de l\'agence ne peut être composé que de chiffres.'
        ],
        'matricule' => [
            'numeric' => 'Le matricule n\'est composé que de chiffres',
            'unique' => 'Ce numéro d\'employé existe déjà.'
        ]
    ],

];
