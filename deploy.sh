#!/bin/bash

###############################################################################
# Script de déploiement automatisé - Jardin de Famille
# Site: https://jardindefamille.be
###############################################################################

set -e  # Arrêter le script en cas d'erreur

# Couleurs pour les messages
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

# Configuration
REMOTE_USER=""
REMOTE_HOST=""
REMOTE_PATH="/var/www/html"
DB_USER="jardink764"
DB_NAME="jardink764"
DB_HOST="jardink764.mysql.db"

###############################################################################
# Fonctions
###############################################################################

print_step() {
    echo -e "\n${BLUE}==>${NC} ${GREEN}$1${NC}"
}

print_warning() {
    echo -e "${YELLOW}⚠️  $1${NC}"
}

print_error() {
    echo -e "${RED}❌ $1${NC}"
}

print_success() {
    echo -e "${GREEN}✅ $1${NC}"
}

###############################################################################
# Vérifications préalables
###############################################################################

print_step "🚀 Déploiement de Jardin de Famille"

# Vérifier que wp-config-production.php existe et est rempli
if [ ! -f "wp-config-production.php" ]; then
    print_error "Le fichier wp-config-production.php n'existe pas !"
    exit 1
fi

if grep -q "VOTRE_MOT_DE_PASSE" wp-config-production.php; then
    print_error "Le fichier wp-config-production.php contient encore 'VOTRE_MOT_DE_PASSE' !"
    echo "Veuillez remplacer le mot de passe avant de continuer."
    exit 1
fi

if grep -q "GÉNÉRER UNE NOUVELLE CLÉ" wp-config-production.php; then
    print_error "Les clés de sécurité ne sont pas générées dans wp-config-production.php !"
    echo "Visitez https://api.wordpress.org/secret-key/1.1/salt/ et remplacez les clés."
    exit 1
fi

# Demander les informations de connexion SSH
if [ -z "$REMOTE_USER" ]; then
    read -p "Utilisateur SSH du serveur : " REMOTE_USER
fi

if [ -z "$REMOTE_HOST" ]; then
    read -p "Adresse du serveur (ex: ftp.jardindefamille.be) : " REMOTE_HOST
fi

echo ""
print_warning "Vérification de la connexion SSH..."
if ! ssh -o BatchMode=yes -o ConnectTimeout=5 "$REMOTE_USER@$REMOTE_HOST" "echo OK" &>/dev/null; then
    print_error "Impossible de se connecter en SSH. Vérifiez vos clés SSH."
    echo "Voulez-vous continuer quand même ? (o/N)"
    read -r response
    if [[ ! "$response" =~ ^[oO]$ ]]; then
        exit 1
    fi
fi

###############################################################################
# ÉTAPE 1 : Transfert des fichiers
###############################################################################

print_step "📦 ÉTAPE 1/5 : Transfert des fichiers vers le serveur"

# Base de données
print_warning "Transfert de la base de données..."
scp database-export.sql "$REMOTE_USER@$REMOTE_HOST:~/" || { print_error "Échec du transfert de la base de données"; exit 1; }
print_success "Base de données transférée"

# wp-config.php
print_warning "Transfert du fichier de configuration..."
scp wp-config-production.php "$REMOTE_USER@$REMOTE_HOST:$REMOTE_PATH/wp-config.php" || { print_error "Échec du transfert de wp-config.php"; exit 1; }
print_success "Configuration transférée"

# Thème
print_warning "Transfert du thème..."
rsync -avz --delete wp-data/wp-content/themes/jardin-de-famille/ "$REMOTE_USER@$REMOTE_HOST:$REMOTE_PATH/wp-content/themes/jardin-de-famille/" || { print_error "Échec du transfert du thème"; exit 1; }
print_success "Thème transféré"

# Plugins
print_warning "Transfert des plugins..."
rsync -avz --delete wp-data/wp-content/plugins/ "$REMOTE_USER@$REMOTE_HOST:$REMOTE_PATH/wp-content/plugins/" || { print_error "Échec du transfert des plugins"; exit 1; }
print_success "Plugins transférés"

# Uploads
print_warning "Transfert des médias..."
rsync -avz wp-data/wp-content/uploads/ "$REMOTE_USER@$REMOTE_HOST:$REMOTE_PATH/wp-content/uploads/" || { print_error "Échec du transfert des uploads"; exit 1; }
print_success "Médias transférés"

###############################################################################
# ÉTAPE 2 : Import de la base de données
###############################################################################

print_step "💾 ÉTAPE 2/5 : Import de la base de données"

print_warning "Import de la base de données (mot de passe requis)..."
ssh "$REMOTE_USER@$REMOTE_HOST" "mysql -u $DB_USER -p -h $DB_HOST $DB_NAME < ~/database-export.sql" || { print_error "Échec de l'import de la base de données"; exit 1; }
print_success "Base de données importée"

