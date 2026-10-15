# KNOWLEDGE GUIDEBOOK

This guidebook is the working reference for developers and AI agents on the
Kadua App. It documents the reusable pieces of the codebase and how to extend
them without breaking existing conventions.

Sections:

1. Navigation And RBAC
2. Permission Enum (Extending Permissions)
3. Reusable Datatable
4. SweetAlert2 Alerts

---

## 1. Navigation And RBAC

### 1.1 Define Navigation Items in the Component

Keep navigation configuration in `app/View/Components/Navigation.php`. Blade
partials should render the prepared items and should not contain role or
permission rules.

### 1.2 Use Permissions Instead of Role Names

Use stable permission names because role names may change. Roles should group
permissions through Spatie Laravel Permission.

#### Example 1.2.1: Single Menu

```php
[
    'label' => __('Example'),
    'href' => route('example.index'),
    'active' => request()->routeIs('example.*'),
    'permission' => 'example.view',
    'children' => [],
]
```

Use `permission => null` only for items available to every authenticated user.
Every item must include `children`, even when it is an empty array.

### 1.3 Add Nested Navigation Items

Use `children` for a parent menu. Each child follows the same structure and
may define a different permission.

#### Example 1.3.1: Menu With Children

```php
[
    'label' => __('Example'),
    'href' => '#',
    'active' => request()->routeIs('example.*'),
    'permission' => 'example.view',
    'children' => [
        [
            'label' => __('Sub Example'),
            'href' => route('sub.example'),
            'active' => request()->routeIs('sub.example'),
            'permission' => 'sub.example.view',
            'children' => [],
        ],
    ],
]
```

`Visible()` filters inaccessible items recursively. A parent remains visible
when at least one child is accessible.

### 1.4 Protect Routes Separately

Hiding a navigation item is not access control. Protect the matching route with
the same permission.

#### Example 1.4.1: Protected Route

```php
Route::get('/example', ProjectController::class)
    ->middleware(['auth', 'permission:example.view'])
    ->name('example.index');
```

Assign permissions to roles instead of coupling navigation to role names.

#### Example 1.4.2: Assign Permission to a Role

```php
$role->givePermissionTo('example.view');
```

---

## 2. Permission Enum (Extending Permissions)

Permissions are **code-defined**, not free CRUD. The single source of truth is
`app/Enums/Permission.php`. Never create permissions from the UI.

### 2.1 Anatomy of the Enum

```php
enum Permission: string
{
    case UsersView = 'users.view';

    public function feature(): string  // grouping label shown in the Role form UI
    public function label(): string    // human action label: Lihat / Buat / Edit / Hapus
}
```

Two metadata methods drive the UI:

- `feature()` groups permissions under a feature heading (e.g. `Pengguna`).
- `label()` renders the human action (e.g. `users.view` → `Lihat`).

### 2.2 Add a New Permission

To add, for example, `products.export`:

1. **Add a case** to `app/Enums/Permission.php`:

   ```php
   case ProductsExport = 'products.export';
   ```

2. **Add it to `feature()`** so it groups under the right feature:

   ```php
   self::ProductsView, self::ProductsExport => 'Produk',
   ```

3. **Add it to `label()`**:

   ```php
   self::ProductsExport => 'Ekspor',
   ```

4. **Sync to the database** (creates the permission and grants it to
   `Administrator`):

   ```bash
   php artisan db:seed --class=KaduaSeeder --no-interaction
   ```

5. **Protect the route and guard the UI** with the same name:

   ```php
   Route::post('/app/products/export', ExportProductController::class)
       ->middleware(['auth', 'permission:products.export'])
       ->name('settings.products.export');
   ```

   ```blade
   @can('products.export')
       ...
   @endcan
   ```

### 2.3 How It Reaches the Database

`database/seeders/KaduaSeeder.php` iterates `Permission::cases()`, calls
`Permission::findOrCreate($permission->value)`, then syncs the `Administrator`
role. The seeder is idempotent — running it again only adds what is missing.

> The Role management form builds its checkboxes from `Permission::cases()`
> grouped by `feature()`. A permission that is not in the enum will never show
> up in that UI, so always start from the enum.

---

## 3. Reusable Datatable

