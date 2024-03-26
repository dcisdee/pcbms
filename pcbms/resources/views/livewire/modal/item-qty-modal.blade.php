<div x-data="{ itemQty: '' }">
    <div class="px-6 py-4">
        <div class="mt-2 text-lg font-medium text-gray-900">
            Enter number of items:
        </div>
        <div class="mt-4 text-sm text-gray-600">
            <input x-model="itemQty" class="appearance-none block w-full bg-gray-50 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="item_qty" type="number" name="item_qty" min="1" max="{{ $item->qty }}">
            @error('item_qty')
                <span class="text-red-500">{{ $message }}</span>
            @enderror
        </div>

    </div>
    <div class="flex flex-row justify-end py-4 px-6 bg-gray-100 text-end">
        <x-danger-button class="mr-2" wire:click="$dispatch('closeModal')">
            {{ __('Cancel') }}
        </x-danger>
        <x-button wire:click="sendItemToOrder(itemQty)">
            {{ __('Add') }}
        </x-button>
    </div>
</div>


