<!DOCTYPE html>
<html lang="en">
<head>
    <title>Users</title>
    @include("common.header")
</head>
<body class="m-0 p-0">
        
    @include("common.sidenav")
    
    <main class="md:w-[calc(100%-176px)] md:ml-44 bg-blue-200 min-h-screen transition-all main">

        @include("common.topnav")

        <!-- main conent -->
        <div class="p-4">
            
            <h2 class="text-2xl my-5 px-2 font-bold text-blue-800">All Users</h2>
            <!-- Table to display added affiliates -->
            <div class="mt-4 p-1 border-4 border-sky-100 bg-slate-50 shadow-lg rounded-lg overflow-x-auto">
                <div class="overflow-x-auto">
                    <table id="addedAffiliatesTable" class="min-w-full bg-white border text-[12px] table-auto rounded-md overflow-hidden shadow-md">
                        <thead>
                            <tr class="bg-gradient-to-br from-indigo-700 to-blue-600 text-white">
                                <th class="px-2 py-2 border min-w-[120px] font-normal -tracking-wide">Name</th>
                                <th class="px-2 py-2 border min-w-[120px] font-normal -tracking-wide">Email</th>
                                <th class="px-2 py-2 border min-w-[120px] font-normal -tracking-wide">Role</th>
                                <th class="px-2 py-2 border min-w-[50px] font-normal -tracking-wide">Action</th>
                            </tr>
                        </thead>
                        <tbody id="affiliatesList">
                            @if (count($users))
                                @foreach ($users as $user)
                                    
                                    <tr class="text-center">
                                        <td class="px-2 py-2 border max-w-[90px] font-normal -tracking-wide">
                                            {{ $user->name }}
                                        </td>
                                        <td class="px-2 py-2 border max-w-[90px] font-normal -tracking-wide">
                                            {{ $user->email }}
                                        </td>
                                        <td class="px-2 py-2 border max-w-[90px] font-normal -tracking-wide">
                                            <form method="post" action="{{ url('update-role', $user->id) }}">
                                                @csrf
                                                <select name="role" class="w-full px-2 py-1 h-8 rounded-sm">
                                                    <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>User</option>
                                                    <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                                                </select>
                                        </td>
                                        <td class="px-2 py-2 border min-w-[50px] font-normal -tracking-wide">
                                            <button type="submit" class="bg-gradient-to-br h-8 from-blue-500 to-blue-800 hover:from-blue-600 hover:to-black active:bg-black text-white px-4 py-1 rounded w-1/2 mx-auto block" >Update Role</button>
                                            </form>
                                            <button onclick="window.location.href='{{ url('deactivate-user',$user->id) }}'" class="bg-gradient-to-br h-8 from-red-500 to-red-800 hover:from-red-600 hover:to-red-900 active:bg-red-950 text-white px-4 py-1 rounded w-1/2 mx-auto block mt-1">Deactivate User</button> 
                                        </td>
                                    </tr>

                                @endforeach
                            @else                            
                                <tr>
                                    <td>No Users to show...</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>

    @include("common.footer")

</body>
</html>
