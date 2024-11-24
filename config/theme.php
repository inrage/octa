<?php

return [
    /**
     * Navigation menus
     *
     * @link https://developer.wordpress.org/reference/functions/register_nav_menus/
     */
    'menus' => [
        'primary_navigation' => __('Primary Navigation', 'octa'),
        'footer_navigation' => __('Footer Navigation', 'octa'),
    ],

    'image_sizes' => [
        // 'element' => [1600, 900, true],
    ],

    /**
     * Theme supports
     */
    'support' => [
        /**
         * @link https://developer.wordpress.org/reference/functions/add_theme_support/#html5
         */
        'html5' => [
            'caption',
            'comment-form',
            'comment-list',
            'gallery',
            'search-form',
            'script',
            'style',
        ],

        /**
         * @link https://wordpress.org/gutenberg/handbook/designers-developers/developers/themes/theme-support/#wide-alignment
         */
        'align-wide',

        /**
         * @link https://developer.wordpress.org/reference/functions/add_theme_support/#title-tag
         */
        'title-tag',

        /**
         * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
         */
        'post-thumbnails',

        /**
         * @link https://wordpress.org/gutenberg/handbook/designers-developers/developers/themes/theme-support/#wide-alignment
         */
        'responsive-embeds',

        /**
         * @link https://developer.wordpress.org/themes/advanced-topics/customizer-api/#theme-support-in-sidebars
         */
        'customize-selective-refresh-widgets',
    ],

    /**
     * Remove theme supports
     */
    'remove' => [
        /**
         * @link https://wptavern.com/gutenberg-10-5-embeds-pdfs-adds-verse-block-color-options-and-introduces-new-patterns
         */
        'block-templates',

        /**
         * @link https://developer.wordpress.org/block-editor/developers/themes/theme-support/#disabling-the-default-block-patterns
         */
        'core-block-patterns',
    ],
];
