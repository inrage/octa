<header>
    <div>
        <a class="py-3 font-bold text-lg block" href="{{ home_url('/') }}">
            {!! $siteName !!}
        </a>

        @if (has_nav_menu('primary_navigation'))
            <nav class="nav-primary" aria-label="{{ wp_get_nav_menu_name('primary_navigation') }}">
                {!! wp_nav_menu(['theme_location' => 'primary_navigation', 'menu_class' => 'nav', 'container' => false, 'echo' => false]) !!}
            </nav>
        @endif
    </div>
</header>