###############################################################################
# ÉTAPE 3 : Remplacement des URLs
###############################################################################

print_step "🔄 ÉTAPE 3/5 : Remplacement des URLs"

print_warning "Remplacement de localhost:8082 par jardindefamille.be..."

# Vérifier si WP-CLI est disponible
if ssh "$REMOTE_USER@$REMOTE_HOST" "command -v wp &> /dev/null"; then
    # Utiliser WP-CLI
    ssh "$REMOTE_USER@$REMOTE_HOST" "cd $REMOTE_PATH && wp search-replace 'http://localhost:8082' 'https://jardindefamille.be' --allow-root" || { print_error "Échec du remplacement des URLs"; exit 1; }
else
    # Utiliser MySQL
    print_warning "WP-CLI non disponible, utilisation de MySQL..."
    ssh "$REMOTE_USER@$REMOTE_HOST" << 'ENDSSH'
mysql -u jardink764 -p -h jardink764.mysql.db jardink764 << 'ENDSQL'
UPDATE wp_options SET option_value = 'https://jardindefamille.be' WHERE option_name = 'home' OR option_name = 'siteurl';
UPDATE wp_posts SET post_content = REPLACE(post_content, 'http://localhost:8082', 'https://jardindefamille.be');
UPDATE wp_posts SET guid = REPLACE(guid, 'http://localhost:8082', 'https://jardindefamille.be');
UPDATE wp_postmeta SET meta_value = REPLACE(meta_value, 'http://localhost:8082', 'https://jardindefamille.be');
ENDSQL
ENDSSH
fi

print_success "URLs remplacées"

###############################################################################
# ÉTAPE 4 : Permissions
###############################################################################

print_step "🔐 ÉTAPE 4/5 : Ajustement des permissions"

print_warning "Configuration des permissions..."
ssh "$REMOTE_USER@$REMOTE_HOST" << ENDSSH
cd $REMOTE_PATH/wp-content
chown -R www-data:www-data themes/jardin-de-famille 2>/dev/null || chown -R \$(whoami):\$(whoami) themes/jardin-de-famille
chown -R www-data:www-data plugins 2>/dev/null || chown -R \$(whoami):\$(whoami) plugins
chown -R www-data:www-data uploads 2>/dev/null || chown -R \$(whoami):\$(whoami) uploads
chmod -R 755 themes/jardin-de-famille
chmod -R 755 plugins
chmod -R 755 uploads
chmod 600 $REMOTE_PATH/wp-config.php
ENDSSH

print_success "Permissions configurées"

###############################################################################
# ÉTAPE 5 : Configuration WordPress
###############################################################################

print_step "⚙️  ÉTAPE 5/5 : Configuration WordPress"

if ssh "$REMOTE_USER@$REMOTE_HOST" "command -v wp &> /dev/null"; then
    print_warning "Activation du thème..."
    ssh "$REMOTE_USER@$REMOTE_HOST" "cd $REMOTE_PATH && wp theme activate jardin-de-famille --allow-root" 2>/dev/null || print_warning "Impossible d'activer le thème automatiquement"

    print_warning "Régénération des permaliens..."
    ssh "$REMOTE_USER@$REMOTE_HOST" "cd $REMOTE_PATH && wp rewrite flush --allow-root" 2>/dev/null || print_warning "Impossible de régénérer les permaliens automatiquement"

    print_success "Configuration WordPress terminée"
else
    print_warning "WP-CLI non disponible. Activez le thème manuellement dans l'admin WordPress."
fi

###############################################################################
# Résumé final
###############################################################################

echo ""
echo -e "${GREEN}╔════════════════════════════════════════════════════════════╗${NC}"
echo -e "${GREEN}║                                                            ║${NC}"
echo -e "${GREEN}║  ✅  Déploiement terminé avec succès !                     ║${NC}"
echo -e "${GREEN}║                                                            ║${NC}"
echo -e "${GREEN}╚════════════════════════════════════════════════════════════╝${NC}"
echo ""
print_success "Site web : https://jardindefamille.be"
print_success "Admin : https://jardindefamille.be/wp-admin"
echo ""
print_warning "Vérifications à faire :"
echo "  [ ] Le site s'affiche correctement"
echo "  [ ] Le thème est activé"
echo "  [ ] Les images s'affichent"
echo "  [ ] Les champs SCF fonctionnent"
echo "  [ ] Le formulaire Contact Form 7 fonctionne"
echo "  [ ] Le menu responsive fonctionne"
echo "  [ ] La lightbox de galerie fonctionne"
echo ""
print_warning "N'oublie pas de supprimer le fichier database-export.sql du serveur :"
echo "  ssh $REMOTE_USER@$REMOTE_HOST 'rm ~/database-export.sql'"
echo ""
