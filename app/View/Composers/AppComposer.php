<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class AppComposer extends Composer
{
    protected static $views = ['*'];

    public function with(): array
    {
        return [
            'siteName' => $this->siteName(),
        ];
    }

    public function siteName(): string
    {
        return get_bloginfo('name', 'display');
    }
}