The datatable is a headless set of Blade components under
`resources/views/components/datatable/`. It has no JS dependency for its core
structure; layout is handled by Tailwind and the dropdown uses Alpine.

```text
datatable/
├── table.blade.php            → x-datatable.table      (entry point / wrapper)
├── toolbar.blade.php          → x-datatable.toolbar    (GET form)
├── search.blade.php           → x-datatable.search     (search input)
├── filter.blade.php           → x-datatable.filter     (dropdown filter)
├── reset.blade.php            → x-datatable.reset      (X reset button)
└── actions/
    ├── menu.blade.php         → x-datatable.actions.menu   (⋮ dropdown container)
    └── item.blade.php         → x-datatable.actions.item   (single action row)
```

### 3.1 Minimal Skeleton

```blade
<x-datatable.table :has-data="$models->isNotEmpty()">
    <x-slot name="toolbar">
        <x-datatable.toolbar :action="route('settings.models.index')">
            <x-datatable.search :value="$search" :placeholder="__('Cari...')" />
            <x-datatable.filter name="status" :selected="$status" :options="[...]" />
            @if ($search !== '' || $status !== '')
                <x-datatable.reset :href="route('settings.models.index')" />
            @endif
        </x-datatable.toolbar>
    </x-slot>

    <x-slot name="head">
        <tr>
            <th class="whitespace-nowrap px-6 py-4">{{ __('Nama') }}</th>
            <th class="w-16 px-6 py-4"><span class="sr-only">{{ __('Aksi') }}</span></th>
        </tr>
    </x-slot>

    <x-slot name="body">
        @foreach ($models as $model)
            <tr class="text-black/75 dark:text-white/75">
                <td class="whitespace-nowrap px-6 py-4">{{ $model->name }}</td>
                <td class="px-6 py-4">
                    <x-datatable.actions.menu>
                        <x-datatable.actions.item :href="route('settings.models.edit', $model)" icon="pencil">
                            {{ __('Edit') }}
                        </x-datatable.actions.item>
                    </x-datatable.actions.menu>
                </td>
            </tr>
        @endforeach
    </x-slot>

    <x-slot name="empty">{{ __('Belum ada data.') }}</x-slot>

    @if ($models->hasPages())
        <x-slot name="pagination">{{ $models->links() }}</x-slot>
    @endif
</x-datatable.table>
```

### 3.2 `x-datatable.table` (entry point)

| Prop | Type | Default | Purpose |
| --- | --- | --- | --- |
| `has-data` | bool | `true` | When `false`, renders the `empty` slot instead of the table. |

Slots: `toolbar`, `head`, `body`, `empty`, `pagination`.

- Pass `:has-data="$models->isNotEmpty()"` so an empty result shows the `empty`
  slot instead of an empty table.
- `head` and `body` receive raw `<tr>`/`<td>` markup. Always add
  `whitespace-nowrap` to cells so rows stay on one line.
- The table scrolls **inside** its card (`overflow-x-auto` + `theme-scrollbar`),
  so the page layout never shifts horizontally.

### 3.3 Toolbar, Search, Filter, Reset

`x-datatable.toolbar` is a `GET` form; it takes a single `action` prop.

```blade
<x-datatable.toolbar :action="route('settings.models.index')"> ... </x-datatable.toolbar>
```

`x-datatable.search`:

| Prop | Default | Purpose |
| --- | --- | --- |
| `name` | `search` | Input name. |
| `value` | `''` | Current value (from controller). |
| `placeholder` | `Cari...` | Placeholder text. |

`x-datatable.filter` (a custom Alpine dropdown, not a native `<select>`):

| Prop | Default | Purpose |
| --- | --- | --- |
| `name` | `filter` | Query string key. |
| `options` | `[]` | `value => label` map. An int key is treated as its own label. |
| `selected` | `''` | Current selection. |
| `placeholder` | `Semua {name}` | Shown when nothing is selected. |

Selecting an option **submits the toolbar form immediately** (no Filter
button). The selected key is compared as a string, so `0`/`'0'` match.

`x-datatable.reset` renders an icon-only reset link. Show it only when a filter
or search is active:

```blade
@if ($search !== '' || $status !== '')
    <x-datatable.reset :href="route('settings.models.index')" />
@endif
```

### 3.4 Action Menu

