@props([
    'form' => 'bulk-form',
])

<div
    x-cloak
    x-show="selected.length > 0"
    x-transition
    class="border-b border-black/5 bg-[#C89B3C]/5 px-4 py-3 dark:border-white/10 sm:px-6"
>
    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <p class="text-sm text-black/70 dark:text-white/70">
            <span class="font-medium text-black dark:text-white" x-text="selected.length">0</span>
            {{ __('dipilih') }}
        </p>

        <div class="flex flex-col gap-2 sm:flex-row">
            {{ $slot }}
        </div>
    </div>
</div>

<form
    id="{{ $form }}"
    x-ref="bulkForm"
    method="POST"
    x-bind:action="bulkAction"
    class="hidden"
>
    @csrf
    <input type="hidden" name="_method" x-bind:value="bulkMethod">
</form>
