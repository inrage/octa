<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Symfony\Component\Finder\Finder;

use function Roots\bundle;

class BlockAssetsServiceProvider extends ServiceProvider
{
  public function register(): void
  {
    $availableBlocks = $this->getAvailableBlocks();

    if (!is_admin()) {
      add_filter('the_content', function ($postContent) use ($availableBlocks) {
        $blocks = parse_blocks($postContent);

        foreach ($availableBlocks as $block) {
          if (str_starts_with($block, 'custom-class')) {
            $this->findCustomClass(str_replace('custom-class/', '', $block), $blocks);

            continue;
          }
          if (has_block($block, $postContent)) {
            bundle("blocks/{$block}")->enqueue();
          }
        }

        return $postContent;
      }, 1);
    }

    add_action('wpcf7_enqueue_styles', function () {
      if (has_block('inr/wpcf7')) {
        bundle('components/wpcf7')->enqueue();
      }
    });

    add_action('wp_enqueue_scripts', function () {
      if (has_block('inr/wpcf7')) {
        if (function_exists('wpcf7_enqueue_scripts')) {
          wpcf7_enqueue_scripts();
        }

        if (function_exists('wpcf7_enqueue_styles')) {
          wpcf7_enqueue_styles();
        }
      }
    });
  }

  private function getAvailableBlocks(): array
  {
    $typesBlocks = (new Finder())->directories()->in(
      ABSPATH . '../../resources/',
    )->path('/scripts|styles/')->depth('== 1')->name('blocks');
    $typesBlocks = (new Finder())->directories()->in(
      iterator_to_array($typesBlocks->getIterator())
    )->depth('0');


    $availableBlocks = [];

    foreach ($typesBlocks as $type) {
      $blocks = (new Finder())->files()->in($type->getRealPath());

      foreach ($blocks as $block) {
        $availableBlocks[] = "{$type->getFilename()}/{$block->getFilenameWithoutExtension()}";
      }
    }

    return $availableBlocks;
  }

  private function findCustomClass(string $haystackBlock, array $parsedBlocks): void
  {
    foreach ($parsedBlocks as $block) {
      if (isset($block['attrs']['ref'])) {
        $this->findCustomClass($haystackBlock, parse_blocks(get_the_content(post: $block['attrs']['ref'])));
      }

      foreach ($block['attrs'] as $attr) {
        if ($attr === $haystackBlock && isset($block['attrs']['className'])) {
          bundle('blocks/custom-class/' . $block['attrs']['className'])->enqueue();
        }
      }

      if (isset($block['innerBlocks']) && !empty($block['innerBlocks'])) {
        $this->findCustomClass($haystackBlock, $block['innerBlocks']);
      }
    }
  }
}
