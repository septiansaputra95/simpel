<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Menu Samping')</title>
    <!-- Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('lib/datatables/datatables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('lib/datatables/FixedColumns-5.0.0/css/fixedColumns.dataTables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('lib/select2-4.1/css/select2.min.css') }}" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        .submenu {
            display: none;
        }
        .submenu-item {
            padding-left: 1rem;
        }
        .bg-custom-green {
            background-color: #2e8b57;
        }
    </style>
</head>
<body class="flex flex-col">
    <!-- Navbar -->
    <nav class="bg-custom-green text-white">
        <div class="container mx-auto p-4 text-center">
            <a class="text-xl font-bold text-white">
                <i class="fas fa-hospital-symbol mr-2"></i> RS HERMINA PEKALONGAN
            </a>
        </div>
    </nav>

    <div class="flex flex-grow">
        <!-- Sidebar -->
        <nav class="w-64 h-screen bg-custom-green text-white flex flex-col">
            <div class="p-4 text-center border-b border-gray-700">
                <h2 class="text-xl font-bold">SIMPEL</h2>
                <h3 class="text-lg">RS HERMINA PEKALONGAN</h3>
            </div>
            <div class="p-4 flex-grow">
                @include('layouts.sidebar')
            </div>
            <div class="p-4 text-center border-t border-gray-700">
                <span>Logged in as: <strong>User123</strong></span>
            </div>
        </nav>

        <!-- Main Content Area -->
        <div class="flex-1 p-6 bg-gray-100">
            @yield('content')
        </div>
    </div>

    <script src="{{ asset('lib/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('lib/datatables/datatables.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
        function toggleSubmenu(id) {
            var submenu = document.getElementById(id);
            if (submenu.style.display === "none" || submenu.style.display === "") {
                submenu.style.display = "block";
            } else {
                submenu.style.display = "none";
            }
        }
    </script>
    @stack('scripts')
</body>
</html>
