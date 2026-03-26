    <!-- navbar -->
        <div class="py-2 px-6 bg-slate-100 flex justify-between items-center shadow-md shadow-black/5 sticky top-0 left-0 z-30 min-h-16">
            <button type="button" class="text-lg text-blue-700 font-semibold sidebar-toggle">
                <i class="ri-menu-line"></i>
            </button>
            <div class="flex items-center gap-4">
                <a class="text-lg text-blue-700 font-semibold flex items-center justify-between gap-1" href="{{ url('profile') }}">
                    <i class="ri-user-line"></i>
                    <span class="text-[14px]">Profile</span>
                </a>
                <a class="text-lg text-blue-700 font-semibold flex items-center justify-between gap-1" href="{{ url('logout') }}">
                    <i class="ri-logout-circle-line"></i>
                    <span class="text-[14px]">Logout</span>
                </a>
            </div>
        </div>
    <!-- end navbar --> 