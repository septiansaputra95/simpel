<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>SIMPEL RS Hermina Pekalongan</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<script src="https://cdn.tailwindcss.com"></script>

{{-- DARI LAYOUT LAMA --}}
<!-- Tailwind CSS -->
<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<!-- <link rel="stylesheet" href="{{ asset('lib/datatables/datatables.min.css') }}"> -->
<!-- <link rel="stylesheet" href="{{ asset('lib/datatables/FixedColumns-5.0.0/css/fixedColumns.dataTables.min.css') }}"> -->
<link rel="stylesheet" href="{{ asset('lib/select2-4.1/css/select2.min.css') }}" />
<meta name="csrf-token" content="{{ csrf_token() }}">

<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

{{-- FILEPOND --}}
<link href="https://unpkg.com/filepond@^4/dist/filepond.css" rel="stylesheet" />
{{-- END DARI LAYOUT LAMA --}}

{{-- ICON & FONT UNTUK TEMPLATE BARU --}}
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

<script>
  tailwind.config = {
    theme: {
      extend: {
        fontFamily: { sans: ['Inter', 'sans-serif'] },
        colors: {
          ink: '#2b2d42',
          muted: '#8a8fa3',
          bgapp: '#f7f7fb',
          bd: '#edeef3',
          accent: { DEFAULT: '#5eab6f', bg: '#e7f5ea' },
          blue:   { DEFAULT: '#5b9df9', bg: '#e9f1fe' },
          teal:   { DEFAULT: '#4fb8ae', bg: '#e6f6f4' },
          amber:  { DEFAULT: '#e3a13a', bg: '#fbf1e2' },
          rose:   { DEFAULT: '#e08999', bg: '#fbedef' },
          green:  { DEFAULT: '#4caf82', bg: '#e7f5ee' },
        }
      }
    }
  }
</script>

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
<body class="bg-bgapp text-ink font-sans">

<!-- ================= SIDEBAR ================= -->
<aside class="w-[250px] min-h-screen fixed top-0 left-0 bg-white border-r border-bd px-4 py-7 flex flex-col">
    <div class="flex items-center gap-2 font-bold text-lg text-ink">
        <span class="w-2 h-2 rounded-full bg-accent"></span>SIMPEL
    </div>
    <div class="text-xs text-muted mb-7">RS Hermina Pekalongan</div>

    <div class="text-[11px] uppercase tracking-wide text-slate-300 font-semibold mt-2 mb-2 px-2">Menu Utama</div>

    <nav class="flex-1 space-y-0.5 overflow-y-auto">
        @include('layouts.newsidebar')
    </nav>

    <!-- Logout -->
    <form method="POST" action="{{ route('logout') }}" class="pt-4 mt-4 border-t border-bd">
        @csrf
        <button type="submit" class="w-full flex items-center gap-2 px-2 py-2 rounded-lg text-sm font-medium text-muted hover:text-ink hover:bg-slate-50 transition text-left">
            <i class="bi bi-box-arrow-left"></i> Logout
        </button>
    </form>
</aside>

<!-- ================= MAIN CONTENT ================= -->
<main class="ml-[250px] px-10 py-8">
    @yield('newcontent')
</main>

{{-- DARI LAYOUT LAMA --}}
<script src="{{ asset('lib/jquery/jquery.min.js') }}"></script>
<!-- <script src="{{ asset('lib/datatables/datatables.min.js') }}"></script> -->
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>

{{-- FILEPOND --}}
<script src="https://unpkg.com/filepond@^4/dist/filepond.js"></script>
{{-- END DARI LAYOUT LAMA --}}

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<script src="//unpkg.com/alpinejs" defer></script>

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
                b.classList.remove('border-accent', 'text-accent');
                b.classList.add('border-transparent', 'text-muted');
            });
            btn.classList.add('border-accent', 'text-accent');
            btn.classList.remove('border-transparent', 'text-muted');

            document.querySelectorAll('.tab-content').forEach(tab => tab.classList.add('hidden'));
            document.getElementById(btn.dataset.tab).classList.remove('hidden');
        });
    });
</script>
@stack('scripts')
</body>
</html>