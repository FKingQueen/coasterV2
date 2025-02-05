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
        <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&family=Montserrat:wght@400;500;700&display=swap" rel="stylesheet">
        <script src="https://code.highcharts.com/stock/highstock.js"></script>
        <link rel="stylesheet" href="https://cdn.datatables.net/2.0.8/css/dataTables.dataTables.min.css">

        <style>
        /* width */
        ::-webkit-scrollbar {
        width: 12px;
        }

        /* Track */
        ::-webkit-scrollbar-track {
        background: #134B70; 
        }
        
        /* Handle */
        ::-webkit-scrollbar-thumb {
            background:  #EEEEEE; 
            border-radius: 3px; /* Roundness */
        }

        /* Handle on hover */
        ::-webkit-scrollbar-thumb:hover {
            background: #201E43; 
        }
</style>

    </head>
    <body class="antialiased">
        <div id="app">
        </div>
        <script src="{{mix('/js/app.js')}}"></script>

    </body>
</html>
