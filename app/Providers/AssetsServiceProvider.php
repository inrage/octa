<?php

namespace App\Providers;

use Illuminate\Support\Facades\Vite;
use Roots\Acorn\Sage\SageServiceProvider;

class AssetsServiceProvider extends SageServiceProvider
{
    public function register(): void
    {
        add_action('wp_enqueue_scripts', function (): void {
            remove_action('wp_body_open', 'wp_global_styles_render_svg_filters');
        }, 100);

        add_filter('block_editor_settings_all', function ($settings) {
            $style = Vite::asset('resources/css/editor.css');

            $settings['styles'][] = [
                'css' => "@import url('{$style}')",
            ];

            return $settings;
        });

        add_filter('admin_head', function () {
            if (! get_current_screen()?->is_block_editor()) {
                return;
            }

            $dependencies = json_decode(Vite::content('editor.deps.json'));

            foreach ($dependencies as $dependency) {
                if (! wp_script_is($dependency)) {
                    wp_enqueue_script($dependency);
                }
            }

            echo Vite::withEntryPoints([
                'resources/js/editor.ts',
            ])->toHtml();
        });

        add_filter('theme_file_path', function ($path, $file) {
            return $file === 'theme.json'
                ? public_path('build/assets/theme.json')
                : $path;
        }, 10, 2);

        add_filter('wp_theme_json_data_default', function (\WP_Theme_JSON_Data $themeJson): \WP_Theme_JSON_Data {
            $themeJsonFile = public_path('/build/assets/theme.json');
            if (!file_exists($themeJsonFile)) {
                return $themeJson;
            }

            $decodedData = wp_json_file_decode($themeJsonFile, ['associative' => true]);
            if (!is_array($decodedData) || empty($decodedData)) {
                return $themeJson;
            }

            return new \WP_Theme_JSON_Data($decodedData, 'default');
        }, 100);
    }
}
