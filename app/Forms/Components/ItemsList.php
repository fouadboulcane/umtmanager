<?php

namespace App\Forms\Components;

use Filament\Forms\Components\Component;

class ItemsList extends Component
{
    protected string $view = 'forms.components.items-list';

    public static function make(): static
    {
        return new static();
    }

    public function items(array $items): static
    {
        $this->items = $items;

        return $this;
    }

    public function getItems(): array
    {
        return $this->items;
    }
}
