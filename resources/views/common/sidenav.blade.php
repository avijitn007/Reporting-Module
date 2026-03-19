<!--sidenav -->
<div class="fixed left-0 top-0 w-44 h-full bg-gradient-to-b from-indigo-700 to-blue-950 z-50 sidebar-menu transition-transform">
    <a href="/" class="flex items-center border-b border-indigo-800">

        <h2 class="logo-big font-bold text-2xl text-center w-full h-16 flex items-center justify-center flex-col leading-3 pt-3 text-white">JETSAM<div class="text-[8px] leading-3 mt-1 mb-0 tracking-wider uppercase">Reporting Module</div></h2>
        <h2 class="logo-small hidden font-bold text-xl text-center w-full h-16 flex items-center justify-center flex-col leading-3 pt-3 text-white">{ JSRM }</h2>
    </a>
    <ul class=" p-4 ">
        <li class="mb-1 group {{ request()->is('Dashboard') ? 'selected' : '' }} menu-list">
            <a href="/Dashboard" class="flex font-semibold items-center py-2 px-4 text-slate-100 hover:bg-blue-950 hover:text-blue-100 rounded-md group-[.active]:bg-blue-800 group-[.active]:text-white group-[.selected]:bg-blue-950 group-[.selected]:text-slate-100">
                <i class="bx bx-home mr-3 text-lg"></i>
                <span class="text-sm menu-link">Dashboard</span>
            </a>
        </li>
        
        <li class="mb-1 group {{ request()->is('users') ? 'selected' : '' }} menu-list">
            @if(Auth::user() && Auth::user()->role == 'admin')
            <a href="/users" class="flex font-semibold items-center py-2 px-4 text-slate-100 hover:bg-blue-950 hover:text-blue-100 rounded-md group-[.active]:bg-blue-800 group-[.active]:text-white group-[.selected]:bg-blue-950 group-[.selected]:text-slate-100">
                <i class='bx bx-user-circle mr-3 text-lg'></i>
                <span class="text-sm menu-link">Users</span>
            </a>
            @endif
        </li>
        
        <li class="mb-1 group  {{ request()->is('affiliates') || request()->is('campaigns') ? 'selected' : '' }} menu-list">
            <a href="javascript:void(0)" class=" relative z-[1] flex font-semibold items-center py-2 px-4 text-slate-100 hover:bg-blue-950 hover:text-slate-100 rounded-md group-[.active]:bg-blue-800 group-[.active]:text-white group-[.selected]:bg-blue-950 group-[.selected]:text-slate-100 sidebar-dropdown-toggle">
                <i class='bx bx-network-chart mr-3 text-lg' ></i>                 
                <span class="text-sm menu-link">Affiliate <i class="ri-arrow-right-s-line ml-auto group-[.selected]:rotate-90"></i></span>
                
            </a>
            <ul class="pl-4 pt-4 pb-1 -mt-1  hidden bg-blue-200/5 rounded-b-md sub-menu-list">
                <li class="mb-3">
                    <a href="/affiliates" class="text-slate-100 text-[12px] flex items-center hover:text-indigo-400 before:contents-[''] before:w-1 before:h-1 before:rounded-full before:bg-indigo-300 before:mr-3  {{ request()->is('affiliates') ? 'active' : '' }}">All affiliates</a>
                </li> 
                <li class="mb-3">
                    <a href="/campaigns" class="text-slate-100 text-[12px] flex items-center hover:text-indigo-400 before:contents-[''] before:w-1 before:h-1 before:rounded-full before:bg-indigo-300 before:mr-3  {{ request()->is('campaigns') ? 'active' : '' }}">All campaigns</a>
                </li> 
            </ul>
        </li>
        
    </ul>
</div>
<div class="fixed top-0 left-0 w-full h-full bg-black/50 z-40 md:hidden sidebar-overlay"></div>
<!-- end sidenav -->