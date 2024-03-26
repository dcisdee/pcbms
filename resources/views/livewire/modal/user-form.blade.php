
<div class="px-6 py-4">
    <div class="mt-2 text-lg font-medium text-gray-900">
        @if($id == null || $action == 'accounts.store')
            Add Account
        @else
            @if ($action == 'accounts.update')
                Edit Account
            @elseif ($action == 'accounts.destroy')
                Delete Account
            @endif
        @endif
    </div>
    <div class="mt-4 text-sm text-gray-600">
        <form class="w-full" action="{{ $id != null ? route($action, $id) : $action }}" method="POST">
            @csrf

            @if ($action != 'accounts.destroy' )
                @method('PUT')
                <div>
                    <x-label for="personnel_id" value="{{ __('Personnel ID') }}" />
                    <x-input id="personnel_id" class="block mt-1 w-full" type="number" name="personnel_id" :value="$id != null ? $account->personnel_id : '' " required autofocus />
                </div>

                <div class="mt-4">
                    <x-label for="email" value="{{ __('Email') }}" />
                    <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="$id != null ? $account->email : '' " required autocomplete="username" />
                </div>

                @if($id == null)
                    <div class="mt-4">
                        <x-label for="password" value="{{ __('Password') }}" />
                        <x-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
                    </div>
                @endif

                <div class="mt-4">
                    <label for="is_admin" class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2 ml-1">
                        Access
                    </label>
                    <div class="grid w-full grid-cols-2 gap-1 rounded-xl bg-gray-200 p-1">
                        <div>
                            <input type="radio" name="is_admin" id="1" value="1" class="peer hidden" {{ $id != null ? $account->is_admin == 1 ? 'checked' : '' : 'checked' }}/>
                            <label for="1" class="block cursor-pointer select-none rounded-xl py-3 px-8  uppercase tracking-wide text-gray-700 text-xs font-bold text-center peer-checked:bg-emerald-500 peer-checked:font-bold peer-checked:text-white">Admin</label>
                        </div>
                        <div>
                            <input type="radio" name="is_admin" id="0" value="0" class="peer hidden"  {{ $id != null && $account->is_admin == 0 ? 'checked' : ''}} />
                            <label for="0" class="block cursor-pointer select-none rounded-xl py-3 px-8  uppercase tracking-wide text-gray-700 text-xs font-bold text-center peer-checked:bg-emerald-500 peer-checked:font-bold peer-checked:text-white">Sales</label>
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-end mt-4">
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
                    Are you sure you want to delete Account: {{ $account->id }}?
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
