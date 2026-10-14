<?php

namespace App\View\Components;

use Illuminate\Support\Str;
use Illuminate\View\Component;
use Illuminate\View\View;

class ProfileSessionDevice extends Component
{
    public string $icon;

    public function __construct(?string $userAgent)
    {
        $userAgent ??= '';

        $this->icon = match (true) {
            Str::contains($userAgent, ['iPhone', 'Android', 'Mobile']) => 'mobile',
            Str::contains($userAgent, ['Tablet']) => 'tablet',
            default => 'desktop',
        };
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View
    {
        return view('components.profile-session-device');
    }
}
