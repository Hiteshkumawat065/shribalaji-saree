<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'SareeInfo — Premium Indian Sarees')</title>
    <meta name="description" content="@yield('meta_description', 'Discover handpicked Banarasi, Kanjivaram silk, bridal and designer sarees.')">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;0,800;1,400&family=Poppins:wght@300;400;500;600;700&family=Cormorant+Garamond:ital,wght@0,400;0,500;0,600;1,400&display=swap">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="{{ asset('frontend/css/saaheli.css') }}">
    <script src="{{ asset('frontend/js/tailwind-config.js') }}"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

    @stack('styles')
</head>
<body class="min-h-screen flex flex-col font-sans antialiased">

    @include('frontend.includes.header')

    <main class="flex-1">
        @yield('content')
    </main>

    @include('frontend.includes.footer')

    @stack('scripts')
</body>
</html>
