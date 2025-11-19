<?php
/**
 * Configuration WordPress pour PRODUCTION
 * Site: https://jardindefamille.be
 *
 * ⚠️ CE FICHIER CONTIENT DES INFORMATIONS SENSIBLES
 * NE PAS LE COMMITER SUR GITHUB
 *
 * Instructions:
 * 1. Copier ce fichier sur le serveur en tant que wp-config.php
 * 2. Remplacer VOTRE_MOT_DE_PASSE par le vrai mot de passe
 * 3. Générer de nouvelles clés de sécurité sur https://api.wordpress.org/secret-key/1.1/salt/
 */

// ** Réglages MySQL - Votre hébergeur vous fournit ces informations. ** //
/** Nom de la base de données de WordPress. */
define( 'DB_NAME', 'jardink764' );

/** Utilisateur de la base de données MySQL. */
define( 'DB_USER', 'jardink764' );

/** Mot de passe de la base de données MySQL. */
define( 'DB_PASSWORD', 'VOTRE_MOT_DE_PASSE' );  // ⚠️ REMPLACER PAR LE VRAI MOT DE PASSE

/** Adresse de l'hébergement MySQL. */
define( 'DB_HOST', 'jardink764.mysql.db' );

/** Jeu de caractères à utiliser par la base de données lors de la création des tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** Type de collation de la base de données. */
define( 'DB_COLLATE', '' );

/**#@+
 * Clés uniques d'authentification et salage.
 *
 * Remplacez les valeurs par défaut par des phrases uniques !
 * Vous pouvez générer des phrases ici : {@link https://api.wordpress.org/secret-key/1.1/salt/}
 *
 * ⚠️ GÉNÉRER DE NOUVELLES CLÉS AVANT LA MISE EN PRODUCTION
 */
define('AUTH_KEY',         'GÉNÉRER UNE NOUVELLE CLÉ SUR https://api.wordpress.org/secret-key/1.1/salt/');
define('SECURE_AUTH_KEY',  'GÉNÉRER UNE NOUVELLE CLÉ SUR https://api.wordpress.org/secret-key/1.1/salt/');
define('LOGGED_IN_KEY',    'GÉNÉRER UNE NOUVELLE CLÉ SUR https://api.wordpress.org/secret-key/1.1/salt/');
define('NONCE_KEY',        'GÉNÉRER UNE NOUVELLE CLÉ SUR https://api.wordpress.org/secret-key/1.1/salt/');
define('AUTH_SALT',        'GÉNÉRER UNE NOUVELLE CLÉ SUR https://api.wordpress.org/secret-key/1.1/salt/');
define('SECURE_AUTH_SALT', 'GÉNÉRER UNE NOUVELLE CLÉ SUR https://api.wordpress.org/secret-key/1.1/salt/');
define('LOGGED_IN_SALT',   'GÉNÉRER UNE NOUVELLE CLÉ SUR https://api.wordpress.org/secret-key/1.1/salt/');
define('NONCE_SALT',       'GÉNÉRER UNE NOUVELLE CLÉ SUR https://api.wordpress.org/secret-key/1.1/salt/');
/**#@-*/

/**
 * Préfixe de base de données pour les tables de WordPress.
 */
$table_prefix = 'wp_';

/**
 * Pour les développeurs : le mode déboguage de WordPress.
 *
 * IMPORTANT: Mettre à false en production
 */
define( 'WP_DEBUG', false );
define( 'WP_DEBUG_LOG', false );
define( 'WP_DEBUG_DISPLAY', false );

/**
 * Sécurité supplémentaire
 */
define( 'DISALLOW_FILE_EDIT', true );  // Désactive l'éditeur de fichiers dans l'admin
define( 'WP_POST_REVISIONS', 5 );      // Limite les révisions de posts

/**
 * URLs du site (configurées automatiquement par wp search-replace)
 */
define( 'WP_HOME', 'https://jardindefamille.be' );
define( 'WP_SITEURL', 'https://jardindefamille.be' );

/**
 * Forcer HTTPS
 */
define( 'FORCE_SSL_ADMIN', true );

/* C'est tout, ne touchez pas à ce qui suit ! Bonne publication. */

/** Chemin absolu vers le dossier de WordPress. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Réglage des variables de WordPress et de ses fichiers inclus. */
require_once ABSPATH . 'wp-settings.php';
