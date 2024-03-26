
<div class="px-6 py-4 2xl">
    <div class="mt-2 text-xl justify-center font-semibold text-gray-800">
        @if($id == null || $action == 'personnels.store')
            Add Personnel
        @else
            @if ($action == 'personnels.update')
                Edit Personnel
            @elseif ($action == 'personnels.destroy')
                Delete Personnel
            @endif
            : {{ $personnel->id }}
        @endif
    </div>
    <div class="mt-5 text-sm text-gray-600">
        <form class="w-full" action="{{ $id != null ? route($action, $id) : $action }}" method="POST">
            @csrf
            @if ($action != 'personnels.destroy' )
            @method('PUT')
                <div class="mt-5 mb-5 mx-0 px-0 flex flex-wrap justify-between">
                    <div class="w-5/12 mb-6 md:mb-0">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2 ml-1" for="first_name">
                        First Name
                        </label>
                        <input class="appearance-none block w-full bg-gray-50 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="first_name" type="text" name="first_name" value="{{ $id != null ? $personnel->first_name : '' }}" required>
                    </div>
                    <div class="w-16 mb-6 md:mb-0">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2 ml-1" for="mid_initial">
                        M. I.
                        </label>
                        <input class="appearance-none block w-full bg-gray-50 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="mid_initial" type="text" name="mid_initial" value="{{ $id != null ? $personnel->mid_initial : '' }}" required>
                    </div>
                    <div class="w-5/12 mb-6 md:mb-0">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2 ml-1" for="last_name">
                        Last Name
                        </label>
                        <input class="appearance-none block w-full bg-gray-50 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="last_name" type="text" name="last_name"  value="{{ $id != null ? $personnel->last_name : '' }}" required>
                    </div>
                </div>
                <div class="mt-5 mb-5 mx-0 px-0 flex flex-wrap justify-start">
                    <div class="w-5/12 mb-6 md:mb-0">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2 ml-1" for="grid-last-name">
                        Position
                        </label>
                        <div class="grid w-full grid-cols-2 gap-1 rounded-xl bg-gray-200 p-1">
                            <div>
                                <input type="radio" name="is_admin" id="1" value="1" class="peer hidden" {{ $id != null ? $personnel->is_admin == 1 ? 'checked' : '' : 'checked' }}/>
                                <label for="1" class="block cursor-pointer select-none rounded-xl p-2 text-center peer-checked:bg-emerald-500 peer-checked:font-bold peer-checked:text-white">Manager</label>
                            </div>
                            <div>
                                <input type="radio" name="is_admin" id="0" value="0" class="peer hidden"  {{ $id != null && $personnel->is_admin == 0 ? 'checked' : ''}} />
                                <label for="0" class="block cursor-pointer select-none rounded-xl p-2 text-center peer-checked:bg-emerald-500 peer-checked:font-bold peer-checked:text-white">Sales</label>
                            </div>
                        </div>
                    </div>
                    <div class="w-4/12 mb-6 ml-5 md:mb-0">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2 ml-1" for="sex">
                        Sex
                        </label>
                        <div class="grid w-full grid-cols-2 gap-1 rounded-xl bg-gray-200 p-1">
                            <div>
                                <input type="radio" name="sex" id="male" value="male" class="peer hidden" {{  $id != null ? ($personnel->sex === 'male' ? 'checked' : '') : 'checked' }} />
                                <label for="male" class="block cursor-pointer select-none rounded-xl p-2 text-center peer-checked:bg-cyan-500 peer-checked:font-bold peer-checked:text-white">Male</label>
                            </div>

                            <div>
                                <input type="radio" name="sex" id="female" value="female" class="peer hidden"  {{ $id != null && $personnel->sex === 'female' ? 'checked' : '' }}/>
                                <label for="female" class="block cursor-pointer select-none rounded-xl p-2 text-center peer-checked:bg-pink-500 peer-checked:font-bold peer-checked:text-white">Female</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-5 mb-5 mx-0 px-0 flex flex-wrap justify-between">
                    <div class="w-7/12 mb-6 pr-3 md:mb-0">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="email">
                        Email
                        </label>
                        <input class="appearance-none block w-full bg-gray-50 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="email" type="email" name="email"  value="{{ $id != null ? $personnel->email : '' }}" >
                    </div>
                    <div class="w-5/12 mb-6 md:mb-0">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="phone">
                        Phone
                        </label>
                        <input class="appearance-none block w-full bg-gray-50 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="phone" type="number" name="phone" value="{{ $id != null ? $personnel->phone : '' }}" maxlength="11" required>
                    </div>
                </div>
                <div class="mt-5 mb-4 mx-0 px-0 flex flex-wrap">
                    <div class="w-full mb-6 md:mb-0">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="address">
                        Address
                        </label>
                        <input class="appearance-none block w-full bg-gray-50 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="address" type="text" name="address"  value="{{ $id != null ? $personnel->address : '' }}" required>
                    </div>
                </div>
                <div class="flex flex-row justify-end pt-2">
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
            @method('DELETE')
                <div class="my-3 text-sm text-gray-600">
                    Are you sure you want to delete Personnel: {{ $personnel->id }}? This will also delete Personnel {{ $personnel->id }} 's account.
                </div>
                <div class="flex flex-row justify-end py-2" wire:click="$toggle('personnel-form')">
                    <x-button class="mr-2" wire:click="$dispatch('closeModal')">
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
