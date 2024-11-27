<!DOCTYPE html>
<html lang="en">
<head>
    <title>Dashboard</title>
    @include("common.header")
</head>
<body class="m-0 p-0">

    @include("common.sidenav")

    <main class="md:w-[calc(100%-176px)] md:ml-44 bg-blue-200 min-h-screen transition-all main">

        @include("common.topnav")

        <!-- main conent -->
        <h2 class="text-2xl mt-10 px-6 font-bold text-blue-800">Welcome to Dashboard</h2>
        <div class="p-4">
            <form action="" method="get">
                <!-- @csrf -->
            <div class="p-4 bg-gradient-to-br from-indigo-800/20 to-blue-100/40 border border-white shadow-lg rounded-md flex justify-between items-center flex-wrap gap-3">
                <div class="flex items-center space-x-4 flex-wrap">
                    <input type="date" class="border border-white rounded-md px-2 h-10 bg-blue-50 text-[13px]" name="start_date" value="{{ $dates[0] ?? date('Y-m-d') }}" />
                    <input type="date" class="border border-white rounded-md px-2 h-10 bg-blue-50 text-[13px]" name="end_date" value="{{ $dates[1] ?? date('Y-m-d') }}" />
                    <button class="bg-gradient-to-br from-indigo-700 to-blue-600 hover:from-blue-600 hover:to-indigo-700 text-white px-4 py-[9px] rounded-md text-sm active:bg-slate-600" type="submit">Run Report</button>
                </div>
                <div class="flex space-x-4 text-[14px]">
                    <span class="bg-green-100 text-green-700 px-2 py-1 border border-white rounded-md">ASTRA</span>
                    <span class="bg-slate-200 text-slate-700 px-2 py-1 border border-white rounded-md">@php echo date('Y-m-d - H:i:s'); @endphp</span>
                    <span class="bg-slate-200 text-slate-700 px-2 py-1 border border-white rounded-md">USD</span>
                </div>
            </div>
            </form>
            <!-- Summary Section -->
            <div class="mt-4 p-6 bg-gradient-to-br from-indigo-800/50 to-blue-600/60 border-white border shadow-lg rounded-md text-white">
                @if($data_counts_campaigns->isEmpty() or $all_data->isEmpty())
                    No data exists in the selected date range!
                @else
                <div class="grid grid-cols-4 gap-4">
                    <div>
                        <p class="text-slate-100 text-[13px]">Gross Clicks</p>
                        <p class="text-sm font-bold">{{ $data_counts_campaigns[0]->total_gross_clicks }}</p>
                    </div>
                    <div>
                        <p class="text-slate-100 text-[13px]">Unique Clicks</p>
                        <p class="text-sm font-bold">{{ $data_counts_campaigns[0]->total_unique_clicks }}</p>
                    </div>
                    <div>
                        <p class="text-slate-100 text-[13px]">Total CV</p>
                        <p class="text-sm font-bold">{{ $data_counts_campaigns[0]->total_cv }}</p>
                    </div>
                    <div>
                        <p class="text-slate-100 text-[13px]">CVR</p>
                        <p class="text-sm font-bold">{{ number_format($data_counts_campaigns[0]->total_cvr,2) }}%</p>
                    </div>
                </div>
                <div class="grid grid-cols-4 gap-4 mt-4">
                    <!-- <div>
                        <p class="text-slate-100 text-[13px]">Margin</p>
                        <p class="text-sm font-bold">%</p>
                    </div> -->
                    <div>
                        <p class="text-slate-100 text-[13px]">CPA</p>
                        <p class="text-sm font-bold">${{ $data_counts_campaigns[0]->total_cpa_affiliate + $data_counts_campaigns[0]->total_cpa_advertiser }}</p>
                    </div>
                    <div>
                        <p class="text-slate-100 text-[13px]">Payout</p>
                        <p class="text-sm font-bold">${{ $data_counts_campaigns[0]->total_payout_affiliate + $data_counts_campaigns[0]->total_payout_advertiser }}</p>
                    </div>
                    <div>
                        <p class="text-slate-100 text-[13px]">Profit</p>
                        <p class="text-sm font-bold">${{ $data_counts_campaigns[0]->total_gross_profit }}</p>
                    </div>
                </div>
                @endif
            </div>
        
            <!-- Table Section -->
            <div class="mt-4 p-0 overflow-hidden border border-white shadow-xl rounded-lg">
                <div class="overflow-x-auto">
                    <table id="dynamicTable" class="min-w-full bg-white border border-slate-300 text-sm table-auto">
                        <thead class="bg-slate-200 text-slate-600 -tracking-wide">
                            <tr class="bg-gradient-to-br from-indigo-700 to-blue-600 text-white">
                                <th class="px-2 py-2 leading-4 border-b font-medium text-[11px]">Affiliate</th>
                                <th class="px-2 py-2 leading-4 border-b font-medium text-[11px]">Gross Clicks</th>
                                <th class="px-2 py-2 leading-4 border-b font-medium text-[11px]">Unique Clicks</th>
                                <th class="px-2 py-2 leading-4 border-b font-medium text-[11px]">Duplicate Clicks</th>
                                <th class="px-2 py-2 leading-4 border-b font-medium text-[11px]">CV</th>
                                <th class="px-2 py-2 leading-4 border-b font-medium text-[11px]">CVR</th>
                                <th class="px-2 py-2 leading-4 border-b font-medium text-[11px]">CPA Affiliate</th>
                                <th class="px-2 py-2 leading-4 border-b font-medium text-[11px]">CPA Advertiser</th>
                                <th class="px-2 py-2 leading-4 border-b font-medium text-[11px]">Payout Affiliate</th>
                                <th class="px-2 py-2 leading-4 border-b font-medium text-[11px]">Payout Advertiser</th>
                                <th class="px-2 py-2 leading-4 border-b font-medium text-[11px]">Gross Profit</th>
                            </tr>
                        </thead>
                        <tbody class="text-slate-700">
                            @if($all_data->isEmpty())
                            <tr class="relative parent-row">
                                <td class="px-2 py-2 leading-4 text-[11px] border-b font-semibold text-slate-900 text-center relative">
                                    Please add/activate Affiliates or Campaings to show.
                                </td>
                            </tr>
                            @endif
                            @foreach ($affiliates as $row)
                            <!-- Parent Row -->
                            <tr class="relative parent-row bg-slate-50 hover:bg-slate-100 cursor-pointer" onclick="toggleRow(this)">
                                <td class="px-2 py-2 leading-4 text-[11px] border-b font-semibold text-slate-900 text-center relative">
                                    <i class="ri-corner-right-down-line mr-1"></i>
                                    {{ $row['affiliate_name'] }}
                                </td>                           
                                <td class="px-4 py-3 border-b text-center text-[11px]">{{ $data_counts_affiliate[$row['affiliate_id']]->total_gross_clicks }}</td>
                                <td class="px-4 py-3 border-b text-center text-[11px]">{{ $data_counts_affiliate[$row['affiliate_id']]->total_unique_clicks }}</td>
                                <td class="px-4 py-3 border-b text-center text-[11px]">{{ $data_counts_affiliate[$row['affiliate_id']]->total_duplicate_clicks }}</td>
                                <td class="px-4 py-3 border-b text-center text-[11px]">{{ $data_counts_affiliate[$row['affiliate_id']]->total_cv }}</td>
                                <td class="px-4 py-3 border-b text-center text-[11px]">{{ number_format($data_counts_affiliate[$row['affiliate_id']]->total_cvr,2) }}%</td>
                                <td class="px-4 py-3 border-b text-center text-[11px]">${{ $data_counts_affiliate[$row['affiliate_id']]->total_cpa_affiliate }}</td>
                                <td class="px-4 py-3 border-b text-center text-[11px]">${{ $data_counts_affiliate[$row['affiliate_id']]->total_cpa_advertiser }}</td>
                                <td class="px-4 py-3 border-b text-center text-[11px]">${{ $data_counts_affiliate[$row['affiliate_id']]->total_payout_affiliate }}</td>
                                <td class="px-4 py-3 border-b text-center text-[11px]">${{ $data_counts_affiliate[$row['affiliate_id']]->total_payout_advertiser }}</td>
                                <td class="px-4 py-3 border-b text-center text-[11px]">${{ $data_counts_affiliate[$row['affiliate_id']]->total_gross_profit }}</td>
                            </tr>
                                <!-- Child Row for Campaigns -->
                                <tr class="child-row hidden">
                                    <td colspan="11" class="p-3 bg-white ">
                                        <table class="min-w-full bg-slate-100  text-sm table-auto overflow-hidden rounded-md">
                                            <thead class="bg-slate-200 text-slate-600 -tracking-wide">
                                                <tr class="bg-gradient-to-br from-indigo-400 to-blue-300 text-white">
                                                    <th class="px-2 py-2 leading-4 border-b font-medium text-[11px]">Campaign</th>
                                                    <th class="px-2 py-2 leading-4 border-b font-medium text-[11px]">Gross Clicks</th>
                                                    <th class="px-2 py-2 leading-4 border-b font-medium text-[11px]">Unique Clicks</th>
                                                    <th class="px-2 py-2 leading-4 border-b font-medium text-[11px]">Duplicate Clicks</th>
                                                    <th class="px-2 py-2 leading-4 border-b font-medium text-[11px]">CV</th>
                                                    <th class="px-2 py-2 leading-4 border-b font-medium text-[11px]">CVR</th>
                                                    <th class="px-2 py-2 leading-4 border-b font-medium text-[11px]">CPA Affiliate</th>
                                                    <th class="px-2 py-2 leading-4 border-b font-medium text-[11px]">CPA Advertiser</th>
                                                    <th class="px-2 py-2 leading-4 border-b font-medium text-[11px]">Payout Affiliate</th>
                                                    <th class="px-2 py-2 leading-4 border-b font-medium text-[11px]">Payout Advertiser</th>
                                                    <th class="px-2 py-2 leading-4 border-b font-medium text-[11px]">Gross Profit</th>
                                                </tr>
                                            </thead>
                                            <tbody class="text-slate-700">
                                            @foreach ($all_data as $campaign)
                                                
                                                @if( $row['affiliate_id'] == $campaign->affiliate_id)
                                                <!-- Campaign Row -->
                                                <tr class="bg-gradient-to-br from-indigo-100 to-blue-100">
                                                    <td class="px-2 py-2 border-b text-slate-900 font-semibold text-[11px] text-center">{{ $campaign->name }}</td>
                                                    <td class="px-4 py-3 border-b text-center text-[11px]">{{ $campaign->gross_clicks }}</td>
                                                    <td class="px-4 py-3 border-b text-center text-[11px]">{{ $campaign->unique_clicks }}</td>
                                                    <td class="px-4 py-3 border-b text-center text-[11px]">{{ $campaign->duplicate_clicks }}</td>
                                                    <td class="px-4 py-3 border-b text-center text-[11px]">{{ $campaign->cv }}</td>
                                                    <td class="px-4 py-3 border-b text-center text-[11px]">{{ number_format($campaign->cvr,2) }}%</td>
                                                    <td class="px-4 py-3 border-b text-center text-[11px]">${{ $campaign->cpa_affiliate }}</td>
                                                    <td class="px-4 py-3 border-b text-center text-[11px]">${{ $campaign->cpa_advertiser }}</td>
                                                    <td class="px-4 py-3 border-b text-center text-[11px]">${{ $campaign->payout_affiliate }}</td>
                                                    <td class="px-4 py-3 border-b text-center text-[11px]">${{ $campaign->payout_advertiser }}</td>
                                                    <td class="px-4 py-3 border-b text-center text-[11px]">${{ $campaign->gross_profit }}</td>
                                                </tr>
                                                <!-- Add more campaign rows as needed -->
                                                @endif

                                            @endforeach
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>                                
                            @endforeach        
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
    
    @include("common.footer")

</body>
</html>