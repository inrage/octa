<?php

namespace App\Providers;

use Roots\Acorn\Sage\SageServiceProvider;

use function Roots\bundle;


class AssetsServiceProvider extends SageServiceProvider
{
    public function register(): void
    {
        add_action('wp_enqueue_scripts', function (): void {
            bundle('app')->enqueue();

            remove_action('wp_body_open', 'wp_global_styles_render_svg_filters');
        }, 100);

        add_action('enqueue_block_editor_assets', function (): void {
            bundle('editor')->enqueue();
        }, 100);

        /**
         * Use theme.json from the build directory
         *
         * @param  string $path
         * @param  string $file
         * @return string
         */
        add_filter('theme_file_path', function (string $path, string $file): string {
            if ($file === 'theme.json') {
                return public_path() . '/dist/theme.json';
            }

            return $path;
        }, 10, 2);

        add_filter('wp_theme_json_data_default', function (\WP_Theme_JSON_Data $themeJson): \WP_Theme_JSON_Data {
            $themeJsonFile = public_path('/dist/theme.json');
            if (!file_exists($themeJsonFile)) {
                return $themeJson;
            }

            $decodedData = wp_json_file_decode($themeJsonFile, ['associative' => true]);
            if (!is_array($decodedData) || empty($decodedData)) {
                return $themeJson;
            }

            $mergedData = array_merge($themeJson->get_data(), $decodedData);
            return new \WP_Theme_JSON_Data($mergedData, 'default');
        }, 100);
    }
}
