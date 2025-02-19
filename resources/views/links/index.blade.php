<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0">
    <title>MyLinks - Link Tree</title>
    <script src="https://cdn.tailwindcss.com"></script>
    @vite('resources/css/app.css')
    <style>
        @keyframes pulse {
            0% {
                opacity: 0.2;
            }

            50% {
                opacity: 0.4;
            }

            100% {
                opacity: 0.2;
            }
        }

        .custom-pulse {
            animation: pulse 2s infinite;
        }
    </style>
</head>

<body class="min-h-screen bg-gradient-to-b from-gray-900 to-gray-800 p-4">
    <div class="max-w-md mx-auto pt-8 pb-20">
        <!-- Header -->
        <div class="flex items-center mb-8">
            <div class="w-6 h-6 text-gray-400"></div>
            <h1 class="text-white text-xl font-bold flex justify-center w-full">
                Shahnameh's Links
            </h1>
        </div>

        <!-- Profile Section -->
        <div class="text-center mb-8">
            <div class="w-24 h-24 mx-auto mb-4 relative">
                <div
                    class="absolute inset-0 rounded-full bg-yellow-500 custom-pulse">
                </div>
                <div
                    class="absolute inset-2 rounded-full bg-gradient-to-r from-yellow-500 to-yellow-600 flex items-center justify-center">
                    <span class="text-2xl font-bold text-white">REAL</span>
                </div>
            </div>
        </div>

        <!-- Links Section -->
        <div class="space-y-3">
            @foreach ($links as $link)
                <a href="{{ $link->link }}"
                    target="_blank"
                    class="w-full p-4 bg-gray-800/50 backdrop-blur-sm rounded-xl flex items-center justify-between group hover:bg-gray-700/50 transition-all duration-300">
                    <div class="flex items-center gap-3">
                        <div
                            class="w-10 h-10 rounded-full bg-gray-700/50 flex items-center justify-center text-gray-300">
                            @if ($link->icon)
                                @svg($link->icon, 'w-6 h-6')
                            @endif
                        </div>
                        <span class="text-gray-200">{{ $link->name }}</span>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</body>

</html>