`x-datatable.actions.menu` is the `⋮` trigger plus the dropdown panel. It uses
`x-teleport="body"` so the panel is never clipped by the table's scroll
container. The position is clamped to the viewport (it opens upward when there
is not enough space below).

```blade
<x-datatable.actions.menu>
    ... items ...
</x-datatable.actions.menu>
```

`x-datatable.actions.item` props:

| Prop | Type | Default | Purpose |
| --- | --- | --- | --- |
| `href` | string | `null` | Renders a link. If `null`, renders a `POST` form button. |
| `action` | string | `null` | Form target URL (used with `method`). |
| `method` | string | `post` | HTTP verb for the form. `delete`/`patch` add `@method`. |
| `confirm` | string | `null` | When set, asks for confirmation via SweetAlert2 before submitting. |
| `icon` | string | `null` | Lucide icon name (e.g. `pencil`, `trash-2`). |
| `danger` | bool | `false` | Red styling; also marks the confirm dialog as danger. |
| `download` | bool | `false` | Adds `download` to the link. |
| `target` | string | `null` | Adds `target` + `rel="noopener noreferrer"` to the link. |

Examples:

```blade
{{-- Link action --}}
<x-datatable.actions.item :href="route('settings.users.edit', $user)" icon="pencil">
    {{ __('Edit') }}
</x-datatable.actions.item>

{{-- Destructive form action with SweetAlert2 confirmation --}}
<x-datatable.actions.item
    :action="route('settings.users.destroy', $user)"
    method="delete" icon="trash-2" danger :confirm="__('Hapus pengguna ini?')">
    {{ __('Hapus') }}
</x-datatable.actions.item>

{{-- Download action (generic — no form needed) --}}
<x-datatable.actions.item :href="route('settings.reports.export')" icon="download" download>
    {{ __('Unduh') }}
</x-datatable.actions.item>
```

### 3.5 Controller Conventions

Keep the query in the controller and pass `search`, the selected filters, and
the paginator to the view. Use `withQueryString()` so filters survive paging.

```php
public function index(Request $request): View
{
    $search = $request->string('search')->trim()->toString();
    $status = $request->string('status')->trim()->toString();

    return view('pages.settings.models.index', [
        'models' => Model::query()
            ->select(['id', 'name', 'created_at'])
            ->when($search !== '', fn ($q) => $q->where('name', 'like', "%{$search}%"))
            ->when($status !== '', fn ($q) => $q->where('status', $status))
            ->latest()
            ->paginate(15)
            ->withQueryString(),
        'search' => $search,
        'status' => $status,
    ]);
}
```

### 3.6 Permission-Aware Actions

Guard each action and the create button with permissions. Hide = UX only;
routes must be protected separately (see 1.4).

```blade
@can('models.create')
    <div class="mb-4 flex justify-end">
        <x-primary-button onclick="window.location='{{ route('settings.models.create') }}'">
            {{ __('Tambah') }}
        </x-primary-button>
    </div>
@endcan

<x-datatable.actions.menu>
    @can('models.update')
        <x-datatable.actions.item :href="route('settings.models.edit', $model)" icon="pencil">
            {{ __('Edit') }}
        </x-datatable.actions.item>
    @endcan
    @can('models.delete')
        <x-datatable.actions.item :action="route('settings.models.destroy', $model)"
            method="delete" icon="trash-2" danger :confirm="__('Hapus data ini?')">
            {{ __('Hapus') }}
        </x-datatable.actions.item>
    @endcan
</x-datatable.actions.menu>
```

Reference implementation: `resources/views/pages/settings/user/index.blade.php`
and `resources/views/pages/settings/role/index.blade.php`.

---

## 4. SweetAlert2 Alerts

SweetAlert2 handles confirmations and flash notifications. All helpers live in
`resources/js/app.js`; the Blade entry point is `x-alert.sweetalert`.

### 4.1 Global Helpers (JavaScript)

| Helper | Returns | Purpose |
| --- | --- | --- |
| `window.confirmAction(options)` | `Promise<boolean>` | Confirmation dialog. `true` when confirmed. |
| `window.notify(type, title, text)` | `Promise` | Notification dialog (no auto-close, always has a button). |

`confirmAction` options:

