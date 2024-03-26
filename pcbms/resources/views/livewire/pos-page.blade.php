<div x-data="{form_data: {} }">
    <div class="m-0 p-0">
        <div class="relative min-w-screen h-screen pb-10 bg-slate-400 overflow-hidden">
            <x-banner />
            <form action="{{ route('pos.store') }}" method="POST">
            @csrf
            @method('PUT')

                <input type="hidden" id="transaction_status" name="transaction_status" value="successful">
                <div class="flex mt-0 h-[34.5rem]">
                    <div class="w-7/12">
                        {{-- PERSONNEL INFO --}}
                        <div class="mr-2 h-[6.9rem] bg-gray-200 shadow-sm">
                            <div class="flex m-0 p-0 justify-start">
                                <div class="w-5/12 m-0 p-0">
                                    <span class="">
                                        <img src="\image\pcbms-logo-2.png" alt="pcbms-logo">
                                    </span>
                                </div>
                                <div class="w-6/12 mx-5 mr-0 pt-2">
                                    <div class="flex">
                                        <div class="w-12 mr-2 py-1">
                                            <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-last-name"> Date : </label>
                                        </div>
                                        <div class="w-32">
                                            <input class="appearance-none block w-full bg-gray-50 text-gray-700 text-xs border border-gray-200 rounded py-1 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="pos_date" type="text" name="pos_date" value="{{ date('m-d-Y') }}" readonly >
                                        </div>
                                        <div class="w-12 ml-5 mr-2 ">
                                            <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-last-name"> Time : </label>
                                        </div>
                                        <div class="w-32">
                                            <input class="appearance-none block w-full bg-gray-50 text-gray-700 text-xs border border-gray-200 rounded py-1 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="pos_time" type="text" name="pos_time" value="{{ date('H:i A') }}" readonly >
                                        </div>
                                    </div>
                                    <div class="flex mt-1">
                                        <div class="w-32 mr-1 py-1">
                                            <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-last-name">
                                                Personnel ID :
                                            </label>
                                        </div>
                                        <div class="w-64">
                                            <input class="appearance-none block w-full bg-gray-50 text-gray-700 text-xs border border-gray-200 rounded py-1 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="personnel_id" type="text" name="personnel_id"  value="{{ Auth::user()->personnel->id }}" readonly >
                                        </div>
                                    </div>
                                    <div class="flex">
                                        <div class="w-32 py-1 mr-1">
                                            <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-last-name">
                                                Personnel Name :
                                            </label>
                                        </div>
                                        <div class="w-64">
                                            <input class="appearance-none block w-full bg-gray-50 text-gray-700 text-xs border border-gray-200 rounded py-1 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="personnel_name" type="text" name="personnel_name" value="{{ Auth::user()->personnel->getFullname() }}" readonly >
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- ITEM TABLE --}}
                        <div class="h-[27rem] p-2 bg-gray-200 mt-2 mr-2">
                            <div class="w-full md:overflow-x-hidden">
                                <div class="bg-white m-0 p-0 overflow-hidden shadow-xl">
                                    <livewire:pos-item-table/>
                                </div>
                            </div>
                        </div>

                        <div class="px-3 flex py-1.5 bg-slate-900">
                            <div class="w-1/3">

                            </div>

                            <div class="w-1/3 mx-3 py-2 transition-colors duration-150 text-white text-center font-semibold tracking-wider  rounded-lg focus:shadow-outline bg-lime-700  hover:bg-lime-600">
                                <a href="{{ route('sales.index') }}">
                                    Sales
                                </a>
                            </div>

                            <div class="w-1/3 mx-3 py-2 transition-colors duration-150 text-white text-center font-semibold tracking-wider  rounded-lg focus:shadow-outline bg-lime-700  hover:bg-lime-600">
                                <a href="{{ route('items.index') }}">
                                    Inventory
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="w-5/12 m-0 p-0">
                        <div class="h-[6.9rem] ps-4 py-[2.5px] bg-gray-200 shadow-sm" x-data="{ cash: '0' , change: '0'}">
                            <div class="flex">
                                <div class="w-4/12 text-end pr-4">
                                    <label class="mt-[2px] ml-1 block uppercase tracking-wider text-base text-gray-700 font-bold" for="cash">
                                        Cash :
                                    </label>
                                </div>
                                <div class="w-7/12">
                                    <div class="rounded-md shadow-sm">
                                        <input x-model="cash"
                                                x-on:input="change = cash - {{ $grandTotal }}"
                                                type="text"
                                                name="cash"
                                                id="cash"
                                                class="block w-full rounded-md border-0 py-1 px-7 text-5xl text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6 text-end"
                                                aria-describedby="cash-currency"
                                                min="1"
                                                required>
                                    </div>
                                </div>
                            </div>
                            <div class="flex my-1">
                                <div class="w-4/12 text-end pr-4">
                                    <label class="mt-[2px] ml-1 block uppercase tracking-wider text-base text-gray-700 font-bold" for="grand_total">
                                        Grand Total :
                                    </label>
                                </div>
                                <div class="w-7/12">
                                    <div class="rounded-md shadow-sm">
                                        <input  type="text"
                                                name="grand_total"
                                                id="grand_total"
                                                class="block w-full rounded-md border-0 py-1 px-7 text-5xl text-white ring-1 ring-inset bg-black ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6 text-end"
                                                aria-describedby="grand_total-currency"
                                                value="{{ $grandTotal }}"
                                                min="1"
                                                required>
                                    </div>
                                </div>
                            </div>
                                <div class="flex my-1">
                                    <div class="w-4/12 text-end pr-4">
                                        <label class="mt-[2px] ml-1 block uppercase tracking-wider text-base text-gray-700 font-bold" for="change">
                                            Change :
                                        </label>
                                    </div>
                                    <div class="w-7/12">
                                        <span class="block w-full rounded-md border-0 py-1 px-7 text-5xl bg-white text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6 text-end h-8"
                                        aria-describedby="cash-currency"
                                        x-model="change"
                                        x-on:input="change = parseFloat(change).toFixed(2)"
                                        x-text="change"
                                        ></span>
                                        <input x-model="change"
                                                type="hidden"
                                                name="change"
                                                id="change"
                                                aria-describedby="grand_total-currency"
                                                min="1"
                                                required>
                                    </div>
                            </div>
                        </div>


                        {{-- ORDER TABLE --}}
                        <div class="h-[27rem] px-2 mt-2 bg-gray-200 border-2 border-gray-200 ">
                            <livewire:pos-order-table/>
                        </div>

                        <div class="flex py-1.5 bg-slate-900">
                            <div wire:click:prevent="resetForm"
                                 class="w-1/2 mx-2 py-2 transition-colors duration-150 text-white text-center font-semibold tracking-wider  rounded-lg focus:shadow-outline bg-red-700  hover:bg-red-600">
                                <a href="{{ route('pos') }}">
                                    Void
                                </a>
                            </div>

                            <button type="submit" class="w-1/2 mx-2 py-2 transition-colors duration-150 text-white text-center font-semibold tracking-wider  rounded-lg focus:shadow-outline bg-lime-700  hover:bg-lime-600">
                                Checkout
                            </button>
                        </div>
                    </div>
                </div>
            </form>
            <div class="absolute flex w-[15rem] h-[3rem] mx-0 px-0 py-1 inset-x-0 bottom-0">
                <form method="POST" action="{{ route('logout') }}" x-data>
                    @csrf
                    <button href="{{ route('logout') }}"
                            @click.prevent="$root.submit();"
                            class="w-[14rem] mx-2 py-2 transition-colors duration-150 text-white text-center font-semibold tracking-wider  rounded-lg focus:shadow-outline bg-slate-700  hover:bg-slatex-600">
                        Logout
                    </button>
                </form>
            </div>

        </div>
    </div>
</div>



