<?php

namespace App\View\Components;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;
use Illuminate\View\View;

class Navigation extends Component
{
    public function render(): View
    {
        return view('components.navigation', [
            'Navigation' => $this->Visible($this->Navigation(), Auth::user()),
        ]);
    }

    /** @return array<int, array<string, mixed>> */
    private function Navigation(): array
    {
        return [
            [
                'label' => __('Dashboard'),
                'href' => route('dashboard'),
                'active' => request()->routeIs('dashboard'),
                'permission' => null,
                'children' => [],
            ],
        ];
    }

    /**
     * @param  array<int, array<string, mixed>>  $items
     * @return array<int, array<string, mixed>>
     */
    private function Visible(array $items, ?User $user): array
    {
        $visibleItems = [];

        foreach ($items as $item) {
            $children = $this->Visible($item['children'], $user);
            $canView = $item['permission'] === null || $user?->can($item['permission']) === true;

            $item['children'] = $children;

            if ($canView || $children !== []) {
                $visibleItems[] = $item;
            }
        }

        return $visibleItems;
    }
}
