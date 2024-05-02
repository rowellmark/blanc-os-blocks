<?php

namespace BlancStudio\GutenbergBlocks;

class Config
{
    /**
     * Prefix for naming.
     *
     * @var string
     */
    const PREFIX = 'blanc-studio-blocks';

    /**
     * Gettext localization domain.
     *
     * @var string
     */
    const L10N = self::PREFIX;

    /**
     * @var string
     */
    private static string $baseUrl;

    public static function perInit(): void
    {
        // block initialization
        // add_action('after_setup_theme', __CLASS__ . '::gutenbergCss');
        add_action('init',  __CLASS__ . '::gutenbergBlocksInit');
    }

    public static function init(): void
    {
        // add_action('enqueue_block_editor_assets', __CLASS__ . '::registerBlockAssets');
        // blocks category
        if (version_compare($GLOBALS['wp_version'], '5.7', '<')) {
            add_filter('block_categories', __CLASS__ . '::gutenbergBlocksRegisterCategory', 10, 2);
        } else {
            add_filter('block_categories_all', __CLASS__ . '::gutenbergBlocksRegisterCategory', 10, 2);
        }

        // global styles
        // add_action('wp_enqueue_scripts', __CLASS__ . '::enqueueScripts');
        // add_action('enqueue_block_editor_assets', __CLASS__ . '::enqueueScripts');


        self::registerBlockStyles();
    }

    public static function getBlocksName(): array
    {

        $blocks = [];

        $contents = scandir(BLANCSTUDIO_BLOCKS_PATH . 'src/blocks');

        foreach ($contents as $item) {
        
            if ($item != "." && $item != "..") {
                $blocks[] = $item;               
            }
        };

        return $blocks;
    }

    public static function gutenbergBlocksInit(): void
    {
        foreach (self::getBlocksName() as $block_name) {
            register_block_type(self::getBasePath() . '/build/blocks/' . $block_name);
        }
    }

    public static function gutenbergBlocksRegisterCategory($categories, $post): array
    {
        return [
            [
                'slug'  => 'blanc-studio-blocks',
                'title' => __('Blanc Studio', Config::L10N),
            ],
            ...$categories,
        ];
    }

    public static function registerBlockStyles()
    {
        $block_styles = [
            'core/image' => [
                'shadow'         => __('Shadow', 'textdomain'),
            ],
            'core/button' => [
                'fill-red'         => __('Fill Red', 'textdomain'),
                'outline-blue'      => __('Outline Blue', 'textdomain'),
            ],
            'core/quote' => [
                'shadow'         => __('Shadow', 'textdomain'),
                'outline'      => __('Outline', 'textdomain'),
            ],
            'core/group' => [
                'shadow-solid'         => __('Shadow Solid', 'textdomain'),
            ],
        ];

        foreach ($block_styles as $block => $styles) {
            foreach ($styles as $style_name => $style_label) {
                register_block_style(
                    $block,
                    [
                        'name'         => $style_name,
                        'label'        => $style_label,
                    ]
                );
            }
        }
    }

    public static function registerBlockAssets()
    {
        wp_enqueue_script(
            'gutenberg-blocks-js',
            BLANCSTUDIO_BLOCKS_INC_URL . 'js/variations.js',
            ['wp-blocks', 'wp-dom-ready', 'wp-edit-post'],
            BLANCSTUDIO_BLOCKS_VERSION,
            TRUE
        );
    }

    public static function enqueueScripts()
    {

        // pending
        wp_enqueue_style(
            'gutenberg-blocks-style',
            BLANCSTUDIO_BLOCKS_INC_URL . 'css/style.css',
            [],
            BLANCSTUDIO_BLOCKS_VERSION,
            FALSE
        );
    }


    public static function gutenbergCss()
    {
        /// pending
        add_editor_style(BLANCSTUDIO_BLOCKS_INC_URL . 'css/style.css');
    }

    /**
     * Loads the plugin text domain.
     */
    public static function loadTextDomain(): void
    {
        load_plugin_textdomain(static::L10N, FALSE, static::L10N . '/languages/');
    }

    /**
     * The base URL path to this plugin's folder.
     *
     * Uses plugins_url() instead of plugin_dir_url() to avoid a trailing slash.
     */
    public static function getBaseUrl(): string
    {
        if (!isset(static::$baseUrl)) {
            static::$baseUrl = plugins_url('', static::getBasePath() . '/blancstudio-blocks.php');
        }
        return static::$baseUrl;
    }

    /**
     * The absolute filesystem base path of this plugin.
     *
     * @return string
     */
    public static function getBasePath(): string
    {
        return dirname(__DIR__);
    }
}