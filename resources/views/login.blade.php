<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body class="bg-blue-700 flex items-center justify-center min-h-screen">
    <div class="bg-white shadow-lg rounded-lg max-w-sm w-full overflow-hidden">
        <div class="bg-gradient-to-br from-indigo-700 to-blue-950 py-3">
            <h2 class="font-bold text-2xl text-center w-full h-16 flex items-center justify-center flex-col leading-3 pt-3 text-white">JETSAM<div class="text-[8px] leading-3 mt-1 mb-0 tracking-wider uppercase">Reporting Module</div></h2>
        </div>
        <div class="p-6">
            <h2 class="text-2xl font-bold mb-5 text-indigo-800 text-center">Sign In</h2>
            <form class="text-sm" action="{{ url('authenticate-user') }}" method="post">
            @csrf
                <div class="mb-4">
                    <input type="email" name="email" placeholder="Enter username" id="username" class="mt-1 p-3  w-full rounded-md border border-slate-300 shadow-sm focus:ring-indigo-700">
                    <p class=" text-orange-600 text-[13px] italic">@error('email') * {{ $message }} @enderror</p>
                </div>
                <div class="mb-6">
                    <input type="password" name="password" placeholder="Enter password" id="password" class="mt-1 p-3 w-full rounded-md border border-slate-300 shadow-sm focus:ring-indigo-700">
                    <p class=" text-orange-600 text-[13px] italic">@error('password') * {{ $message }} @enderror</p>
                </div>
                <button type="submit" class="w-full py-2 bg-gradient-to-b from-indigo-600 to-blue-800 text-white rounded-md hover:to-indigo-700 text-lg tracking-wider active:to-bg-black">Sign In</button>
            </form>
        </div>
    </div>
</body>
</html>
