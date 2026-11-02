<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
    </head>
    <body class="h-svh overflow-hidden bg-[#0A1628] text-[#FAFAFA] antialiased">
        {{ $slot }}
    </body>
</html>
