<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>@yield('title') - Laravel App</title>

    <link rel="stylesheet" 
    href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.0.1/tailwind.min.css">
</head>
<body class="bg-gray-100 text-gray-800">

    <nav class="flex py-5 bg-pink-800 text-white">
        <div class="w-1/2 px-12 mr-auto">
            <p class="text-2xl font-bold">SEIPA</p>
        </div>
        <ul class="w-1/2 px-16 ml-auto flex justify-end pt-1">
            @if(auth()->check())
        
            <li class="mx-8">
                <p class="text-xl">Bienvenido <b>{{ auth()->user()->name }}</b></p>
            </li>
            <li>
                <a href="{{ route('login.destroy') }}" class="font-bold
                py-3 px-4 rounded-md bg-red-500 hover:bg-red-600">Cerrar Sesión</a> 
            </li>

            @else

            <li class="mx-6">
                <a href="{{ route('login.index')}}" class="font-semibold 
                hover:bg-pink-900 py-3 px-4 rounded-md">Login</a>
            </li>
            <li>
                <a href="{{ route('register.index')}}" class="font-semibold
                border-2 border-white py-2 px-4 rounded-md hover:bg-white
                hover:text-pink-800">Registro</a> 
            </li>

            @endif
        </ul>
    </nav>
    @yield('content')
</body>
</html>