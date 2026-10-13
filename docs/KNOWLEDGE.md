# KNOWLEDGE GUIDEBOOK

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
