<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>COASTER</title>
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <link rel="website icon" type="png"
            href="/img/logo/COASTER.png"
        >
        <script src="https://code.highcharts.com/stock/highstock.js"></script>
        <link rel="stylesheet" href="https://cdn.datatables.net/2.0.8/css/dataTables.dataTables.min.css">

    </head>
    <body class="antialiased">
        <div id="app">
        </div>
        <script src="{{mix('/js/app.js')}}"></script>

    </body>
</html>
