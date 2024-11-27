<!DOCTYPE html>
<html lang="en">
<head>
    <title>Affiliates</title>
    @include("common.header")
</head>
<body class="m-0 p-0">
        
    @include("common.sidenav")
    
    <main class="md:w-[calc(100%-176px)] md:ml-44 bg-blue-200 min-h-screen transition-all main">

        @include("common.topnav")

        <!-- main conent -->
        <div class="p-4">
            
            <!-- headeing -->
            <h2 class="text-2xl my-5 px-2 font-bold text-blue-800">Add Affiliate</h2>
            <!-- Table Section -->
            <form class="mt-4 p-1 border-4 border-sky-100 bg-slate-50 shadow-lg rounded-lg overflow-x-auto" method="post" action="{{ url('add-affiliate') }}" enctype="multipart/form-data">
                @csrf
                <div class="overflow-x-auto">
                    <form id="affiliateForm" class="w-full">
                        <table class="min-w-full bg-white border text-[12px] table-auto rounded-md overflow-hidden shadow-md">
                            <thead>
                                <tr class="bg-gradient-to-br from-indigo-700 to-blue-600 text-white">
                                    <th class="px-2 py-2 border min-w-[180px] font-normal -tracking-wide">Logo</th>
                                    <th class="px-2 py-2 border min-w-[120px] font-normal -tracking-wide">Affiliate Name</th>
                                    <th class="px-2 py-2 border min-w-[120px] font-normal -tracking-wide">Email</th>
                                    <th class="px-2 py-2 border min-w-[120px] font-normal -tracking-wide">Phone</th>
                                    <th class="px-2 py-2 border min-w-[120px] font-normal -tracking-wide">Actions</th>
                                </tr>
                            </thead>
                            <tbody id="affiliateTableBody">
                                <tr>
                                    <td class="px-2 py-2 border min-w-[180px]">
                                        <input type="file" name="logo" id="logoUpload" accept="image/*" class="px-2 py-1 border h-8 rounded-sm w-full" />
                                    </td>
                                    <td class="px-2 py-2 border min-w-[120px]">
                                        <input type="text" name="name" id="affiliateName" class="w-full px-2 py-1 border h-8 rounded-sm" placeholder="Affiliate Name" value="{{ old('name') }}" required />
                                    </td>
                                    <td class="px-2 py-2 border min-w-[120px]">
                                        <input type="email" name="email" id="affiliateEmail" class="w-full px-2 py-1 border h-8 rounded-sm" placeholder="Email" value="{{ old('email') }}" required />
                                    </td>
                                    <td class="px-2 py-2 border min-w-[120px]">
                                        <input type="tel" name="phone" id="affiliatePhone" class="w-full px-2 py-1 border h-8 rounded-sm" placeholder="Phone" value="{{ old('phone') }}" maxlength="10" required />
                                    </td>
                                    <td class="px-2 py-2 border min-w-[120px]">
                                        <button type="submit" class="bg-gradient-to-br h-8 from-indigo-700 to-blue-600 hover:from-blue-600 hover:to-indigo-700 active:bg-black text-white px-4 py-1 rounded w-full">
                                            Add Affiliate
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <!-- Submit button -->
                        <!-- <div class="flex justify-end mt-3">
                            <button type="submit" class="bg-indigo-500 hover:bg-slate-700 text-white px-4 mr-2 py-1 rounded text-[13px]">
                                Submit Affiliates
                            </button>
                        </div> -->
                    </form>
                </div>
            </form>

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

            <h2 class="text-2xl my-5 px-2 font-bold text-blue-800">All Affiliates</h2>
            <!-- Table to display added affiliates -->
            <div class="mt-4 p-1 border-4 border-sky-100 bg-slate-50 shadow-lg rounded-lg overflow-x-auto">
                <div class="overflow-x-auto">
                    <table id="addedAffiliatesTable" class="min-w-full bg-white border text-[12px] table-auto rounded-md overflow-hidden shadow-md">
                        <thead>
                            <tr class="bg-gradient-to-br from-indigo-700 to-blue-600 text-white">
                                <th class="px-2 py-2 border max-w-[90px] font-normal -tracking-wide">Logo</th>
                                <th class="px-2 py-2 border min-w-[120px] font-normal -tracking-wide">Affiliate Name</th>
                                <th class="px-2 py-2 border min-w-[120px] font-normal -tracking-wide">Email</th>
                                <th class="px-2 py-2 border min-w-[120px] font-normal -tracking-wide">Phone</th>
                                <th class="px-2 py-2 border min-w-[50px] font-normal -tracking-wide">Action</th>
                            </tr>
                        </thead>
                        <tbody id="affiliatesList">
                            <!-- Affiliates will be dynamically added here -->
                            
                            @if (count($all_affiliates))
                                @foreach ($all_affiliates as $affiliate)
                                    
                                    <tr class="text-center">
                                        <td class="px-2 py-2 border max-w-[90px] font-normal -tracking-wide">
                                            @if ($affiliate->logo)
                                            <img src="{{ url('storage/assets/uploads/'.$affiliate->logo) }}" alt="Logo" class="w-auto h-8 object-contain object-center mx-auto" />
                                            @else
                                             No Image
                                            @endif
                                        </td>
                                        <td class="px-2 py-2 border max-w-[90px] font-normal -tracking-wide">{{ $affiliate->name }}</td>
                                        <td class="px-2 py-2 border max-w-[90px] font-normal -tracking-wide">{{ $affiliate->email }}</td>
                                        <td class="px-2 py-2 border max-w-[90px] font-normal -tracking-wide">{{ $affiliate->phone }}</td>
                                        @if ($affiliate->status == 1)
                                        <td class="px-2 py-2 border min-w-[50px] font-normal -tracking-wide"><a href="/deactivate-affiliate/{{$affiliate->id}}" class="bg-gradient-to-br h-8 from-orange-600 to-orange-500 hover:from-orange-600 hover:to-orange-700 active:bg-black text-white px-4 py-1 rounded w-full">Deactivate</a></td>
                                        @else
                                        <td class="px-2 py-2 border min-w-[50px] font-normal -tracking-wide"><a href="/activate-affiliate/{{$affiliate->id}}" class="bg-gradient-to-br h-8 from-indigo-600 to-indigo-500 hover:from-blue-600 hover:to-indigo-700 active:bg-black text-white px-4 py-1 rounded w-full" >Activate</a></td>
                                        @endif
                                    </tr>

                                @endforeach
                            @else                            
                                <tr>
                                    <td>No Affiliates to show...</td>
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