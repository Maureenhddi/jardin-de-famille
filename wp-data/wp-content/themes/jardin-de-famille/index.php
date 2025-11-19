<?php get_header(); ?>

<main class="site-content">

    <!-- Section Accueil / Hero -->
    <section id="accueil" class="hero-section" <?php
        $hero_bg = get_field('hero_background_image');
        if ($hero_bg) {
            $hero_bg_url = is_array($hero_bg) ? $hero_bg['url'] : $hero_bg;
            echo 'style="background-image: url(' . esc_url($hero_bg_url) . ');"';
        }
    ?>>
        <div class="hero-content fade-in-up">
            <div class="site-name-small"><?php echo esc_html(get_field('hero_site_name') ?: 'JARDIN DE FAMILLE'); ?>
            </div>
            <h1 class="hero-title"><?php echo get_field('hero_title') ?: 'Entretenons<br>nos <em>racines</em>.'; ?></h1>
            <p class="hero-description">
                <?php echo nl2br(esc_html(get_field('hero_description') ?: 'Depuis 1998, nous créons et entretenons des espaces verts d\'exception.
Notre expertise au service de votre environnement naturel.')); ?>
            </p>
            <a href="#services"
                class="cta-button"><?php echo esc_html(get_field('hero_button_text') ?: 'Découvrir nos services'); ?></a>
        </div>
    </section>

    <!-- Section Services -->
    <section id="services" class="services-section">
        <div class="container">
            <h2 class="section-title"><?php echo esc_html(get_field('services_title') ?: 'Nos Services'); ?></h2>
            <div class="section-intro">
                <div class="intro-small"><?php echo esc_html(get_field('services_intro_top') ?: 'POUR DES'); ?></div>
                <p class="section-subtitle">
                    <em><?php echo esc_html(get_field('services_subtitle') ?: 'espaces verts'); ?></em></p>
                <div class="intro-small"><?php echo esc_html(get_field('services_intro_bottom') ?: 'D\'EXCEPTION'); ?>
                </div>
            </div>

            <div class="services-grid">
                <?php
                // Récupérer les services depuis ACF (Secure Custom Fields utilise ACF)
                $services = get_field('services_cards');

                if ($services && is_array($services) && count($services) > 0) {
                    foreach ($services as $service) {
                        $icon = isset($service['service_icon']) ? $service['service_icon'] : 'fa-leaf';
                        $title = isset($service['service_title']) ? $service['service_title'] : '';
                        $description = isset($service['service_description']) ? $service['service_description'] : '';
                        ?>
                        <div class="service-card">
                            <div class="service-icon">
                                <i class="fa-solid <?php echo esc_attr($icon); ?>"></i>
                            </div>

                            <?php if ($title): ?>
                                <h3 class="service-title"><?php echo esc_html($title); ?></h3>
                            <?php endif; ?>

                            <?php if ($description): ?>
                                <p class="service-description"><?php echo esc_html($description); ?></p>
                            <?php endif; ?>
                        </div>
                        <?php
                    }
                } else {
                    // Message si aucun service n'est configuré
                    echo '<p style="text-align: center; padding: 40px;">Aucun service configuré. Ajoutez des services dans Secure Custom Fields sur la page d\'accueil.</p>';
                }
                ?>
            </div>
        </div>
    </section>

    <!-- Section À propos -->
    <section id="apropos" class="about-section" <?php
        $about_bg = get_field('about_background_image');
        if ($about_bg) {
            $about_bg_url = is_array($about_bg) ? $about_bg['url'] : $about_bg;
            echo 'style="background-image: url(' . esc_url($about_bg_url) . ');"';
        }
    ?>>
        <div class="container">
            <div class="about-content">
                <div class="intro-small"><?php echo esc_html(get_field('about_intro_small') ?: 'NOTRE HISTOIRE'); ?>
                </div>
                <h2 class="about-title">
                    <?php echo get_field('about_title') ?: 'Notre passion, votre <em>jardin</em>'; ?></h2>
                <p class="about-text">
                    <?php echo nl2br(esc_html(get_field('about_text_1') ?: 'Depuis plus de 25 ans, Jardin de Famille cultive l\'art du paysage avec passion et expertise.
Notre équipe de professionnels qualifiés met son savoir-faire au service de la beauté
de vos espaces verts, dans le respect de l\'environnement et de la biodiversité.')); ?>
                </p>
                <p class="about-text">
                    <?php echo nl2br(esc_html(get_field('about_text_2') ?: 'Chaque projet est unique, chaque jardin raconte une histoire.
Nous vous accompagnons dans la création et l\'entretien d\'espaces verts qui vous ressemblent,
alliant esthétique, durabilité et bien-être.')); ?>
                </p>

                <div class="about-stats">
                    <?php
                    $stats = get_field('about_stats');
                    if ($stats && is_array($stats) && count($stats) > 0) {
                        foreach ($stats as $stat) {
                            $icon = isset($stat['stat_icon_svg']) ? $stat['stat_icon_svg'] : 'fa-leaf';

                            ?>
                            <div class="stat-item">
                                <div class="stat-icon">
                                    <i class="fa-solid <?php echo esc_attr($icon); ?>"></i>
                                </div>
                                <div class="stat-number"><?php echo esc_html($stat['stat_number']); ?></div>
                                <div class="stat-label"><?php echo esc_html($stat['stat_label']); ?></div>
                            </div>
                            <?php
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
    </section>

    <!-- Section Galerie -->
    <section id="galerie" class="gallery-section">
        <div class="container">
            <h2 class="section-title"><?php echo esc_html(get_field('gallery_title') ?: 'Nos Réalisations'); ?></h2>
            <p class="section-subtitle">
                <?php echo esc_html(get_field('gallery_subtitle') ?: 'Découvrez quelques-uns de nos projets'); ?></p>

            <div class="gallery-grid">
                <?php
                $gallery_images = get_field('gallery_images');

                if ($gallery_images && is_array($gallery_images) && count($gallery_images) > 0) {
                    foreach ($gallery_images as $index => $image) {
                        $url = isset($image['url']) ? $image['url'] : '';
                        $alt = isset($image['alt']) ? $image['alt'] : 'Image de galerie';

                        if ($url) {
                            echo '<div class="gallery-item" data-index="' . $index . '">';
                            echo '<img class="gallery-item-img" src="' . esc_url($url) . '" alt="' . esc_attr($alt) . '" data-full-url="' . esc_url($url) . '">';
                            echo '</div>';
                        }
                    }
                } else {
                    echo '<p>Aucune image disponible pour le moment. Ajoutez des images dans Secure Custom Fields sur la page d\'accueil.</p>';
                }
                ?>
            </div>
        </div>
    </section>

    <!-- Modal Lightbox pour la galerie -->
    <div id="gallery-modal" class="gallery-modal">
        <button class="gallery-modal-close">&times;</button>
        <button class="gallery-modal-prev">&#10094;</button>
        <button class="gallery-modal-next">&#10095;</button>
        <div class="gallery-modal-content">
            <img id="gallery-modal-img" src="" alt="">
        </div>
    </div>

    <!-- Section Contact -->
    <section id="contact" class="contact-section">
        <div class="container">
            <div class="contact-content">
                <div class="contact-info">
                    <div class="intro-small">
                        <?php echo esc_html(get_field('contact_intro_small') ?: 'PRÊT À DÉMARRER ?'); ?></div>
                    <h2><?php echo get_field('contact_title') ?: 'Contactez-<em>nous</em>'; ?></h2>
                    <p class="contact-intro">
                        <?php echo nl2br(esc_html(get_field('contact_intro_text') ?: 'Prêt à transformer votre espace extérieur ?
Parlons de votre projet ensemble.')); ?>
                    </p>

                    <div class="contact-details">
                        <div class="contact-item">
                            <div class="contact-icon">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M22 17C22 17.5304 21.7893 18.0391 21.4142 18.4142C21.0391 18.7893 20.5304 19 20 19H7L3 23V5C3 4.46957 3.21071 3.96086 3.58579 3.58579C3.96086 3.21071 4.46957 3 5 3H20C20.5304 3 21.0391 3.21071 21.4142 3.58579C21.7893 3.96086 22 4.46957 22 5V17Z"
                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                    <path d="M9 9H15" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                                    <path d="M9 13H13" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                                </svg>
                            </div>
                            <span><?php echo esc_html(get_field('contact_phone') ?: '00 32 498 62 60 40'); ?></span>
                        </div>
                        <div class="contact-item">
                            <div class="contact-icon">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path d="M21 10C21 17 12 23 12 23C12 23 3 17 3 10C3 5 7 2 12 2C17 2 21 5 21 10Z"
                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                    <circle cx="12" cy="10" r="3" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </div>
                            <span><?php echo esc_html(get_field('contact_location') ?: 'Belgique'); ?></span>
                        </div>
                    </div>
                </div>

                <div class="contact-form-wrapper">
                    <?php
                    $form_shortcode = get_field('contact_form_shortcode') ?: '[contact-form-7 id="e40aa09" title="Formulaire de contact 1"]';
                    echo do_shortcode($form_shortcode);
                    ?>
                </div>
            </div>
        </div>
    </section>

</main>

<?php get_footer(); ?>