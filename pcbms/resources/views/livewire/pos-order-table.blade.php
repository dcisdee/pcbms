<div>
    <div class="mt-2 overflow-y-auto h-[23.5rem]">
        <table class="w-full text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-white uppercase bg-slate-400">
                <tr>
                    <th scope="col" class="w-2">
                    </th>
                    <th scope="col" class="w-10 px-3 py-2">
                        Barcode
                    </th>
                    <th scope="col" class="w-32 px-3 py-2">
                        Product Name
                    </th>
                    <th scope="col" class="w-8 px-3 py-2">
                        Price
                    </th>
                    <th scope="col" class="w-8 px-3 py-2">
                        Qty
                    </th>
                    <th scope="col" class="w-8 px-3 py-2">
                        Total
                    </th>
                </tr>
            </thead>
            <tbody class="">
                @foreach ($items as $item)
                    <tr class="bg-white border-b text-sm text-gray-600 hover:bg-gray-50">
                        <input type="hidden" id="item_id_{{ $loop->iteration }}"
                                             name="item_id_{{ $loop->iteration }}"
                                             value="{{ $item['id'] }}">
                        <input type="hidden" id="item_price_{{ $loop->iteration }}"
                                             name="item_price_{{ $loop->iteration }}"
                                             value="{{ $item['selling_unit_price'] }}">
                        <input type="hidden" id="item_qty_{{ $loop->iteration }}"
                                             name="item_qty_{{ $loop->iteration }}"
                                             value="{{ $item['item_qty'] }}">
                        <input type="hidden" id="item_total_price_{{ $loop->iteration }}"
                                             name="item_total_price_{{ $loop->iteration }}"
                                             value="{{ $item['total_price'] }}">

                        <td class="w-2 px-1 py-2">
                            <div class="w-5 h-5 bg-gray-600 text-white text-center py-1 px-1 rounded-full hover:bg-gray-500" wire:click="deleteItemFromOrder({{ $item['id'] }})">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-3 h-3">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                                </svg>
                            </div>
                        </td>
                        <td class="w-10 px-3 py-2">{{ $item['barcode'] }}</td>
                        <td class="w-32 px-3 py-2">{{ $item['product_name'] }}</td>
                        <td class="w-8 px-3 py-2">₱ {{ $item['selling_unit_price'] }}</td>
                        <td class="w-8 px-3 py-2 text-center">{{ $item['item_qty'] }}</td>
                        <td class="w-8 px-3 py-2">₱ {{ $item['total_price'] }}</td>
                    </tr>
                @endforeach
                <input type="hidden" id="items_num" name="items_num" value="{{ count($items) }}">
            </tbody>
        </table>
    </div>

</div>
