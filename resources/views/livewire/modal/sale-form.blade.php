
<div class="px-6 pt-5 pb-8">
    <div class="flex justify-center">
        <div class="w-1/2">
            <img src="\image\pcbms-logo-2.png" alt="pcbms-logo">
        </div>
    </div>
    <hr class="my-4">
    <div class="mt-1 mb-3">
        <h1 class="text-lg font-bold">Sale Transaction</h1>
    </div>
    <div class="flex justify-between my-1">
        <div>
            <label class="font-bold text-gray-700">Date:</label>
            <span class="ms-2 tracking-widest font-mono">{{ $sale->created_at->format('m/d/Y') }}</span>
        </div>
        <div>
            <label class="font-bold text-gray-700">Time:</label>
            <span class="ms-2 tracking-widest font-mono">{{ $sale->created_at->format('h:i A') }}</span>
        </div>
    </div>
    <div class="flex justify-between my-1">
        <div>
            <label class="font-bold text-gray-700">Sale ID:</label>
            <span class="ms-2 tracking-widest font-mono">{{ $sale->id }}</span>
        </div>
        <div>
            <label class="font-bold text-gray-700">Transaction Status:</label>
            @switch($sale->transaction_status)
                @case('successful')
                    <span class="ms-2 border-2 border-emerald-100 rounded-lg text-emerald-500 px-3 py-1 tracking-widest text-xs font-mono"> {{ strtoupper($sale->transaction_status) }} </span>
                    @break
                @case('failed')
                    <span class="ms-2 border-2 border-red-100 rounded-lg text-red-500 px-3 py-1 tracking-widest text-xs font-mono"> {{ strtoupper($sale->transaction_status) }} </span>
                    @break
                @case('cancelled')
                    <span class="ms-2 border-2 border-gray-100 rounded-lg text-gray-500 px-3 py-1 tracking-widest text-xs font-mono"> {{ strtoupper($sale->transaction_status) }} </span>
                    @break
            @endswitch
        </div>
    </div>

    <hr class="my-3">

    <table class="w-full my-2">
        <thead>
            <tr class="h-6">
                <th class="text-left font-bold text-gray-700">Product Name</th>
                <th class="text-left font-bold text-gray-700">Price x Qty</th>
                <th class="text-right font-bold text-gray-700">Amount</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($sale->sale_items as $sale_item )
                <tr class="h-10 font-mono">
                    <td class="text-left text-gray-600">{{ $sale_item->item->product_name }}</td>
                    <td class="text-left text-gray-600">₱ {{ $sale_item->price }} <span class="text-xs font-thin">x</span> {{ $sale_item->quantity }}</td>
                    <td class="text-right text-gray-600">₱ {{ $sale_item->total }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <hr class="my-3">

    <div class="flex w-full justify-between mt-1">
        <div class="w-1/2">
            <label class="font-bold text-gray-700">Cash</label>
        </div>
        <div class="w-1/2">
            <p class="font-bold text-gray-700 text-right font-mono">₱ {{ $sale->cash }}</p>
        </div>
    </div>
    <div class="flex w-full justify-between mt-1">
        <div class="w-1/2">
            <label class="font-bold text-gray-700">Total</label>
        </div>
        <div class="w-1/2">
            <p class="font-bold text-gray-700 text-right font-mono">₱ {{ $sale->total }}</p>
        </div>
    </div>
    <div class="flex w-full justify-between mt-1">
        <div class="w-1/2">
            <label class="font-bold text-gray-700">Change</label>
        </div>
        <div class="w-1/2">
            <p class="font-bold text-gray-700 text-right font-mono">₱ {{ $sale->change }}</p>
        </div>
    </div>
</div>
