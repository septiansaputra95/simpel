<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Elegan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    {{-- DARI LAYOUT LAMA --}}
    <!-- Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('lib/datatables/datatables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('lib/datatables/FixedColumns-5.0.0/css/fixedColumns.dataTables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('lib/select2-4.1/css/select2.min.css') }}" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- FILEPOND --}}
    <link href="https://unpkg.com/filepond@^4/dist/filepond.css" rel="stylesheet" />
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
<body class="bg-gray-100 flex">

    <!-- Sidebar -->
    <aside class="w-64 h-screen bg-gray-50 text-gray-800 flex flex-col shadow-lg border-r border-gray-200">
        <div class="p-4 text-xl font-bold border-b border-gray-200">
            SIMPEL
        </div>

        <nav class="flex-1 p-4 space-y-1">
            @include('layouts.newsidebar')
        </nav>

        <!-- Logout -->
        <div class="p-4 border-t border-gray-200">
            <a href="#" class="flex items-center px-4 py-2 rounded-lg hover:bg-gray-200 transition">
                <span class="material-icons-outlined mr-3">logout</span> Logout
            </a>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 p-6 space-y-6">
        @yield('newcontent')
    </main>

    <!-- Icon Library -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet">


    {{-- DARI LAYOUT LAMA --}}
    <script src="{{ asset('lib/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('lib/datatables/datatables.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.min.js"></script>

    {{-- FILEPOND --}}
    <script src="https://unpkg.com/filepond@^4/dist/filepond.js"></script>
    {{-- END DARI LAYOUT LAMA --}}

    <!-- Script -->
    <script>
        function toggleSubmenu(id) {
            const submenu = document.getElementById(id);
            const icon = document.getElementById("icon-" + id);
            submenu.classList.toggle("hidden");
            icon.classList.toggle("rotate-180");
        }

        document.querySelectorAll('.tab-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                document.querySelectorAll('.tab-btn').forEach(b => {
                    b.classList.remove('border-blue-500', 'text-blue-600');
                    b.classList.add('border-transparent', 'text-gray-500');
                });
                btn.classList.add('border-blue-500', 'text-blue-600');
                btn.classList.remove('border-transparent', 'text-gray-500');

                document.querySelectorAll('.tab-content').forEach(tab => tab.classList.add('hidden'));
                document.getElementById(btn.dataset.tab).classList.remove('hidden');
            });
        });
    </script>
    @stack('scripts')
</body>
</html>
