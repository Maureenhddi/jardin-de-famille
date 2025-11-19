<footer class="site-footer">
    <div class="container">
        <div class="footer-grid">
            <!-- Colonne À propos -->
            <div class="footer-column">
                <div class="footer-logo">
                    <?php
                    if (has_custom_logo()) {
                        the_custom_logo();
                    } else {
                        echo '<div class="footer-brand">' . get_bloginfo('name') . '</div>';
                    }
                    ?>
                </div>
                <p class="footer-tagline">Entretenons nos <em>racines</em></p>
                <p class="footer-description">
                    Votre partenaire de confiance pour l'entretien et la création d'espaces verts d'exception depuis
                    1998.
                </p>
            </div>

            <!-- Colonne Navigation -->
            <div class="footer-column">
                <h3 class="footer-title">Navigation</h3>
                <nav class="footer-nav">
                    <a href="#accueil">Accueil</a>
                    <a href="#services">Nos Services</a>
                    <a href="#galerie">Réalisations</a>
                    <a href="#apropos">À Propos</a>
                    <a href="#contact">Contact</a>
                </nav>
            </div>

            <!-- Colonne Contact -->
            <div class="footer-column">
                <h3 class="footer-title">Contact</h3>
                <div class="footer-contact">
                    <div class="footer-contact-item">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M22 17C22 17.5304 21.7893 18.0391 21.4142 18.4142C21.0391 18.7893 20.5304 19 20 19H7L3 23V5C3 4.46957 3.21071 3.96086 3.58579 3.58579C3.96086 3.21071 4.46957 3 5 3H20C20.5304 3 21.0391 3.21071 21.4142 3.58579C21.7893 3.96086 22 4.46957 22 5V17Z"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M9 9H15" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                            <path d="M9 13H13" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                        </svg>
                        <span><?php echo esc_html(get_field('contact_phone') ?: '00 32 498 62 60 40'); ?></span>
                    </div>
                    <div class="footer-contact-item">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M21 10C21 17 12 23 12 23C12 23 3 17 3 10C3 5 7 2 12 2C17 2 21 5 21 10Z"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            <circle cx="12" cy="10" r="3" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" />
                        </svg>
                        <span><?php echo esc_html(get_field('contact_location') ?: 'Belgique'); ?></span>
                    </div>
                </div>
            </div>
        </div>

        <div class="footer-bottom">
            <p>&copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?>. Tous droits réservés.</p>
            <div class="footer-badge">Depuis 1998</div>
        </div>
    </div>
</footer>

<?php wp_footer(); ?>
</body>

</html>