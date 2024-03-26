@if (data_get($setUp, 'header.softDeletes'))
    <div
        x-data="{ open: false }"
        class="mr-0 sm:mr-2 mt-2 sm:mt-0"
        @click.outside="open = false"
    >
        <button
            @click.prevent="open = ! open"
            class="pg-btn-white
   "
        >
            <div class="flex">
                <x-livewire-powergrid::icons.trash class="text-pg-primary-500" />
            </div>
        </button>

        <div
            x-show="open"
            x-cloak
            x-transition:enter="transform duration-200"
            x-transition:enter-start="opacity-0 scale-90"
            x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transform duration-200"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-90"
            class="mt-2 py-2 w-48 bg-white shadow-xl absolute z-10"
        >

            <div
                x-on:click="$wire.dispatch('pg:softDeletes-{{ $tableName }}', {softDeletes: ''}); open = false"
                class="cursor-pointer flex justify-start block px-4 py-2 text-pg-primary-800 hover:bg-pg-primary-50 hover:text-black-200"
            >
                @lang('livewire-powergrid::datatable.soft_deletes.without_trashed')
            </div>
            <div
                x-on:click="$wire.dispatch('pg:softDeletes-{{ $tableName }}', {softDeletes: 'withTrashed'}); open = false"
                class="cursor-pointer flex justify-start block px-4 py-2 text-pg-primary-800 hover:bg-pg-primary-50 hover:text-black-200"
            >
                @lang('livewire-powergrid::datatable.soft_deletes.with_trashed')
            </div>
            <div
                x-on:click="$wire.dispatch('pg:softDeletes-{{ $tableName }}', {softDeletes: 'onlyTrashed'}); open = false"
                class="cursor-pointer flex justify-start block px-4 py-2 text-pg-primary-800 hover:bg-pg-primary-50 hover:text-black-200"
            >
                @lang('livewire-powergrid::datatable.soft_deletes.only_trashed')
            </div>

        </div>
    </div>
@endif
