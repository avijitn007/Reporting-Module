<!DOCTYPE html>
<html lang="en">
<head>
    <title>Profile</title>
    @include("common.header")
</head>
<body class="m-0 p-0">
        
    @include("common.sidenav")
    
    <main class="md:w-[calc(100%-176px)] md:ml-44 bg-blue-200 min-h-screen transition-all main">

        @include("common.topnav")

        <!-- main conent -->
        <div class="p-4 flex justify-center">
            
            <div class="w-full max-w-lg">
                <!-- headeing -->
                <h2 class="text-2xl my-5 px-2 font-bold text-blue-800">Your Profile</h2>

                <form class="mt-4 p-4 border-4 border-sky-100 bg-slate-50 shadow-lg rounded-lg relative" method="post" action="{{ url('update-profile') }}" id="profile-update-form">
                    <div id="loader" class="absolute inset-0 bg-white bg-opacity-75 flex items-center justify-center hidden z-10">
                        <div class="animate-spin rounded-full h-16 w-16 border-t-4 border-b-4 border-indigo-600"></div>
                    </div>
                    @csrf
                    <div class="space-y-4">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                            <input type="text" name="name" id="name" class="mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" value="{{ $user->name }}" required>
                        </div>
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                            <input type="email" id="email" class="mt-1 block w-full px-3 py-2 bg-gray-100 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" value="{{ $user->email }}" readonly>
                        </div>

                        <!-- <div>
                            <label for="current_password" class="block text-sm font-medium text-gray-700">Current Password</label>
                            <div class="relative">
                                <input type="password" id="current_password" class="mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="********" value="{{ $user->password }}" readonly>
                                <button type="button" id="toggleCurrentPassword" class="absolute inset-y-0 right-0 px-3 flex items-center text-sm leading-5">
                                    <svg id="eyeIcon" class="h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    <svg id="eyeOffIcon" class="h-5 w-5 text-gray-500 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7 .946-3.11 3.56-5.448 6.813-6.162M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.593 14.593A9.928 9.928 0 0119.542 12c-1.274-4.057-5.064 7-9.542-7-1.554 0-3.033.42-4.364 1.166M1 1l22 22" />
                                    </svg>
                                </button>
                            </div>
                        </div> -->

                        <button type="button" id="changePasswordBtn" class="mt-2 bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded-md text-sm whitespace-nowrap">Change Password</button>
                        <div id="newPasswordFields" class="hidden space-y-4">
                            <div>
                                <label for="password" class="block text-sm font-medium text-gray-700">New Password</label>
                                <div class="relative">
                                    <input type="password" name="password" id="password" class="mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                    <button type="button" id="togglePassword" class="absolute inset-y-0 right-0 px-3 flex items-center text-sm leading-5">
                                        <svg id="eyeIconPassword" class="h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                        <svg id="eyeOffIconPassword" class="h-5 w-5 text-gray-500 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7 .946-3.11 3.56-5.448 6.813-6.162M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.593 14.593A9.928 9.928 0 0119.542 12c-1.274-4.057-5.064 7-9.542-7-1.554 0-3.033.42-4.364 1.166M1 1l22 22" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            <div>
                                <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm New Password</label>
                                <div class="relative">
                                    <input type="password" name="password_confirmation" id="password_confirmation" class="mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                    <button type="button" id="togglePasswordConfirmation" class="absolute inset-y-0 right-0 px-3 flex items-center text-sm leading-5">
                                        <svg id="eyeIconPasswordConfirmation" class="h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                        <svg id="eyeOffIconPasswordConfirmation" class="h-5 w-5 text-gray-500 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7 .946-3.11 3.56-5.448 6.813-6.162M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.593 14.593A9.928 9.928 0 0119.542 12c-1.274-4.057-5.064 7-9.542-7-1.554 0-3.033.42-4.364 1.166M1 1l22 22" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="flex justify-end mt-6">
                        <button type="submit" class="bg-gradient-to-br from-indigo-700 to-blue-600 hover:from-blue-600 hover:to-indigo-700 active:bg-black text-white px-4 py-2 rounded-md">
                            Update Profile
                        </button>
                    </div>
                </form>

                <script>
                    document.getElementById('profile-update-form').addEventListener('submit', function() {
                        document.getElementById('loader').classList.remove('hidden');
                        const button = document.querySelector('#profile-update-form button[type="submit"]');
                        button.setAttribute('disabled', 'disabled');
                        button.innerText = 'Updating...';
                    });

                    document.getElementById('changePasswordBtn').addEventListener('click', function() {
                        document.getElementById('newPasswordFields').classList.toggle('hidden');
                    });

                    function createPasswordToggle(buttonId, inputId, eyeIconId, eyeOffIconId) {
                        const button = document.getElementById(buttonId);
                        const passwordInput = document.getElementById(inputId);
                        const eyeIcon = document.getElementById(eyeIconId);
                        const eyeOffIcon = document.getElementById(eyeOffIconId);

                        if (button && passwordInput && eyeIcon && eyeOffIcon) {
                            button.addEventListener('click', function () {
                                if (passwordInput.type === 'password') {
                                    passwordInput.type = 'text';
                                    eyeIcon.classList.add('hidden');
                                    eyeOffIcon.classList.remove('hidden');
                                } else {
                                    passwordInput.type = 'password';
                                    eyeIcon.classList.remove('hidden');
                                    eyeOffIcon.classList.add('hidden');
                                }
                            });
                        }
                    } 

                    createPasswordToggle('toggleCurrentPassword', 'current_password', 'eyeIcon', 'eyeOffIcon');
                    createPasswordToggle('togglePassword', 'password', 'eyeIconPassword', 'eyeOffIconPassword');
                    createPasswordToggle('togglePasswordConfirmation', 'password_confirmation', 'eyeIconPasswordConfirmation', 'eyeOffIconPasswordConfirmation');
                </script>

                <br>
                @if ($errors->any())
                <div class="p-4 mb-4 rounded-lg bg-red-50 text-sm text-red-800 dark:text-red-400" role="alert">
                    @foreach ($errors->all() as $error)
                        <p>*{{ $error }}</p>
                    @endforeach 
                </div>
                @endif
                @if(session('response'))
                    <p name="response" class="p-4 mb-4 rounded-lg bg-red-50 text-sm text-purple-600" role="alert">{{ session('response') }}</p>
                @endif
            </div>

        </div>
    </main>

    @include("common.footer")

</body>
</html>
