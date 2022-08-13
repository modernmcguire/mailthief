<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>MailThief Inbox</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    @livewireStyles()
</head>
<body class="bg-light">
    <div class="container mt-3">
        <div class="row">
            <div class="col-md-12 d-flex align-items-end justify-content-center">
                <img src="{{ asset('vendor/mailthief/icon.png') }}" width="64" class="me-3" />
                <h1 class="text-center mb-0 ml-3">
                    MailThief Inbox
                </h1>
            </div>
            <div class="col-md-12">
                <hr>
                @livewire('mailthief::inbox')
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>
    @livewireScripts()
</body>
</html>
