<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body class="bg-blue-700 flex items-center justify-center min-h-screen">
    <div class="bg-white shadow-lg rounded-lg max-w-sm w-full overflow-hidden">
        <div class="bg-gradient-to-br from-indigo-700 to-blue-950 py-3">
            <h2 class="font-bold text-2xl text-center w-full h-16 flex items-center justify-center flex-col leading-3 pt-3 text-white">JETSAM<div class="text-[8px] leading-3 mt-1 mb-0 tracking-wider uppercase">Reporting Module</div></h2>
        </div>
        <div class="p-6 relative">
            <h2 class="text-2xl font-bold mb-5 text-indigo-800 text-center">Forgot Password</h2>
            @if (session('status')) 
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('status') }}</span>
                </div>
            @endif
            <form class="text-sm" action="{{ url('forgot-password') }}" method="post" id="forgot-password-form">
            @csrf
                <div id="loader" class="absolute inset-0 bg-white bg-opacity-75 flex items-center justify-center hidden">
                    <div class="animate-spin rounded-full h-16 w-16 border-t-4 border-b-4 border-indigo-600"></div>
                </div>
                <div class="mb-4">
                    <input type="email" name="email" placeholder="Enter your email" id="email" class="mt-1 p-3  w-full rounded-md border border-slate-300 shadow-sm focus:ring-indigo-700" required>
                    <p class=" text-orange-600 text-[13px] italic">@error('email') * {{ $message }} @enderror</p>
                </div>
                <button type="submit" class="w-full py-2 bg-gradient-to-b from-indigo-600 to-blue-800 text-white rounded-md hover:to-indigo-700 text-lg tracking-wider active:to-bg-black">Send Password Reset Link</button>
            </form>
            <br> <a href="{{ url('login') }}" >-> Back to Login</a>
        </div>
    </div>
    <script>
        document.getElementById('forgot-password-form').addEventListener('submit', function() {
            document.getElementById('loader').classList.remove('hidden');
            const button = document.querySelector('#forgot-password-form button[type="submit"]');
            button.setAttribute('disabled', 'disabled');
            button.innerText = 'Sending...';
        });
    </script>
</body>
</html>
