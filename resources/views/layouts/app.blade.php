<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1">
    <title>Tasks - @yield('title')</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <script src="//unpkg.com/alpinejs" defer></script>
    {{-- blade-formatter-disable --}}
    <style type="text/tailwindcss">
    .btn {
        @apply rounded-md px-2 py-1 text-center font-medium text-slate-700 shadow-sm ring-1 ring-slate-700/10 hover:bg-slate-50;
    }
    .link {
        @apply text-gray-700 font-medium underline decoration-pink-500
    }

    label {
        @apply block uppercase text-slate-700 mb-2
    }
    input, textarea {
        @apply border w-full py-2 px-3 shadow-sm text-slate-700 leading-tight focus:outline-none
    }

    .error {
        @apply text-red-500 text-sm
    }
    </style>
    {{-- blade-formatter-enable --}}
    @yield('styles')
</head>

<body class="container mx-auto mb-10 mt-10 max-w-lg">
    <h1 class="text-2xl">@yield('title')</h1>
    <div x-data="{ flash: true }">
        @if (session()->has('success'))
            <div x-show="flash"
                 class="relative mb-10 rounded border border-green-400 bg-green-100 p-4 text-lg text-green-700"
                 role="alert">
                <strong class="font-bold">Success!</strong>
                <div> {{ session('success') }} </div>
                <span class="absolute bottom-0 right-0 top-0 px-4 py-3">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                         stroke-width="1.5" @click="flash = false"
                         stroke="currentColor" class="h-6 w-6 cursor-pointer">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </span>
            </div>
        @endif
        @yield('content')
    </div>
</body>

</html>
