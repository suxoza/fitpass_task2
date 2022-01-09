<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

        <!-- Styles -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">


        <style>
            body {
                font-family: 'Nunito', sans-serif;
            }
        </style>
    </head>
    <body class="antialiased">
        <div id="app" class="relative flex items-top justify-center min-h-screen bg-gray-100 sm:items-center py-4 sm:pt-0">

            {{-- <div class="m-auto flex">
                <div class="flex flex-col items-center justify-center">
                    <div class="m-1">Length</div>
                    <select name="strlength" class="mt-3 w-16 p-2">
                        @foreach([1, 2, 3] as $strlength)
                            <option value="{{ $strlength }}">{{ $strlength}}</option>
                        @endforeach
                    </select>
                </div>

                <div class="flex flex-col items-center justify-center">
                    <div class="m-1">Strlength</div>
                    <select name="strlength" class="mt-3 w-16 p-2">
                        @foreach([1, 2, 3] as $strlength)
                            <option value="{{ $strlength }}">{{ $strlength}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex items-end">
                    <div class="px-10 py-2 bg-green-400 flex justify-center items-center">Generate</div>
                </div>
            </div> --}}
        </div>
    </body>
    <script src="{{ asset('js/app.js') }}"></script>
</html>
