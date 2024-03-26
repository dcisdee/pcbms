
<div class="px-6 py-4 2xl">
    <div class="mt-2 text-xl justify-center font-semibold text-gray-800">
        @if($id == null || $action == 'items.store')
            Add Item
        @else
            @if ($action == 'items.update')
                Edit Item
            @elseif ($action == 'items.destroy')
                Delete Item
            @endif
            : {{ $item->id }}
        @endif
    </div>
    <div class="mt-4 text-sm text-gray-600">
        <form class="w-full" action="{{ $id != null ? route($action, $id) : $action }}" method="POST">
            @csrf

            @if ($action != null && $action != 'items.destroy' )
            @method('PUT')
                <div class="mt-5 mb-5 mx-0 px-0 flex flex-wrap justify-between">
                    @if ($item != null)
                    <div class="w-5/12">
                        <div class="justify-stretch mb-6 pt-3 md:mb-0">
                            {!! DNS1D::getBarcodeHTML("$item->barcode", 'I25+') !!}
                            {!! DNS1D::getBarcodeHTML("$item->barcode", 'I25+') !!}
                        </div>
                    </div>
                    @endif
                    <div class="w-4/12 mr-4 mb-6 md:mb-0">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2 ml-1" for="barcode">
                        Barcode
                        </label>
                        <input class="appearance-none block w-full bg-gray-50 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="barcode" type="number" name="barcode" value="{{ $id != null ? $item->barcode : '' }}" required>
                    </div>
                </div>
                <div class="mt-5 mb-4 mx-0 px-0 flex flex-wrap">
                    <div class="w-full mb-6 md:mb-0">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="product_name">
                        Item Name
                        </label>
                        <input class="appearance-none block w-full bg-gray-50 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="product_name" type="text" name="product_name" value="{{ $id != null ? $item->product_name : '' }}" required>
                    </div>
                </div>
                <div class="mt-5 mb-5 mx-0 px-0 flex flex-wrap justify-between">
                    <div class="w-5/12 mb-6 md:mb-0">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2 ml-1" for="category">
                        Category
                        </label>
                        <select id="category" class="appearance-none block w-full bg-gray-50 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" name="category" value="{{ $id != null ? strtoupper($item->category) : '' }}">
                            <option value="beverages" {{ $id != null && $item->category == 'beverages' ? 'selected' : '' }}>Beverages</option>
                            <option value="bread/bakery" {{ $id != null && $item->category == 'bread/bakery' ? 'selected' : '' }}>Bread/Bakery</option>
                            <option value="canned/jarred goods" {{ $id != null && $item->category == 'canned/jarred goods' ? 'selected' : '' }}>Canned/Jarred Goods</option>
                            <option value="dairy" {{ $id != null && $item->category == 'dairy' ? 'selected' : '' }}>Dairy</option>
                            <option value="dry/baking goods" {{ $id != null && $item->category == 'dry/baking goods' ? 'selected' : '' }}>Dry/Baking Goods</option>
                            <option value="paper goods" {{ $id != null && $item->category == 'paper goods' ? 'selected' : '' }}>Paper Goods</option>
                            <option value="personal care" {{ $id != null && $item->category == 'personal care' ? 'selected' : '' }}>Personal Care</option>
                            <option value="snacks" {{ $id != null && $item->category == 'snacks' ? 'selected' : '' }}>Snacks</option>
                            <option value="other" {{ $id != null && $item->category == 'other' ? 'selected' : '' }}>Other</option>
                        </select>
                    </div>
                    <div class="w-2/12 mb-6 md:mb-0">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2 ml-1" for="qty">
                        Qty
                        </label>
                        <input class="appearance-none block w-full bg-gray-50 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="qty" type="text" name="qty" value="{{ $id != null ? $item->qty : '' }}" required>
                    </div>
                    <div class="w-4/12 mb-6 md:mb-0">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2 ml-1" for="expiration">
                        Expiration
                        </label>
                        <input class="appearance-none block w-full bg-gray-50 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="expiration" datepicker datepicker-format="mm/dd/yy" type="date" name="expiration" value="{{ $id != null ? $item->expiration : '' }}" required>
                    </div>
                </div>
                <div class="mt-5 mb-5 mx-0 px-0 flex flex-wrap justify-start">
                    <div class="w-50 mb-6 mr-4 md:mb-0">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="purchase_unit_price">
                        Purchase Price
                        </label>
                        <input class="appearance-none block w-full bg-gray-50 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="purchase_unit_price" type="text" name="purchase_unit_price" value="{{ $id != null ? $item->purchase_unit_price : '' }}" required>
                    </div>
                    <div class="w-50 mb-6 md:mb-0">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="selling_unit_price">
                        Selling Price
                        </label>
                        <input class="appearance-none block w-full bg-gray-50 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="selling_unit_price" type="text" name="selling_unit_price" value="{{ $id != null ? $item->selling_unit_price : '' }}" required>
                    </div>
                </div>
                <div class="flex flex-row justify-end py-2">
                    <x-danger-button class="mr-2" wire:click="$dispatch('closeModal')">
                        {{ __('Cancel') }}
                    </x-danger>
                    @if ($id != null)
                        <x-button type=submit>
                            {{ __('Update') }}
                        </x-button>
                    @else
                        <x-button type=submit id="ajaxSubmit">
                            {{ __('Save') }}
                        </x-button>
                    @endif
                </div>
            @else
            @method('DELETE')
                <div class="my-3 text-sm text-gray-600">
                    Are you sure you want to delete Item: {{ $item->id }} ?
                </div>
                <div class="flex flex-row justify-end py-2" wire:click="$toggle('item-form')">
                    <x-button class="mr-2" wire:click="$dispatch('closeModal')" >
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
