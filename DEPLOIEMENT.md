# 🚀 Guide de Déploiement - Jardin de Famille

## Fichiers à transférer

### 1. Base de données
- `database-export.sql` - Export complet de la base de données

### 2. Fichiers WordPress
- **Thème** : `wp-data/wp-content/themes/jardin-de-famille/`
- **Plugins** : `wp-data/wp-content/plugins/`
- **Uploads** : `wp-data/wp-content/uploads/`

---

## 📦 Étapes de déploiement via SSH

### ÉTAPE 1 : Transférer les fichiers vers le serveur

```bash
# Depuis ton ordinateur local
cd /home/maureen/projets/wordpress-jardin-de-famille

# Transférer la base de données
scp database-export.sql user@ton-serveur.com:/home/user/

# Transférer le thème
rsync -avz wp-data/wp-content/themes/jardin-de-famille/ \
  user@ton-serveur.com:/var/www/html/wp-content/themes/jardin-de-famille/

# Transférer les plugins
rsync -avz wp-data/wp-content/plugins/ \
  user@ton-serveur.com:/var/www/html/wp-content/plugins/

# Transférer les uploads (images, médias)
rsync -avz wp-data/wp-content/uploads/ \
  user@ton-serveur.com:/var/www/html/wp-content/uploads/
```

### ÉTAPE 2 : Se connecter au serveur

```bash
ssh user@ton-serveur.com
```

### ÉTAPE 3 : Importer la base de données

```bash
# Remplace DB_NAME, DB_USER, DB_PASSWORD par tes vrais identifiants de production
mysql -u DB_USER -p DB_NAME < ~/database-export.sql
```

### ÉTAPE 4 : Mettre à jour les URLs dans la base de données

**⚠️ IMPORTANT** : Les URLs dans la base pointent encore vers `localhost:8082`

```bash
# Se connecter à MySQL
mysql -u DB_USER -p DB_NAME

# Remplacer les URLs
UPDATE wp_options SET option_value = 'https://jardindefamille.be'
  WHERE option_name = 'home' OR option_name = 'siteurl';

# Remplacer dans les posts
UPDATE wp_posts SET post_content = REPLACE(post_content, 'http://localhost:8082', 'https://jardindefamille.be');
UPDATE wp_posts SET guid = REPLACE(guid, 'http://localhost:8082', 'https://jardindefamille.be');

# Remplacer dans les meta
UPDATE wp_postmeta SET meta_value = REPLACE(meta_value, 'http://localhost:8082', 'https://jardindefamille.be');

# Quitter MySQL
EXIT;
```

**OU utiliser WP-CLI (plus simple) :**

```bash
cd /var/www/html
wp search-replace 'http://localhost:8082' 'https://jardindefamille.be' --allow-root
```

### ÉTAPE 5 : Ajuster les permissions

```bash
cd /var/www/html/wp-content
chown -R www-data:www-data themes/jardin-de-famille
chown -R www-data:www-data plugins
chown -R www-data:www-data uploads
chmod -R 755 themes/jardin-de-famille
chmod -R 755 plugins
chmod -R 755 uploads
```

### ÉTAPE 6 : Activer le thème et les plugins

```bash
cd /var/www/html

# Activer le thème
wp theme activate jardin-de-famille --allow-root

# Vérifier que les plugins sont actifs
wp plugin list --allow-root

# Si nécessaire, activer les plugins
wp plugin activate secure-custom-fields --allow-root
wp plugin activate contact-form-7 --allow-root
```

### ÉTAPE 7 : Configurer WordPress

```bash
# Regénérer les permaliens
wp rewrite flush --allow-root
```

---

## ✅ Vérifications post-déploiement

1. **Accéder au site** : `https://jardindefamille.be`
2. **Se connecter à l'admin** : `https://jardindefamille.be/wp-admin`
   - User : (celui de ton local)
   - Pass : (celui de ton local)
3. **Vérifier** :
   - [ ] Le thème est activé
   - [ ] Les images s'affichent
   - [ ] Les champs SCF sont présents
   - [ ] Le formulaire Contact Form 7 fonctionne
   - [ ] Le menu responsive fonctionne
   - [ ] La lightbox de la galerie fonctionne

---

## 🔧 Optimisations production

### Désactiver le mode debug

Édite `/var/www/html/wp-config.php` :

```php
define('WP_DEBUG', false);
define('WP_DEBUG_LOG', false);
define('WP_DEBUG_DISPLAY', false);
```

### Installer un plugin de cache (optionnel)

```bash
wp plugin install wp-super-cache --activate --allow-root
```

### Sécuriser wp-config.php

```bash
chmod 600 /var/www/html/wp-config.php
```

---

## 📝 Résumé des commandes complètes

```bash
# 1. Local : Transférer tout
scp database-export.sql user@serveur:/home/user/
rsync -avz wp-data/wp-content/themes/jardin-de-famille/ user@serveur:/var/www/html/wp-content/themes/jardin-de-famille/
rsync -avz wp-data/wp-content/plugins/ user@serveur:/var/www/html/wp-content/plugins/
rsync -avz wp-data/wp-content/uploads/ user@serveur:/var/www/html/wp-content/uploads/

# 2. Serveur : Importer et configurer
ssh user@serveur
mysql -u DB_USER -p DB_NAME < ~/database-export.sql
cd /var/www/html
wp search-replace 'http://localhost:8082' 'https://jardindefamille.be' --allow-root
chown -R www-data:www-data wp-content
wp theme activate jardin-de-famille --allow-root
wp rewrite flush --allow-root
```

---

## 🆘 En cas de problème

**Écran blanc :** Vérifie les logs d'erreur
```bash
tail -f /var/log/apache2/error.log
# ou
tail -f /var/log/nginx/error.log
```

**Images manquantes :** Vérifie les permissions
```bash
ls -la /var/www/html/wp-content/uploads/
```

**Erreur de connexion base de données :** Vérifie wp-config.php
```bash
cat /var/www/html/wp-config.php | grep DB_
```
