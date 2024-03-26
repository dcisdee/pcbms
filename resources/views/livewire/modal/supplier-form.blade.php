
<div class="px-6 py-4">
    <div class="mt-2 text-lg font-medium text-gray-900">
        @if($id == null || $action == 'suppliers.store')
            Add Supplier
        @else
            @if ($action == 'suppliers.update')
                Edit Supplier
            @elseif ($action == 'suppliers.destroy')
                Delete Supplier
            @endif
        @endif
    </div>
    <div class="mt-4 text-sm text-gray-600">
        <form class="w-full" action="{{ $id != null ? route($action, $id) : $action }}" method="POST">
            @csrf
            @if ($action != 'suppliers.destroy' )
            @method('PUT')
                <div class="mt-5 mb-5 flex flex-wrap">
                    <div class="w-full  mb-6 md:mb-0">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-last-name">
                        Company
                        </label>
                        <input class="appearance-none block w-full bg-gray-50 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="company" type="text" name="company" value="{{ $id != null ? $supplier->company : '' }}" required>
                    </div>
                </div>
                <div class="mt-5 mb-5 flex flex-wrap">
                    <div class="w-full  mb-6 md:mb-0">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-last-name">
                        Phone
                        </label>
                        <input class="appearance-none block w-full bg-gray-50 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="phone" type="number" name="phone" value="{{ $id != null ? $supplier->phone : '' }}" required>
                    </div>
                </div>
                <div class="mt-5 mb-4 flex flex-wrap">
                    <div class="w-full  mb-6 md:mb-0">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-last-name">
                        Address
                        </label>
                        <input class="appearance-none block w-full bg-gray-50 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="address" type="text" name="address" value="{{ $id != null ? $supplier->address : '' }}" required>
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
                        <x-button type=submit>
                            {{ __('Save') }}
                        </x-button>
                    @endif
                </div>
            @else
            @method('DELETE') <div class="my-3 text-sm text-gray-600">
                    Are you sure you want to delete Supplier: {{ $supplier->id }}?
                </div>
                <div class="flex flex-row justify-end py-2" wire:click="$toggle('supplier-form')">
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
