<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bals France</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <livewire:layout.header />

    <main>
        {{ $slot }}
    </main>

    <livewire:layout.footer />
</body>
</html>