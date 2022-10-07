<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8" />
    </style>
    <title>Renseignement d'un bien</title>
</head>

<body>
    <h1>Renseignement du bien  numero: {{ $details['id'] }}</h1>
    <h3>From : {{ $details['mail'] }}</h3>
    <p>{{ $details['message'] }}</p>
</body>