<div class="bg-gray-200">
    {{-- SEARCH --}}
    <div class="flex items-center justify-center">
        <div class="flex w-full m-0 p-0">
            <input wire:model.live.debounce.300ms="search" class="w-full border-none bg-transparent px-4 bg-white text-xs text-gray-400 outline-none focus:outline-none" type="search" name="search" placeholder="Search Barcode..." />
            <button type="submit" class="bg-slate-400 px-4 py-2 text-white">
                <svg class="fill-current h-5 w-4" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px" viewBox="0 0 56.966 56.966" style="enable-background:new 0 0 56.966 56.966;" xml:space="preserve" width="512px" height="512px">
                <path d="M55.146,51.887L41.588,37.786c3.486-4.144,5.396-9.358,5.396-14.786c0-12.682-10.318-23-23-23s-23,10.318-23,23  s10.318,23,23,23c4.761,0,9.298-1.436,13.177-4.162l13.661,14.208c0.571,0.593,1.339,0.92,2.162,0.92  c0.779,0,1.518-0.297,2.079-0.837C56.255,54.982,56.293,53.08,55.146,51.887z M23.984,6c9.374,0,17,7.626,17,17s-7.626,17-17,17  s-17-7.626-17-17S14.61,6,23.984,6z" />
                </svg>
            </button>
        </div>
    </div>

    {{-- TABLE --}}
    <div class="mt-2">
        <table class="w-full text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-white uppercase bg-slate-400">
                <tr>
                    <th wire:click="doSort('barcode')" scope="col" class="w-8 px-3">
                        <x-datatable-header sortColumn="$sortColumn" sortDirection="$sortDirection" columnName="barcode" />
                    </th>
                    <th wire:click="doSort('product_name')" scope="col" class="w-40 px-3 py-3">
                        <x-datatable-header sortColumn="$sortColumn" sortDirection="$sortDirection" columnName="product name" />
                    </th>
                    <th scope="col" class="w-16 px-3 py-3 text-center">
                        In-Stock
                    </th>
                    <th wire:click="doSort('category')" scope="col" class="w-24 px-3 py-3">
                        <x-datatable-header sortColumn="$sortColumn" sortDirection="$sortDirection" columnName="category" />
                    </th>
                    <th scope="col" class="w-8 px-3 py-3">
                        Price
                    </th>
                    <th scope="col" class="w-8 px-3 py-3">
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($items as $item)
                    <tr class="bg-white border-b text-xs text-gray-600 hover:bg-gray-50">
                        <td class="w-8 px-3 py-2">{{ $item->barcode }}</td>
                        <td class="w-40 px-3 py-2">{{ $item->product_name }}</td>
                        <td class="w-16 px-3 py-2 text-center">{{ $item->qty }}</td>
                        <td class="w-24 px-3 py-2">
                            @if ($item->category == 'beverages')
                                <span class="bg-rose-100 rounded-full text-rose-500 px-3 py-1">{{ $item->category }}</span>
                            @elseif ($item->category == 'bread/bakery')
                                <span class="bg-teal-100 rounded-full text-teal-500 px-3 py-1">{{ $item->category }}</span>
                            @elseif ($item->category == 'canned/jarred goods')
                                <span class="bg-emerald-100 rounded-full text-emerald-500 px-3 py-1">{{ $item->category }}</span>
                            @elseif ($item->category == 'dairy')
                                <span class="bg-cyan-100 rounded-full text-cyan-500 px-3 py-1">{{ $item->category }}</span>
                            @elseif ($item->category == 'dry/baking goods')
                                <span class="bg-yellow-100 rounded-full text-yellow-500 px-3 py-1">{{ $item->category }}</span>
                            @elseif ($item->category == 'paper goods')
                                <span class="bg-fuchsia-100 rounded-full text-fuchsia-500 px-3 py-1">{{ $item->category }}</span>
                            @elseif ($item->category == 'personal care')
                                <span class="bg-indigo-100 rounded-full text-indigo-500 px-3 py-1">{{ $item->category }}</span>
                            @elseif ($item->category == 'snacks')
                                <span class="bg-amber-100 rounded-full text-amber-500 px-3 py-1">{{ $item->category }}</span>
                            @elseif ($item->category == 'other')
                                <span class="bg-stone-200 rounded-full text-stone-500 px-3 py-1">{{ $item->category }}</span>
                            @endif
                        </td>
                        <td class="w-8 px-3 py-2">₱ {{ $item->selling_unit_price }}</td>
                        <td class="w-8 text-center">
                            <button wire:click.prevent="$dispatch('openModal',
                                                {component: 'modal.item-qty-modal',
                                                arguments: { id: {{ $item->id }}} })"
                                    class="bg-green-600 text-white py-1 p-1 rounded-full hover:bg-lime-500">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                                </svg>
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
