<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\Contracts\View\View;

class EmptyState extends Component
{
    public function __construct(
        public string $title = 'Nothing here yet',
        public string $description = '',
        public ?string $actionText = null,
        public ?string $actionUrl = null,
    ) {}

    public function render(): View
    {
        return view('components.empty-state');
    }
}
