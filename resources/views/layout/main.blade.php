<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @fluxAppearance
</head>
<body class="bg-[#ebebeb]">
    <h1 class="text-center py-5 text-2xl">Znajdź swój autobus!</h1>
    <span  class="text-center mx-auto block mb-5">Ulubione (0)</span>
    <div class="nav mx-auto text-center">
        <span>Jeden</span>
        <span>Dwa</span>
    </div>
    <div class="w-[1000px] bg-white mx-auto">
        @yield('content', 'Default content')
    </div>
</body>
</html>