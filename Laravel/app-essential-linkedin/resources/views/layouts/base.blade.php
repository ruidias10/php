<!DOCTYPE html>
<html lang="en">
    <head>
        <title>{{ config('app.name') }}</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    </head>
    <body>

        <div class="jumbotron text-center">
        <h1>My First Bootstrap Page</h1>
        <p>Hello, @yield('name')</p>
        </div>

        <div class="container">
            @yield('content')
        </div>

    </body>
</html>
