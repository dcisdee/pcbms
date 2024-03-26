<div x-data="{ cash: '' , change: ''}">
    <div class="px-6 py-4 text-sm text-gray-600">
        <div class="flex mt-2 mb-3">
            <span class="bg-green-500" x-text="form_data.grand_total"></span>
            <div class="w-4/12">
                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="cash">
                    Cash :
                </label>
            </div>
            <div class="w-7/12">
                <input x-model="cash" x-on:input="(change = cash - {{ $grandTotal }}).toFixed(2)" class="appearance-none block w-full bg-gray-50 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="cash" type="text" name="cash" required>
            </div>
        </div>
        <div class="flex mt-2 mb-3">
            <div class="w-4/12">
                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grand_total">
                    Grand Total :
                </label>
            </div>
            <div class="w-7/12">
                <input class="appearance-none block w-full bg-gray-50 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="grand_total" type="text" name="grand_total" value="{{ $grandTotal }}" readonly >
            </div>
        </div>
        <hr class="h-px my-8 bg-gray-200 border-0 dark:bg-gray-700">
        <div class="flex mt-2 mb-3">
            <div class="w-4/12">
                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="change">
                    Change :
                </label>
            </div>
            <div class="w-7/12">
                <input x-model="change" class="appearance-none block w-full bg-gray-50 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="change" type="text" name="change" readonly>
            </div>
        </div>
    </div>
    <div class="flex flex-row justify-end py-4 px-6 bg-gray-100 text-end">
        <x-danger-button class="mr-2" wire:click="$dispatch('closeModal')">
            {{ __('Cancel') }}
        </x-danger>
        <button class="h-12 w-full px-5 transition-colors duration-150 text-white font-semibold tracking-wider bg-green-600 rounded-lg focus:shadow-outline hover:bg-emerald-700" type="submit">
            Checkout
        </button>
    </div>
</div>
