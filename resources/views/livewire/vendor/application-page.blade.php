@if ($application)

    @if ($application->status === 'pending')
        <div
            class="flex items-start gap-4 p-5 rounded-[10px] border border-amber-200/60 bg-amber-50 dark:bg-amber-950/30 dark:border-amber-900/50 shadow-2xs">

            <!-- Clock Icon -->
            <svg xmlns="http://www.w3.org/2000/svg" class="shrink-0 w-6 h-6 text-amber-600 dark:text-amber-400 mt-0.5"
                fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>

            <div>
                <h2 class="font-bold text-base text-amber-900 dark:text-amber-200 tracking-tight">
                    Application Pending
                </h2>
                <p class="mt-1 text-sm text-amber-700 dark:text-amber-400/90 leading-relaxed">
                    Your store application is currently being reviewed. Please wait for approval before accessing vendor
                    features.
                </p>
            </div>

        </div>
    @elseif ($application->status === 'approved')
        <div
            class="flex items-start gap-4 p-5 rounded-[10px] border border-teal-200/60 bg-teal-50 dark:bg-teal-950/30 dark:border-teal-900/50 shadow-2xs">

            <!-- Check Circle Icon -->
            <svg xmlns="http://www.w3.org/2000/svg" class="shrink-0 w-6 h-6 text-teal-600 dark:text-teal-400 mt-0.5"
                fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>

            <div>
                <h2 class="font-bold text-base text-teal-900 dark:text-teal-200 tracking-tight">
                    Your Store Is Active
                </h2>
                <p class="mt-1 text-sm text-teal-700 dark:text-teal-400/90 leading-relaxed">
                    You already have an approved store. You can now start managing your products and sales.
                </p>
            </div>

        </div>
    @elseif ($application->status === 'rejected')
        <div
            class="flex items-start gap-4 p-5 rounded-[10px] border border-red-200/60 bg-red-50 dark:bg-red-950/30 dark:border-red-900/50 shadow-2xs">

            <!-- X Circle Icon -->
            <svg xmlns="http://www.w3.org/2000/svg" class="shrink-0 w-6 h-6 text-red-600 dark:text-red-400 mt-0.5"
                fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>

            <div>
                <h2 class="font-bold text-base text-red-900 dark:text-red-200 tracking-tight">
                    Application Rejected
                </h2>
                <p class="mt-1 text-sm text-red-700 dark:text-red-400/90 leading-relaxed">
                    Unfortunately, your application was not approved. You may submit a new application when you are
                    ready.
                </p>
            </div>

        </div>
    @endif
@else
    <!-- Wrapped the fallback form in a consistent Neo-Flat card -->
    <div
        class="bg-white dark:bg-[#1A1A1A] border border-stone-200/80 dark:border-stone-800/80 rounded-[10px] shadow-2xs overflow-hidden transition duration-200">
        <livewire:vendor.application-form />
    </div>

@endif
