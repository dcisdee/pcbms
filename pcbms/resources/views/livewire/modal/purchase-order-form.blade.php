<div class="px-6 py-4 2xl">
    <div class="mt-2 text-xl justify-center font-semibold text-gray-800">
        @if($id == null || $action == 'purchase_orders.store')
            Add Purchase Order
        @else
            @if ($action == 'purchase_orders.update')
                Edit Purchase Order
            @elseif ($action == 'purchase_orders.destroy')
                Delete Purchase Order
            @endif
            : {{ $purchase_order->id }}
        @endif
    </div>

    <div class="mt-4 text-sm text-gray-600">
        <form class="w-full" action="{{ $id != null ? route($action, $id) : $action }}" method="POST">
            @csrf

            @if ($action != null && $action != 'purchase_orders.destroy' )
            @method('PUT')
                    <div class="mt-5 mb-5 mx-0 px-0 flex flex-wrap justify-between">
                        <div class="w-7/12 mr-4 mb-6 md:mb-0">
                            <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2 ml-1" for="barcode">
                            Purchase Order Code
                            </label>
                            <input class="appearance-none block w-full bg-gray-50 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                                    id="purchase_order_code"
                                    type="text"
                                    name="purchase_order_code"
                                    value="{{ $id != null ? $purchase_order->purchase_order_code : '' }}"
                                    required>
                        </div>
                        <div class="w-4/12 mr-4 mb-6 md:mb-0">
                            <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2 ml-1" for="expiration">
                                Delivery Date
                            </label>
                            <input class="appearance-none block w-full bg-gray-50 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                                   id="del_date"
                                   datepicker datepicker-format="mm/dd/yy"
                                   type="date"
                                   name="del_date"
                                   value="{{ $id != null ? $purchase_order->del_date : '' }}" >

                        </div>
                    </div>
                    <div class="mt-5 mb-5 mx-0 px-0 flex flex-wrap justify-between">
                        <div class="w-7/12 mr-4 mb-6 md:mb-0">
                            <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="product_name">
                                Supplier
                            </label>
                            <select id="supplier_id"
                                    class="appearance-none block w-full bg-gray-50 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                                    name="supplier_id"
                                    required>
                                @foreach ($suppliers as $supplier)
                                    <option value="{{ $supplier->id }}" {{ $id != null && $purchase_order->supplier_id == $supplier->id ? 'selected' : '' }}>{{ $supplier->company }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="w-4/12 mr-4 mb-6 md:mb-0">
                            <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2 ml-1" for="purchase_status">
                                Delivery Status
                            </label>
                            <select id="purchase_status" class="appearance-none block w-full bg-gray-50 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" name="purchase_status">
                                <option value="In Transit" {{ $id != null && $purchase_order->purchase_delivery->purchase_status == 'In Transit' ? 'selected' : '' }}>In Transit</option>
                                <option value="Delivered" {{ $id != null && $purchase_order->purchase_delivery->purchase_status == 'Delivered' ? 'selected' : '' }}>Delivered</option>
                                <option value="Return to Sender" {{ $id != null && $purchase_order->purchase_delivery->purchase_status == 'Return to Sender' ? 'selected' : '' }}>Return to Sender</option>
                                <option value="Cancelled" {{ $id != null && $purchase_order->purchase_delivery->purchase_status == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                        </div>
                    </div>

                    {{-- UPDATE --}}
                    @if ($id != null)
                    <div class="mt-5 mb-5 mx-0 px-0">
                        <div x-data="{ count: 0, grandTotal: 0, items: [] , item_qty: '', item_price: ''}">
                            <div class="flex flex-wrap justify-between mb-5">

                                <table class="w-full text-left text-gray-500 dark:text-gray-400">
                                    <thead class="text-white uppercase bg-slate-400">
                                        <tr>
                                            <th scope="col" class="w-4/12 px-3 py-2 text-xs">Barcode</th>
                                            <th scope="col" class="w-5/12 px-3 py-2 text-xs">Product Name</th>
                                            <th scope="col" class="w-1/12 px-3 py-2 text-xs">Price</th>
                                            <th scope="col" class="w-1/12 px-3 py-2 text-xs">Qty</th>
                                            <th scope="col" class="w-1/12 px-3 py-2 text-xs">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-gray-500">
                                        @foreach ($purchase_items as $purchase_item )
                                            <tr >
                                                <td scope="col" class="w-4/12 px-3 py-2 text-xs">
                                                    <div class="mr-2">{!! DNS1D::getBarcodeHTML("$purchase_item->barcode", 'I25+') !!}</div>
                                                    <div class="tracking-widest text-center">{{ $purchase_item->barcode }}</div>
                                                </td>
                                                <td scope="col" class="w-5/12 px-3 py-2 text-xs">{{ $purchase_item->product_name }}</td>
                                                <td scope="col" class="w-1/12 px-3 py-2 text-xs">{{ $purchase_item->price }}</td>
                                                <td scope="col" class="w-1/12 px-3 py-2 text-xs">{{ $purchase_item->qty }}</td>
                                                <td scope="col" class="w-1/12 px-3 py-2 text-xs">{{ $purchase_item->total }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                            </div>
                            <div>
                                <hr class="h-px  bg-gray-200 border-0 dark:bg-gray-700">

                                <div class="flex justify-end mr-1 mt-4">
                                    <div class="w-2/12 text-end">
                                        <p>Grand Total: </p>
                                    </div>
                                    <div class="w-2/12 text-end">
                                        <p>{{ $purchase_order->total }}</p>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="flex flex-row justify-end py-2">
                        <x-danger-button class="mr-2" wire:click="$dispatch('closeModal')">
                            {{ __('Cancel') }}
                        </x-danger>
                        <x-button type=submit>
                            {{ __('Update') }}
                        </x-button>
                    </div>

                    {{-- STORE --}}
                    @else
                    <div class="mt-5 mb-5 mx-0 px-0">
                        <div x-data="{ count: 0, grandTotal: 0, items: [], total: '', grandTotals: 0, grandTotal:0 }">
                            <div class="flex flex-wrap justify-between">
                                <table class="w-full text-left text-gray-500 dark:text-gray-400">
                                    <thead class="text-white uppercase bg-slate-400">
                                        <tr>
                                            <th scope="col" class="w-3/12 px-3 py-2 text-xs">Barcode</th>
                                            <th scope="col" class="w-4/12 px-3 py-2 text-xs">Product Name</th>
                                            <th scope="col" class="w-2/12 px-3 py-2 text-xs">Price</th>
                                            <th scope="col" class="w-1/12 px-3 py-2 text-xs">Qty</th>
                                            <th scope="col" class="w-2/12 px-3 py-2 text-xs">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if($items != null)
                                            @foreach ($items as $item)
                                                <tr x-data="{ item_price_{{ $loop->iteration }}: 0, item_qty_{{ $loop->iteration }}: 0, item_total_{{ $loop->iteration }}: 0 }"
                                                    x-init="item_price_{{ $loop->iteration }} = ''; item_qty_{{ $loop->iteration }} = ''; item_total_{{ $loop->iteration }} = '';">
                                                    <td class="w-2/12">
                                                        <input class="appearance-none block w-full bg-gray-50 text-gray-700 text-xs border border-gray-200 rounded py-1 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                                                                id="item_barcode_{{ $loop->iteration }}"
                                                                type="number"
                                                                name="item_barcode_{{ $loop->iteration }}"
                                                                required>
                                                    </td>

                                                    <td class="w-4/12">
                                                        <input class="appearance-none block w-full bg-gray-50 text-gray-700 text-xs border border-gray-200 rounded py-1 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                                                                id="item_product_name_{{ $loop->iteration }}"
                                                                type="text"
                                                                name="item_product_name_{{ $loop->iteration }}"
                                                                required>
                                                    </td>

                                                    <td class="w-2/12">
                                                        <input x-model="item_prices_{{ $loop->iteration }}"
                                                                class="appearance-none block w-full bg-gray-50 text-gray-700 text-xs border border-gray-200 rounded py-1 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                                                                id="item_prices_{{ $loop->iteration }}"
                                                                type="number"
                                                                name="item_prices_{{ $loop->iteration }}"
                                                                required>
                                                    </td>

                                                    <td class="w-1/12">
                                                        <input x-model="item_qty_{{ $loop->iteration }}"
                                                                class="appearance-none block w-full bg-gray-50 text-gray-700 text-xs border border-gray-200 rounded py-1 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                                                                id="item_qty_{{ $loop->iteration }}"
                                                                type="text"
                                                                name="item_qty_{{ $loop->iteration }}"
                                                                required>
                                                    </td>

                                                    <td class="w-2/12">
                                                        <p x-text="item_prices_{{ $loop->iteration }} && item_qty_{{ $loop->iteration }} ?item_total_{{ $loop->iteration }} = item_prices_{{ $loop->iteration }} * item_qty_{{ $loop->iteration }} : 0"
                                                            x-model="item_total_{{ $loop->iteration }}"
                                                            class="appearance-none block w-full bg-gray-50 text-gray-700 text-xs border border-gray-200 rounded py-1 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                                                            id="item_total_{{ $loop->iteration }}"
                                                            name="item_total_{{ $loop->iteration }}"></p>
                                                            <input type="hidden"
                                                                    id="item_total_{{ $loop->iteration }}"
                                                                    name="item_total_{{ $loop->iteration }}"
                                                                    x-bind:value="item_total_{{ $loop->iteration }} = item_prices_{{ $loop->iteration }} * item_qty_{{ $loop->iteration }}">
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                                <input type="hidden" id="items_num" name="items_num" value="{{ count($items) }}">
                            </div>
                            <div class="flex mt-2">
                                <button wire:click.prevent="addItem()" class="w-full transform hover:-translate-y-1  border-2 rounded-lg duration-500 p-1 bg-slate-500 text-white border-slate-600 hover:bg-slate-600 text-sm">Add Item</button>
                            </div>

                            <div>
                                <hr class="h-px my-8 bg-gray-200 border-0 dark:bg-gray-700">

                                <div class="flex items-center justify-end">
                                    <div class="w-3/12">
                                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2 ml-1" for="grand_total">
                                            Grand Total
                                        </label>
                                    </div>
                                    <div class="w-2/12">
                                        <input class="appearance-none block w-full bg-gray-50 text-gray-700 text-xs border border-gray-200 rounded py-1 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="total" type="text" name="total" required>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="flex flex-row justify-end py-2">
                        <x-danger-button class="mr-2" wire:click="$dispatch('closeModal')">
                            {{ __('Cancel') }}
                        </x-danger>
                            <x-button type=submit id="ajaxSubmit">
                                {{ __('Save') }}
                            </x-button>
                        @endif
                    </div>
            @else
            @method('DELETE')
                <div class="my-3 text-sm text-gray-600">
                    Are you sure you want to delete Item:{{ $purchase_order->id }}?
                </div>
                <div class="flex flex-row justify-end py-2" wire:click:prevent="$toggle('item-form')">
                    <x-button class="mr-2" wire:click:prevent="$dispatch('closeModal')" >
                        {{ __('Close') }}
                    </x-danger>
                    <x-danger-button type=submit>
                        {{ __('Delete') }}
                    </x-danger>
                </div>
            @endif
        </form>
    </div>

</div>
