<?php

if (! function_exists('\Roots\bootloader')) {
    wp_die(
        __('You need to install Acorn to use this site.', 'octa'),
        '',
        [
            'link_url' => 'https://roots.io/acorn/docs/installation/',
            'link_text' => __('Acorn Docs: Installation', 'octa'),
        ]
    );
}

add_action('after_setup_theme', fn () => \Roots\bootloader()->boot(), 0);
