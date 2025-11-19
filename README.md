# 🌿 Jardin de Famille - WordPress Theme

Site WordPress pour Jardin de Famille, spécialisé dans l'entretien et la création d'espaces verts.

## 📋 Contenu du dépôt

- **Thème WordPress** : `wp-data/wp-content/themes/jardin-de-famille/`
- **Plugins** : `wp-data/wp-content/plugins/`
- **Base de données** : `database-export.sql`
- **Infrastructure** : `infra/docker-compose.yml` (pour développement local)
- **Guide de déploiement** : `DEPLOIEMENT.md`

## 🚀 Déploiement

Voir le fichier [DEPLOIEMENT.md](DEPLOIEMENT.md) pour les instructions complètes.

## 🛠️ Technologies

- **CMS** : WordPress
- **Thème** : Custom (Jardin de Famille)
- **Plugins** :
  - Secure Custom Fields (SCF) - Gestion des champs personnalisés
  - Contact Form 7 - Formulaire de contact
- **Frontend** :
  - HTML5, CSS3, JavaScript
  - Responsive Design
  - Lightbox pour la galerie
  - Navigation mobile

## 📦 Plugins requis

1. **Secure Custom Fields** - Pour les champs personnalisés (ACF)
2. **Contact Form 7** - Pour le formulaire de contact

## 🎨 Fonctionnalités du thème

- ✅ Responsive (Mobile, Tablette, Desktop)
- ✅ Menu hamburger mobile
- ✅ Smooth scrolling
- ✅ Lightbox/Modal pour la galerie
- ✅ Animations au scroll
- ✅ Overlay coloré sur les images de fond
- ✅ Champs personnalisés SCF pour tout le contenu
- ✅ Navigation au clavier (lightbox)

## 📁 Structure du thème

```
jardin-de-famille/
├── acf-all-sections-export.json  # Export des champs SCF
├── footer.php                     # Footer du site
├── functions.php                  # Fonctions du thème
├── header.php                     # En-tête et navigation
├── index.php                      # Template principal
├── style.css                      # CSS du thème
└── js/
    └── main.js                    # JavaScript
```

## 🔧 Développement local

```bash
cd infra
docker-compose up -d
```

Accès :
- Site : http://localhost:8082
- Admin : http://localhost:8082/wp-admin
- phpMyAdmin : http://localhost:8081

## 📝 Licence

Propriétaire - Jardin de Famille
