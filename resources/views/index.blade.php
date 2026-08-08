<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>MailThief Inbox</title>
    @livewireStyles()
</head>
<body class="bg-light">
    <livewire:mailthief::inbox />
    @livewireScripts()
    @php
    $version = Composer\InstalledVersions::getVersion('livewire/livewire');

    if (strpos($version, '2.') === 0) {
        echo '<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/alpine.min.js"></script>';
    }
    @endphp
</body>
</html>
