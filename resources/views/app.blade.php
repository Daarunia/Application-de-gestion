<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <!-- Scripts -->
    <script src="https://kit.fontawesome.com/12bd49648b.js" crossorigin="anonymous"></script>
    @inertiaHead
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body class="h-100">
    @inertia
</body>
</html>
