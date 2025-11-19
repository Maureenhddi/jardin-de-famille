<?php
/**
 * Jardin de Famille functions
 */

function jardin_de_famille_setup()
{
    add_theme_support("title-tag");
    add_theme_support("post-thumbnails");
}
add_action("after_setup_theme", "jardin_de_famille_setup");

function jardin_de_famille_enqueue_styles()
{
    wp_enqueue_style("jardin-de-famille-style", get_stylesheet_uri(), array(), "1.0.0");
}
add_action("wp_enqueue_scripts", "jardin_de_famille_enqueue_styles");

function jardin_de_famille_theme_setup()
{
    add_theme_support('custom-logo', [
        'height' => 80,
        'width' => 200,
        'flex-width' => true,
        'flex-height' => true,
    ]);

    add_theme_support('title-tag'); // pour le titre du site
    add_theme_support('post-thumbnails'); // pour les images à la une
}
add_action('after_setup_theme', 'jardin_de_famille_theme_setup');

function jardin_de_famille_enqueue_scripts()
{
    // CSS principal
    wp_enqueue_style('main-style', get_stylesheet_uri());

    // Font Awesome pour les icônes
    wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css');

    // JS principal
    wp_enqueue_script(
        'main-js',                            // nom du script
        get_template_directory_uri() . '/js/main.js', // chemin du fichier
        [],                                   // dépendances (ex: ['jquery'])
        false,                                // version (false = ne pas versionner)
        true                                  // true = placer avant </body>
    );
}
add_action('wp_enqueue_scripts', 'jardin_de_famille_enqueue_scripts');
add_action('admin_post_contact_form_submit', 'handle_contact_form_submit');
add_action('admin_post_nopriv_contact_form_submit', 'handle_contact_form_submit');
