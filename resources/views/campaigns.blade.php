<!DOCTYPE html>
<html lang="en">
<head>
    <title>Campaigns</title>
    @include("common.header")
</head>
<body class="m-0 p-0">
    @include("common.sidenav")

    <main class="md:w-[calc(100%-176px)] md:ml-44 bg-blue-200 min-h-screen transition-all main">

        @include("common.topnav")

        <!-- main conent -->
        <form class="p-4" action="{{ url('edit-campaigns') }}" method="get">
            
            <!-- Heading -->
            <h2 class="text-2xl my-4 px-2 font-bold text-blue-800">Choose Affiliate</h2>
        
            <div class="max-w-64 p-1 border-sky-100 shadow-md rounded-sm mb-10">
                @if (!count($all_affiliates))
                    No active Affiliates to choose
                @else
                <select id="affiliateSelect" class="affiliate-select h-8 w-full px-2 py-1 border rounded-sm text-sm" name="affiliateid" onchange="toggleAddRowButton(); setAffiliate(this)" value="{{ old('affiliateid') }}" required>                    
                        <option value="">Select Affiliate</option>
                        @php $selected='' @endphp
                        @foreach ($all_affiliates as $affiliate)
                            <option value="{{$affiliate->id}}" {{ (old('affiliateid') == $affiliate->id) ? 'selected' : '' }}>{{'[#'.$affiliate->id.']'.' '.$affiliate->name}}</option>
                        @endforeach
                </select>                
                <!-- <input type="hidden" name="affiliate_name" value="{{ $affiliate->name }}"> -->
                @endif
            </div>
            <div class="w-full mx-2 my-8 flex items-center">
                <button type="submit" class="px-6 py-2 text-[13px] bg-gradient-to-br from-indigo-700 to-blue-600 hover:from-blue-600 hover:to-indigo-700 text-slate-100 rounded-md active:from-blue-900">Edit Existing Campaigns</button>
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
            
        <form class="p-4" action="{{ url('add-campaign') }}" method="post">
            @csrf

            <input type="hidden" id="affiliate" name="affiliate" value="">
            <!-- Heading -->
            <h2 class="text-2xl my-4 px-2 font-bold text-blue-800">Add Campaign</h2>
        
            <!-- Table Section -->
            <div class="mt-4 p-2 overflow-hidden border-4 border-blue-200 bg-slate-50 shadow-lg rounded-lg">
                <div class="overflow-x-auto flex">
                    <table id="dynamicTable" class="min-w-full bg-white border-0 text-[12px] table-auto">
                        <thead>
                            <tr class="bg-gradient-to-br from-indigo-700 to-blue-600 text-white">
                                <th class="px-2 py-2 border font-normal -tracking-wide">#SN</th>
                                <th class="px-2 py-2 border min-w-[150px] lg:min-w-40 font-normal -tracking-wide">Campaign Name</th>
                                <th class="px-2 py-2 border min-w-[250px] lg:min-w-80 font-normal -tracking-wide">Date</th>
                                <th class="px-2 py-2 border min-w-[150px] lg:min-w-40 font-normal -tracking-wide">Gross Clicks</th>
                                <th class="px-2 py-2 border min-w-[150px] lg:min-w-40 font-normal -tracking-wide unique-clicks">Unique Clicks</th>
                                <th class="px-2 py-2 border min-w-[150px] lg:min-w-40 font-normal -tracking-wide duplicate-clicks">Duplicate Clicks</th>
                                <th class="px-2 py-2 border min-w-[70px]  lg:min-w-20 font-normal -tracking-wide cv">CV</th>
                                <th class="px-2 py-2 border min-w-[150px] lg:min-w-40 font-normal -tracking-wide cvr">CVR</th>
                                <th class="px-2 py-2 border min-w-[150px] lg:min-w-40 font-normal -tracking-wide cpa-affiliate">CPA Affiliate</th>
                                <th class="px-2 py-2 border min-w-[150px] lg:min-w-40 font-normal -tracking-wide cpa-advertiser">CPA Advertiser</th>
                                <th class="px-2 py-2 border min-w-[150px] lg:min-w-40 font-normal -tracking-wide payout-affiliate">Payout Affiliate</th>
                                <th class="px-2 py-2 border min-w-[150px] lg:min-w-40 font-normal -tracking-wide payout-advertiser">Payout Advertiser</th>
                                <th class="px-2 py-2 border min-w-[150px] lg:min-w-40 font-normal -tracking-wide gross-profit">Gross Profit</th>
                                <th class="fixed-column">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                        @php $oldrows = old('row') @endphp
                        @if($oldrows)
                            @foreach($oldrows as $key=>$row)
                            <tr class="relative parent-row">
                                <td class="px-2 py-2 border">
                                    <span class="w-full px-2 rounded-sm h-8 rowid" data-name="rowid">{{$key}}</span>
                                </td>
                                <td class="px-2 py-2 border">
                                    <input type="text" class="w-full px-2 border rounded-sm h-8 name" placeholder="Campaign Name" name="row[{{$key}}][name]" data-name="name" value="{{ $row['name'] }}" required />
                                </td>
                                <td class="px-2 py-2 border flex items-center gap-2">
                                    <input type="date" class="w-full px-2 border rounded-sm h-8 start_date" placeholder="Date" name="row[{{$key}}][start_date]" data-name="start_date" value="{{ $row['start_date'] }}" required />
                                    <span>to</span>
                                    <input type="date" class="w-full px-2 border rounded-sm h-8 end_date" placeholder="Date" name="row[{{$key}}][end_date]" data-name="end_date" value="{{ $row['end_date'] }}" required />
                                </td>
                                <td class="px-2 py-2 border">
                                    <input type="text" class="w-full px-2 border rounded-sm h-8 gross_clicks" placeholder="Gross Clicks" name="row[{{$key}}][gross_clicks]" data-name="gross_clicks" onchange="calDuplicateClicks(this)" value="{{ $row['gross_clicks'] }}" required />                                    
                                </td>
                                <td class="px-2 py-2 border">
                                    <input type="text" class="w-full px-2 border rounded-sm h-8 unique_clicks" placeholder="Unique Clicks" name="row[{{$key}}][unique_clicks]" data-name="unique_clicks" onchange="calDuplicateClicks(this);calCVR(this);" value="{{ $row['unique_clicks'] }}" required />
                                </td>
                                <td class="px-2 py-2 border">
                                    <input type="text" class="w-full px-2 border rounded-sm h-8 duplicate_clicks" placeholder="Duplicate Clicks" name="row[{{$key}}][duplicate_clicks]" data-name="duplicate_clicks" value="{{ $row['duplicate_clicks'] }}" required />
                                </td>
                                <td class="px-2 py-2 border">
                                    <input type="text" class="w-full px-2 border rounded-sm h-8 cv" placeholder="CV" name="row[{{$key}}][cv]" data-name="cv" onchange="calCVR(this);calPayoutAffiliate(this);calPayoutAdvertiser(this);" value="{{ $row['cv'] }}" required />
                                </td>
                                <td class="px-2 py-2 border">
                                    <input type="text" class="w-full px-2 border rounded-sm h-8 cvr" placeholder="CVR" name="row[{{$key}}][cvr]" data-name="cvr" value="{{ $row['cvr'] }}" required />
                                </td>
                                <td class="px-2 py-2 border">
                                    <input type="text" class="w-full px-2 border rounded-sm h-8 cpa_affiliate" placeholder="CPA Affiliate" name="row[{{$key}}][cpa_affiliate]" data-name="cpa_affiliate" onchange="calPayoutAffiliate(this)" value="{{ $row['cpa_affiliate'] }}" required />
                                </td>
                                <td class="px-2 py-2 border">
                                    <input type="text" class="w-full px-2 border rounded-sm h-8 cpa_advertiser" placeholder="CPA Advertiser" name="row[{{$key}}][cpa_advertiser]" data-name="cpa_advertiser" onchange="calPayoutAdvertiser(this)" value="{{ $row['cpa_advertiser'] }}" required />
                                </td>
                                <td class="px-2 py-2 border">
                                    <input type="text" class="w-full px-2 border rounded-sm h-8 payout_affiliate" placeholder="Payout Affiliate" name="row[{{$key}}][payout_affiliate]" data-name="payout_affiliate" onchange="calGrossProfit(this)" value="{{ $row['payout_affiliate'] }}" required />
                                </td>
                                <td class="px-2 py-2 border">
                                    <input type="text" class="w-full px-2 border rounded-sm h-8 payout_advertiser" placeholder="Payout Advertiser" name="row[{{$key}}][payout_advertiser]" data-name="payout_advertiser" onchange="calGrossProfit(this)" value="{{ $row['payout_advertiser'] }}" required />
                                </td>
                                <td class="px-2 py-2 border">
                                    <input type="text" class="w-full px-2 border rounded-sm h-8 gross_profit" placeholder="Gross Profit" name="row[{{$key}}][gross_profit]" data-name="gross_profit" value="{{ $row['gross_profit'] }}" required />
                                </td>
                                <td class="px-3 flex items-center py-2 justify-center gap-2 fixed-column">
                                    <button type="button" onclick="addChildRow(this)" class="add-row bg-gradient-to-br from-indigo-700 to-blue-600 hover:to-blue-600 text-white font-medium w-[30px] h-[30px] leading-none flex items-center justify-center rounded-full text-[15px]">+</button>
                                    <button type="button" onclick="removeRow(this)" class="bg-red-600 text-white font-medium w-[30px] h-[30px] leading-none flex items-center justify-center rounded-full text-[15px]">-</button>
                                </td>
                            </tr>
                            @endforeach
                        @else
                            <tr class="relative parent-row">
                                <td class="px-2 py-2 border">
                                    <span class="w-full px-2 rounded-sm h-8 rowid" data-name="rowid">1</span>
                                </td>
                                <td class="px-2 py-2 border">
                                    <input type="text" class="w-full px-2 border rounded-sm h-8 name" placeholder="Campaign Name" name="row[1][name]" data-name="name" required />
                                </td>
                                <td class="px-2 py-2 border flex items-center gap-2">
                                    <input type="date" class="w-full px-2 border rounded-sm h-8 start_date" placeholder="Date" name="row[1][start_date]" data-name="start_date" required />
                                    <span>to</span>
                                    <input type="date" class="w-full px-2 border rounded-sm h-8 end_date" placeholder="Date" name="row[1][end_date]" data-name="end_date" required />
                                </td>
                                <td class="px-2 py-2 border">
                                    <input type="text" class="w-full px-2 border rounded-sm h-8 gross_clicks" placeholder="Gross Clicks" name="row[1][gross_clicks]" data-name="gross_clicks" onchange="calDuplicateClicks(this)" required />                                    
                                </td>
                                <td class="px-2 py-2 border">
                                    <input type="text" class="w-full px-2 border rounded-sm h-8 unique_clicks" placeholder="Unique Clicks" name="row[1][unique_clicks]" data-name="unique_clicks" onchange="calDuplicateClicks(this);calCVR(this);" required />
                                </td>
                                <td class="px-2 py-2 border">
                                    <input type="text" class="w-full px-2 border rounded-sm h-8 duplicate_clicks" placeholder="Duplicate Clicks" name="row[1][duplicate_clicks]" data-name="duplicate_clicks" required />
                                </td>
                                <td class="px-2 py-2 border">
                                    <input type="text" class="w-full px-2 border rounded-sm h-8 cv" placeholder="CV" name="row[1][cv]" data-name="cv" onchange="calCVR(this);calPayoutAffiliate(this);calPayoutAdvertiser(this);" required />
                                </td>
                                <td class="px-2 py-2 border">
                                    <input type="text" class="w-full px-2 border rounded-sm h-8 cvr" placeholder="CVR" name="row[1][cvr]" data-name="cvr" required />
                                </td>
                                <td class="px-2 py-2 border">
                                    <input type="text" class="w-full px-2 border rounded-sm h-8 cpa_affiliate" placeholder="CPA Affiliate" name="row[1][cpa_affiliate]" data-name="cpa_affiliate" onchange="calPayoutAffiliate(this)" required />
                                </td>
                                <td class="px-2 py-2 border">
                                    <input type="text" class="w-full px-2 border rounded-sm h-8 cpa_advertiser" placeholder="CPA Advertiser" name="row[1][cpa_advertiser]" data-name="cpa_advertiser" onchange="calPayoutAdvertiser(this)" required />
                                </td>
                                <td class="px-2 py-2 border">
                                    <input type="text" class="w-full px-2 border rounded-sm h-8 payout_affiliate" placeholder="Payout Affiliate" name="row[1][payout_affiliate]" data-name="payout_affiliate" onchange="calGrossProfit(this)" required />
                                </td>
                                <td class="px-2 py-2 border">
                                    <input type="text" class="w-full px-2 border rounded-sm h-8 payout_advertiser" placeholder="Payout Advertiser" name="row[1][payout_advertiser]" data-name="payout_advertiser" onchange="calGrossProfit(this)" required />
                                </td>
                                <td class="px-2 py-2 border">
                                    <input type="text" class="w-full px-2 border rounded-sm h-8 gross_profit" placeholder="Gross Profit" name="row[1][gross_profit]" data-name="gross_profit" required />
                                </td>
                                <td class="px-3 flex items-center py-2 justify-center gap-2 fixed-column">
                                    <button type="button" onclick="addChildRow(this)" class="add-row bg-gradient-to-br from-indigo-700 to-blue-600 hover:to-blue-600 text-white font-medium w-[30px] h-[30px] leading-none flex items-center justify-center rounded-full text-[15px]">+</button>
                                    <button type="button" onclick="removeRow(this)" class="bg-red-600 text-white font-medium w-[30px] h-[30px] leading-none flex items-center justify-center rounded-full text-[15px]">-</button>
                                </td>
                            </tr>
                        @endif

                        </tbody>
                    </table>
                </div>
            </div>
        
            <div class="w-full my-8 flex justify-center items-center">
                <button type="submit" class="px-6 py-2 text-[13px] bg-gradient-to-br from-indigo-700 to-blue-600 hover:from-blue-600 hover:to-indigo-700 text-slate-100 rounded-md active:from-blue-900">Submit</button>
            </div>
        </form>
        
    </main>
    
    @include("common.footer")

    <script>
        function setAffiliate(elm){
            document.querySelector("input[name=affiliate]").value = elm.value;
        }

        function calDuplicateClicks(elm){
            var parent = elm.closest('tr');
            parent.querySelector('.duplicate_clicks').value = parent.querySelector('.gross_clicks').value - parent.querySelector('.unique_clicks').value;
        }

        function calCVR(elm){
            var parent = elm.closest('tr');
            parent.querySelector('.cvr').value = parent.querySelector('.cv').value / parent.querySelector('.unique_clicks').value;
        }

        function calPayoutAffiliate(elm){
            var parent = elm.closest('tr');
            parent.querySelector('.payout_affiliate').value = parent.querySelector('.cv').value * parent.querySelector('.cpa_affiliate').value;
            calGrossProfit(elm);
        }

        function calPayoutAdvertiser(elm){
            var parent = elm.closest('tr');
            parent.querySelector('.payout_advertiser').value = parent.querySelector('.cv').value * parent.querySelector('.cpa_advertiser').value;
            calGrossProfit(elm);
        }

        function calGrossProfit(elm){
            var parent = elm.closest('tr');
            parent.querySelector('.gross_profit').value = parent.querySelector('.payout_advertiser').value - parent.querySelector('.payout_affiliate').value;
        }

    </script>
</body>
</html>