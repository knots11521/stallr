<div class="max-w-xl mx-auto space-y-6">

    @if (session()->has('success'))
        <div class="rounded-[5px] bg-green-100 p-4 text-sm text-green-700">
            {{ session('success') }}
        </div>
    @endif

    @if (session()->has('error'))
        <div class="rounded-[5px] bg-red-100 p-4 text-sm text-red-700">
            {{ session('error') }}
        </div>
    @endif


    <form wire:submit="submit" class="space-y-6">


        <!-- Business Name -->
        <div>

            <x-input-label for="business_name" value="Business Name" />

            <x-text-input id="business_name" type="text" class="mt-1 block w-full" wire:model="business_name"
                autofocus />

            <x-input-error :messages="$errors->get('business_name')" class="mt-2" />

        </div>



        <!-- Description -->
        <div>

            <x-input-label for="description" value="Description" />


            <textarea id="description" wire:model="description" rows="5"
                class="
                    mt-1
                    block
                    w-full
                    rounded-[5px]
                    border-gray-300
                    shadow-sm
                    focus:border-indigo-500
                    focus:ring-indigo-500
                "></textarea>


            <x-input-error :messages="$errors->get('description')" class="mt-2" />

        </div>



        <div class="flex items-center gap-4">

            <x-primary-button>
                Submit Application
            </x-primary-button>


            @if (session()->has('success'))
                <span class="text-sm text-gray-600">
                    Saved successfully.
                </span>
            @endif

        </div>


    </form>

</div>
