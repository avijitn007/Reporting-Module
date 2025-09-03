<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" type="text/css" href="{{ asset('custom.css') }}">
</head>
<body>
    <center>
    <h1> Welcome to Dashboard! </h1>
    <p class="text-sm font-light">
        Already have an account? <a href="{{ url('login') }}" class="font-medium text-primary-600 hover:underline dark:text-primary-500">Login here</a>
        <a href="{{ url('registration') }}" class="font-medium text-primary-600 hover:underline dark:text-primary-500">Sign Up here</a>
    </p>
    <a href="{{ url('affiliates') }}">Create Affiliate</a>

    <dev>
    </dev>
    </center>
</body>
</html>
