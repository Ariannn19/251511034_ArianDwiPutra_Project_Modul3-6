<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Activity Manager</title>
    <style>
        body {
            font-family: sans-serif;
            margin: 2rem;
        }

        .card {
            border: 1px solid #ccc;
            padding: 1rem;
            margin-bottom: 1rem;
            border-radius: 8px;
        }

        .alert-success {
            background: #d4edda;
            color: #155724;
            padding: 0.75rem;
            margin-bottom: 1rem;
            border-radius: 4px;
        }

        .alert-error {
            background: #f8d7da;
            color: #721c24;
            padding: 0.75rem;
            margin-bottom: 1rem;
            border-radius: 4px;
        }

        .text-error {
            color: #dc3545;
            font-size: 0.875rem;
        }

        .form-group {
            margin-bottom: 1rem;
        }

        label {
            display: block;
            margin-bottom: 0.25rem;
            font-weight: bold;
        }

        input,
        textarea,
        select {
            width: 100%;
            max-width: 400px;
            padding: 0.5rem;
        }
    </style>
</head>

<body>
    <main>
        @if (session('success'))
        <div class="alert-success">{{ session('success') }}</div>
        @endif

        @yield('content')
    </main>
</body>

</html>
