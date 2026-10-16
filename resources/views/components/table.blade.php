@props([
    'hasData' => true,
    'selectable' => false,
    'ids' => [],
    'blockedIds' => [],
])

@php
    $ids = array_values((array) $ids);
    $blockedIds = array_values((array) $blockedIds);
@endphp

<div
    @if ($selectable)
        x-data="{
            selected: [],
            ids: @js($ids),
            blockedIds: @js($blockedIds),
            bulkAction: '',
            bulkMethod: 'POST',
            toggleAll(checked) {
                this.selected = checked ? [...this.ids] : [];
            },
            allSelected() {
                return this.ids.length > 0 && this.selected.length === this.ids.length;
            },
            allBlocked() {
                return this.selected.length > 0
                    && this.selected.every((id) => this.blockedIds.includes(id));
            },
            async submitBulk(button) {
                const action = button.dataset.action;
                const method = button.dataset.method || 'POST';
                const confirm = button.dataset.confirm;

                if (confirm) {
                    const proceed = await window.confirmAction({
                        text: confirm,
                        icon: 'warning',
                        danger: button.dataset.danger === 'true',
                    });

                    if (! proceed) {
                        return;
                    }
                }

                this.bulkAction = action;
                this.bulkMethod = method;

                await this.$nextTick();

                this.$refs.bulkForm.submit();
            },
        }"
    @endif
    {{ $attributes->merge(['class' => 'w-full max-w-full overflow-hidden rounded-2xl border border-black/5 bg-white shadow-sm dark:border-white/10 dark:bg-neutral-950']) }}
>
    @isset($toolbar)
        <div class="border-b border-black/5 p-4 dark:border-white/10 sm:p-6">
            {{ $toolbar }}
        </div>
    @endisset

    @isset($bulk)
        {{ $bulk }}
    @endisset

    @if ($hasData)
        <div class="theme-scrollbar relative w-full max-w-full overflow-x-auto">
            <table class="w-full min-w-[40rem] text-left text-sm">
                @isset($head)
                    <thead class="border-b border-black/5 bg-[#F8F7F4] text-xs uppercase tracking-wide text-black/55 dark:border-white/10 dark:bg-white/[0.03] dark:text-white/55">
                        {{ $head }}
                    </thead>
                @endisset
                <tbody class="divide-y divide-black/5 dark:divide-white/10">
                    {{ $body ?? '' }}
                </tbody>
            </table>
        </div>
    @else        <div class="px-6 py-14 text-center text-sm text-black/50 dark:text-white/50">
            {{ $empty ?? __('Tidak ada data.') }}
        </div>
    @endif

    @isset($pagination)
        <div class="border-t border-black/5 px-4 py-4 dark:border-white/10 sm:px-6">
            {{ $pagination }}
        </div>
    @endisset
</div>
