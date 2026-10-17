@props([
    'name' => 'images',
    'label' => null,
    'existing' => [],
    'accept' => 'image/jpeg,image/png,image/webp',
    'maxFiles' => 10,
])

<div x-data="{
        files: [],
        previews: [],
        input: null,
        handleFiles(event) {
            this.input = event.target;
            this.previews.forEach((preview) => URL.revokeObjectURL(preview.url));
            this.files = Array.from(event.target.files).slice(0, {{ $maxFiles }});
            this.previews = this.files.map((file, index) => ({
                id: `${file.name}-${file.size}-${file.lastModified}-${index}`,
                name: file.name,
                size: this.formatSize(file.size),
                url: URL.createObjectURL(file),
            }));
        },
        removeFile(id) {
            const index = this.previews.findIndex((preview) => preview.id === id);
            if (index < 0) return;

            URL.revokeObjectURL(this.previews[index].url);
            this.files.splice(index, 1);
            this.previews.splice(index, 1);

            if (this.input) {
                const transfer = new DataTransfer();
                this.files.forEach((file) => transfer.items.add(file));
                this.input.files = transfer.files;
            }
        },
        formatSize(bytes) {
            if (bytes < 1024) return `${bytes} B`;
            if (bytes < 1024 * 1024) return `${(bytes / 1024).toFixed(1)} KB`;
            return `${(bytes / (1024 * 1024)).toFixed(1)} MB`;
        },
    }" class="w-full space-y-3">
    @if ($label)
        <x-form.label :value="$label" />
    @endif

    <label for="{{ $name }}"
        class="flex min-h-32 w-full cursor-pointer flex-col items-center justify-center rounded-xl border border-dashed border-black/15 bg-[#F8F7F4] px-6 py-8 text-center transition hover:border-[#C89B3C] hover:bg-[#C89B3C]/5 dark:border-white/15 dark:bg-white/[0.03] dark:hover:bg-[#C89B3C]/10">
        <x-lucide-image-plus class="mb-3 h-8 w-8 text-black/40 dark:text-white/40" />
        <span class="text-sm font-medium text-black/70 dark:text-white/70">{{ __('Pilih atau seret gambar ke sini') }}</span>
        <span class="mt-1 text-xs text-black/45 dark:text-white/45">{{ __('JPG, PNG, atau WEBP · Maksimal 5 MB per gambar') }}</span>
        <input id="{{ $name }}" name="{{ $name }}[]" type="file" multiple accept="{{ $accept }}"
            class="sr-only" x-on:change="handleFiles($event)">
    </label>

    @if (count($existing) > 0)
        <div class="w-full space-y-2">
            @foreach ($existing as $media)
                <div class="flex w-full items-center gap-3 rounded-lg border border-black/5 bg-white p-2 shadow-sm dark:border-white/10 dark:bg-neutral-900">
                    <img src="{{ $media->getUrl('thumb') }}" alt="{{ $media->name }}" class="h-14 w-14 shrink-0 rounded-md object-cover sm:h-16 sm:w-16">
                    <div class="min-w-0 flex-1">
                        <p class="truncate text-sm font-medium text-black/75 dark:text-white/75">{{ $media->name }}</p>
                        <p class="mt-0.5 text-xs text-black/45 dark:text-white/45">{{ __('Gambar tersimpan') }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    <div x-show="previews.length > 0" x-cloak class="w-full space-y-2">
        <template x-for="preview in previews" :key="preview.id">
            <div class="flex w-full items-center gap-3 rounded-lg border border-black/5 bg-white p-2 shadow-sm dark:border-white/10 dark:bg-neutral-900">
                <img :src="preview.url" :alt="preview.name" class="h-14 w-14 shrink-0 rounded-md object-cover sm:h-16 sm:w-16">
                <div class="min-w-0 flex-1">
                    <p class="truncate text-sm font-medium text-black/75 dark:text-white/75" x-text="preview.name"></p>
                    <p class="mt-0.5 text-xs text-black/45 dark:text-white/45" x-text="preview.size"></p>
                </div>
                <button type="button" x-on:click="removeFile(preview.id)"
                    class="inline-flex h-9 w-9 shrink-0 items-center justify-center rounded-md text-black/45 transition hover:bg-red-50 hover:text-red-600 focus:outline-none focus:ring-2 focus:ring-red-400/30 dark:text-white/45 dark:hover:bg-red-500/10 dark:hover:text-red-400"
                    aria-label="{{ __('Hapus gambar') }}" title="{{ __('Hapus gambar') }}">
                    <x-lucide-x class="h-4 w-4" />
                </button>
            </div>
        </template>
    </div>

    <x-form.error :messages="$errors->get($name)" class="mt-2" />
    <x-form.error :messages="$errors->get($name.'.*')" class="mt-2" />
</div>
