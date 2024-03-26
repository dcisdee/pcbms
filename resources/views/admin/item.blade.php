<div>
    <x-app-layout>
        <x-slot name="header" class="w-100">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Items') }}
            </h2>
        </x-slot>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white p-8 overflow-hidden shadow-xl sm:rounded-lg">
                    <livewire:datatable.item-table/>
                </div>
            </div>
        </div>
    </x-app-layout>
</div>