| Option | Default | Notes |
| --- | --- | --- |
| `title` | `''` | Dialog title. |
| `text` | `''` | Body text. |
| `icon` | `'warning'` | `success`/`error`/`warning`/`info`/`question`. |
| `confirmText` | `'Ya'` | Confirm button label. |
| `cancelText` | `'Batal'` | Cancel button label. |
| `danger` | `false` | Confirm button turns red (`#dc2626`). |

Both confirm and cancel buttons default to the app accent (`#C89B3C`). The
dialog theme (background, text color, radius) follows the active dark mode.

```js
const ok = await window.confirmAction({
    title: 'Hapus data?',
    text: 'Tindakan ini tidak dapat dibatalkan.',
    confirmText: 'Ya, hapus',
    danger: true,
});

if (ok) {
    // proceed
}

window.notify('success', 'Tersimpan', 'Data berhasil disimpan.');
```

> **Important:** `@js()` is NOT compiled inside a component attribute string
> (e.g. `x-on:click` on `<x-secondary-button>`). Put the logic inside an
> `x-data` block instead, where `@js()` works correctly.

### 4.2 The Blade Component

`resources/views/components/alert/sweetalert.blade.php` is **non-visual** — it
renders a `<span data-swal>` that `app.js` picks up on `DOMContentLoaded`. It
supports three usage modes.

#### Mode A — Flash driver (one per layout)

```blade
<x-alert.sweetalert :status="session('status')" />
```

Already placed once in `resources/views/layouts/app.blade.php`. It maps the
Laravel flash `status` string to a type and message. To add a new flash message,
add an entry to the `$statusMap` inside the component:

```php
'model-created' => ['type' => 'success', 'text' => __('Data berhasil dibuat.')],
```

Then redirect with the same key from the controller:

```php
return to_route('settings.models.index')->with('status', 'model-created');
```

#### Mode B — Explicit notification

```blade
<x-alert.sweetalert type="success" :text="__('Data berhasil disimpan.')" />
<x-alert.sweetalert type="error" :title="__('Gagal')" :text="__('Terjadi kesalahan.')" />
<x-alert.sweetalert type="warning" :text="__('Periksa kembali data Anda.')" />
<x-alert.sweetalert type="info" :text="__('Sesi Anda akan berakhir.')" />
```

#### Mode C — Confirmation

```blade
<x-alert.sweetalert confirm :title="__('Hapus data ini?')" danger />
```

Props:

| Prop | Default | Purpose |
| --- | --- | --- |
| `type` | `null` | `success`/`error`/`warning`/`info` (Mode B). |
| `status` | `null` | Flash status key (Mode A). |
| `title` | `null` | Dialog title. |
| `text` | `null` | Dialog body. |
| `confirm` | `false` | Render as a confirmation dialog (Mode C). |
| `confirmText` | `null` | Confirm button label. |
| `cancelText` | `null` | Cancel button label. |
| `danger` | `false` | Mark the confirmation as danger. |

The component renders nothing when there is no `status`, `type`, or `confirm`.

### 4.3 Dirty-Form Guard

Create/Edit forms warn before leaving with unsaved changes. The pattern:

```blade
<form
    method="POST"
    action="{{ route('settings.models.store') }}"
    x-data="{
        dirty: false,
        async cancelForm() {
            const leave = ! this.dirty || await window.confirmAction({
                icon: 'warning',
                title: @js(__('Batalkan perubahan?')),
                text: @js(__('Perubahan yang belum disimpan akan hilang.')),
                confirmText: @js(__('Ya, batalkan')),
                danger: true,
            });

            if (leave) {
                window.location = @js(route('settings.models.index'));
            }
        },
    }"
    x-on:input="dirty = true"
    x-on:change="dirty = true"
    x-on:submit="dirty = false"
>
    ...
    <x-secondary-button type="button" x-on:click.prevent="cancelForm()">
        {{ __('Batal') }}
    </x-secondary-button>
</form>
```

Reference implementations: `resources/views/pages/settings/user/{create,edit}.blade.php`
and `resources/views/pages/settings/role/{create,edit}.blade.php`.

### 4.4 Delete Confirmation Flow

`x-datatable.actions.item` with `:confirm` handles this automatically. The form
submits via `HTMLFormElement.prototype.submit.call($el)` — a native submit that
does **not** re-fire the `submit` event, avoiding an infinite loop. You do not
need to wire anything extra.
