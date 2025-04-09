<?php

// Wyślij POST do FastAPI i pobierz wygenerowane pytania

$data = [
    'name' => 'Backend Developer',
    'description' => 'Tworzenie i rozwój aplikacji webowych w Pythonie.',
    'tasks' => ['Tworzenie REST API', 'Integracja z bazą danych PostgreSQL'],
    'expectancies' => ['Znajomość Django', 'Umiejętność pracy z Git'],
];

$options = [
    'http' => [
        'header'  => "Content-type: application/json",
        'method'  => 'POST',
        'content' => json_encode($data),
    ],
];

$context  = stream_context_create($options);
$result = file_get_contents('http://127.0.0.1:8000/generate_questions_ml', false, $context);

// Przetwórz odpowiedź
$questions = [];
if ($result !== false) {
    $response = json_decode($result, true);
    $questions = $response['questions'] ?? ['Brak pytań lub błędna odpowiedź'];
} else {
    $questions = ['Błąd połączenia z serwerem FastAPI'];
}

?>

<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <title>Wygenerowane pytania</title>
</head>

<body>
    <h2>Pytania rekrutacyjne wygenerowane przez ML</h2>
    <ul>
        <?php foreach ($questions as $question): ?>
            <li><?= htmlspecialchars($question) ?></li>
        <?php endforeach; ?>
    </ul>
</body>

</html>