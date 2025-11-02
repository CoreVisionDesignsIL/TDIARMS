<?php
/**
 * Template Name: About/Brand Story
 *
 * @package TDI_Arms_Child
 */

get_header(); ?>

<div class="tdi-page-content">
    <div class="tdi-container">
        <main id="main" class="tdi-site-main" role="main">

            <?php while (have_posts()) : the_post(); ?>

                <article id="post-<?php the_ID(); ?>" <?php post_class('tdi-about-page'); ?>>
                    <header class="tdi-about-header">
                        <h1 class="tdi-page-title"><?php the_title(); ?></h1>
                        <?php if (get_field('subtitle')) : ?>
                            <p class="tdi-page-subtitle"><?php echo esc_html(get_field('subtitle')); ?></p>
                        <?php endif; ?>
                    </header>

                    <div class="tdi-about-content">
                        <?php the_content(); ?>
                    </div>

                    <!-- Company History Section -->
                    <section class="tdi-company-history">
                        <div class="tdi-section-header">
                            <h2><?php _e('Our History', 'tdi-arms'); ?></h2>
                            <p><?php _e('Founded in 2002 with a vision to revolutionize tactical weapon accessories', 'tdi-arms'); ?></p>
                        </div>

                        <div class="tdi-history-timeline">
                            <div class="tdi-timeline-item">
                                <div class="tdi-timeline-year">2002</div>
                                <div class="tdi-timeline-content">
                                    <h3><?php _e('Company Founded', 'tdi-arms'); ?></h3>
                                    <p><?php _e('TDI Arms established in Israel with a mission to create superior tactical weapon accessories for military and law enforcement professionals.', 'tdi-arms'); ?></p>
                                </div>
                            </div>

                            <div class="tdi-timeline-item">
                                <div class="tdi-timeline-year">2008</div>
                                <div class="tdi-timeline-content">
                                    <h3><?php _e('ISO Certification', 'tdi-arms'); ?></h3>
                                    <p><?php _e('Achieved ISO 9001:2015 certification, establishing our commitment to quality management and manufacturing excellence.', 'tdi-arms'); ?></p>
                                </div>
                            </div>

                            <div class="tdi-timeline-item">
                                <div class="tdi-timeline-year">2015</div>
                                <div class="tdi-timeline-content">
                                    <h3><?php _e('US Expansion', 'tdi-arms'); ?></h3>
                                    <p><?php _e('Opened manufacturing facility in the United States, combining Israeli tactical expertise with American manufacturing capabilities.', 'tdi-arms'); ?></p>
                                </div>
                            </div>

                            <div class="tdi-timeline-item">
                                <div class="tdi-timeline-year">2020</div>
                                <div class="tdi-timeline-content">
                                    <h3><?php _e('Global Reach', 'tdi-arms'); ?></h3>
                                    <p><?php _e('Expanded distribution to over 30 countries, becoming a trusted supplier for elite military units and law enforcement agencies worldwide.', 'tdi-arms'); ?></p>
                                </div>
                            </div>
                        </div>
                    </section>

                    <!-- Engineering Philosophy Section -->
                    <section class="tdi-engineering-philosophy">
                        <div class="tdi-section-header">
                            <h2><?php _e('Engineering Philosophy', 'tdi-arms'); ?></h2>
                            <p><?php _e('Designed in the field, not the boardroom', 'tdi-arms'); ?></p>
                        </div>

                        <div class="tdi-philosophy-grid">
                            <div class="tdi-philosophy-item">
                                <div class="tdi-philosophy-icon">
                                    <i class="fas fa-users"></i>
                                </div>
                                <h3><?php _e('Field-Driven Design', 'tdi-arms'); ?></h3>
                                <p><?php _e('Our products are developed through direct collaboration with military and law enforcement professionals who use our equipment in real-world tactical situations.', 'tdi-arms'); ?></p>
                            </div>

                            <div class="tdi-philosophy-item">
                                <div class="tdi-philosophy-icon">
                                    <i class="fas fa-shield-alt"></i>
                                </div>
                                <h3><?php _e('Reliability First', 'tdi-arms'); ?></h3>
                                <p><?php _e('Every component is engineered to function flawlessly under the most demanding conditions. When lives depend on your equipment, failure is not an option.', 'tdi-arms'); ?></p>
                            </div>

                            <div class="tdi-philosophy-item">
                                <div class="tdi-philosophy-icon">
                                    <i class="fas fa-cogs"></i>
                                </div>
                                <h3><?php _e('Precision Manufacturing', 'tdi-arms'); ?></h3>
                                <p><?php _e('State-of-the-art CNC machining and rigorous quality control ensure every product meets exact specifications for perfect fit and function.', 'tdi-arms'); ?></p>
                            </div>

                            <div class="tdi-philosophy-item">
                                <div class="tdi-philosophy-icon">
                                    <i class="fas fa-lightbulb"></i>
                                </div>
                                <h3><?php _e('Innovation', 'tdi-arms'); ?></h3>
                                <p><?php _e('We continuously push the boundaries of tactical accessory design, incorporating the latest materials and technologies to enhance performance.', 'tdi-arms'); ?></p>
                            </div>
                        </div>
                    </section>

                    <!-- Team Section -->
                    <section class="tdi-team-section">
                        <div class="tdi-section-header">
                            <h2><?php _e('Meet Our Team', 'tdi-arms'); ?></h2>
                            <p><?php _e('The experts behind TDI Arms innovation', 'tdi-arms'); ?></p>
                        </div>

                        <div class="tdi-team-grid">
                            <div class="tdi-team-member">
                                <div class="tdi-member-photo">
                                    <img src="<?php echo esc_url(get_stylesheet_directory_uri() . '/assets/images/team/ceo.jpg'); ?>" alt="Evgeny Orliansky">
                                </div>
                                <div class="tdi-member-info">
                                    <h3>Evgeny Orliansky</h3>
                                    <p class="tdi-member-title"><?php _e('Founder & CEO', 'tdi-arms'); ?></p>
                                    <p class="tdi-member-bio"><?php _e('Former special forces operator with over 20 years of tactical equipment design experience. Visionary leader behind TDI Arms innovation.', 'tdi-arms'); ?></p>
                                </div>
                            </div>

                            <div class="tdi-team-member">
                                <div class="tdi-member-photo">
                                    <img src="<?php echo esc_url(get_stylesheet_directory_uri() . '/assets/images/team/rnd-director.jpg'); ?>" alt="R&D Director">
                                </div>
                                <div class="tdi-member-info">
                                    <h3><?php _e('Dr. Sarah Chen', 'tdi-arms'); ?></h3>
                                    <p class="tdi-member-title"><?php _e('R&D Director', 'tdi-arms'); ?></p>
                                    <p class="tdi-member-bio"><?php _e('PhD in Materials Science with expertise in advanced polymers and lightweight alloys. Leads our innovation in next-generation tactical materials.', 'tdi-arms'); ?></p>
                                </div>
                            </div>

                            <div class="tdi-team-member">
                                <div class="tdi-member-photo">
                                    <img src="<?php echo esc_url(get_stylesheet_directory_uri() . '/assets/images/team/operations.jpg'); ?>" alt="Operations Manager">
                                </div>
                                <div class="tdi-member-info">
                                    <h3><?php _e('Michael Rodriguez', 'tdi-arms'); ?></h3>
                                    <p class="tdi-member-title"><?php _e('Operations Director', 'tdi-arms'); ?></p>
                                    <p class="tdi-member-bio"><?php _e('Former military logistics expert with 15 years in manufacturing operations. Ensures quality control and efficient production processes.', 'tdi-arms'); ?></p>
                                </div>
                            </div>
                        </div>
                    </section>

                    <!-- Manufacturing Section -->
                    <section class="tdi-manufacturing-section">
                        <div class="tdi-section-header">
                            <h2><?php _e('Manufacturing Excellence', 'tdi-arms'); ?></h2>
                            <p><?php _e('State-of-the-art facilities in Israel and the United States', 'tdi-arms'); ?></p>
                        </div>

                        <div class="tdi-manufacturing-content">
                            <div class="tdi-facility-showcase">
                                <div class="tdi-facility-item">
                                    <div class="tdi-facility-image">
                                        <img src="<?php echo esc_url(get_stylesheet_directory_uri() . '/assets/images/facilities/israel-facility.jpg'); ?>" alt="Israel Manufacturing Facility">
                                    </div>
                                    <div class="tdi-facility-info">
                                        <h3><?php _e('Israel Facility', 'tdi-arms'); ?></h3>
                                        <p><?php _e('Our flagship manufacturing facility features the latest CNC machining centers, quality control laboratories, and prototyping workshops. Home to our primary R&D operations.', 'tdi-arms'); ?></p>
                                        <ul class="tdi-facility-features">
                                            <li><?php _e('Advanced 5-axis CNC machining', 'tdi-arms'); ?></li>
                                            <li><?php _e('In-house materials testing laboratory', 'tdi-arms'); ?></li>
                                            <li><?php _e('Climate-controlled production environment', 'tdi-arms'); ?></li>
                                            <li><?php _e('ISO 9001:2015 certified processes', 'tdi-arms'); ?></li>
                                        </ul>
                                    </div>
                                </div>

                                <div class="tdi-facility-item">
                                    <div class="tdi-facility-info">
                                        <h3><?php _e('US Facility', 'tdi-arms'); ?></h3>
                                        <p><?php _e('Our American manufacturing center serves North and South American markets with locally produced components and final assembly. Maintains the same quality standards as our Israeli facility.', 'tdi-arms'); ?></p>
                                        <ul class="tdi-facility-features">
                                            <li><?php _e('Large-scale production capabilities', 'tdi-arms'); ?></li>
                                            <li><?php _e('Automated quality inspection systems', 'tdi-arms'); ?></li>
                                            <li><?php _e('Lean manufacturing principles', 'tdi-arms'); ?></li>
                                            <li><?php _e('Veteran workforce', 'tdi-arms'); ?></li>
                                        </ul>
                                    </div>
                                    <div class="tdi-facility-image">
                                        <img src="<?php echo esc_url(get_stylesheet_directory_uri() . '/assets/images/facilities/us-facility.jpg'); ?>" alt="US Manufacturing Facility">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>

                    <!-- Certifications Section -->
                    <section class="tdi-certifications-section">
                        <div class="tdi-section-header">
                            <h2><?php _e('Certifications & Compliance', 'tdi-arms'); ?></h2>
                            <p><?php _e('Our commitment to quality and regulatory compliance', 'tdi-arms'); ?></p>
                        </div>

                        <div class="tdi-certifications-grid">
                            <div class="tdi-certification-item">
                                <div class="tdi-cert-icon">
                                    <img src="<?php echo esc_url(get_stylesheet_directory_uri() . '/assets/images/certifications/iso-9001.png'); ?>" alt="ISO 9001:2015">
                                </div>
                                <h3><?php _e('ISO 9001:2015', 'tdi-arms'); ?></h3>
                                <p><?php _e('International quality management standard certification for consistent quality and customer satisfaction.', 'tdi-arms'); ?></p>
                            </div>

                            <div class="tdi-certification-item">
                                <div class="tdi-cert-icon">
                                    <img src="<?php echo esc_url(get_stylesheet_directory_uri() . '/assets/images/certifications/ce-mark.png'); ?>" alt="CE Marking">
                                </div>
                                <h3><?php _e('CE Marking', 'tdi-arms'); ?></h3>
                                <p><?php _e('European Union conformity marking for products sold within the European Economic Area.', 'tdi-arms'); ?></p>
                            </div>

                            <div class="tdi-certification-item">
                                <div class="tdi-cert-icon">
                                    <img src="<?php echo esc_url(get_stylesheet_directory_uri() . '/assets/images/certifications/nato-codification.png'); ?>" alt="NATO Codification">
                                </div>
                                <h3><?php _e('NATO Codification', 'tdi-arms'); ?></h3>
                                <p><?php _e('NATO supply classification for military equipment procurement and standardization.', 'tdi-arms'); ?></p>
                            </div>

                            <div class="tdi-certification-item">
                                <div class="tdi-cert-icon">
                                    <img src="<?php echo esc_url(get_stylesheet_directory_uri() . '/assets/images/certifications/it compliance.png'); ?>" alt="ITAR/EAR Compliance">
                                </div>
                                <h3><?php _e('ITAR/EAR Compliant', 'tdi-arms'); ?></h3>
                                <p><?php _e('Full compliance with International Traffic in Arms Regulations and Export Administration Regulations.', 'tdi-arms'); ?></p>
                            </div>
                        </div>
                    </section>

                    <!-- Values Section -->
                    <section class="tdi-values-section">
                        <div class="tdi-section-header">
                            <h2><?php _e('Our Values', 'tdi-arms'); ?></h2>
                            <p><?php _e('Core principles that guide everything we do', 'tdi-arms'); ?></p>
                        </div>

                        <div class="tdi-values-grid">
                            <div class="tdi-value-item">
                                <h3><i class="fas fa-shield-alt"></i> <?php _e('Reliability', 'tdi-arms'); ?></h3>
                                <p><?php _e('Every product must perform flawlessly in critical situations. We test relentlessly to ensure absolute reliability.', 'tdi-arms'); ?></p>
                            </div>

                            <div class="tdi-value-item">
                                <h3><i class="fas fa-crosshairs"></i> <?php _e('Precision', 'tdi-arms'); ?></h3>
                                <p><?php _e('Micron-level accuracy in manufacturing ensures perfect fit, function, and performance every time.', 'tdi-arms'); ?></p>
                            </div>

                            <div class="tdi-value-item">
                                <h3><i class="fas fa-lightbulb"></i> <?php _e('Innovation', 'tdi-arms'); ?></h3>
                                <p><?php _e('We continuously challenge conventional wisdom to develop breakthrough solutions for tactical challenges.', 'tdi-arms'); ?></p>
                            </div>

                            <div class="tdi-value-item">
                                <h3><i class="fas fa-handshake"></i> <?php _e('Partnership', 'tdi-arms'); ?></h3>
                                <p><?php _e('We build lasting relationships with customers, treating every order as a partnership in mission success.', 'tdi-arms'); ?></p>
                            </div>
                        </div>
                    </section>

                    <!-- CTA Section -->
                    <section class="tdi-about-cta">
                        <div class="tdi-cta-content">
                            <h2><?php _e('Join the TDI Arms Family', 'tdi-arms'); ?></h2>
                            <p><?php _e('Experience the difference that tactical expertise and precision engineering can make in your equipment.', 'tdi-arms'); ?></p>
                            <div class="tdi-cta-actions">
                                <a href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>" class="tdi-btn tdi-btn-primary">
                                    <?php _e('Shop Products', 'tdi-arms'); ?>
                                    <i class="fas fa-arrow-right"></i>
                                </a>
                                <a href="<?php echo esc_url(home_url('/become-dealer')); ?>" class="tdi-btn tdi-btn-secondary">
                                    <?php _e('Become a Dealer', 'tdi-arms'); ?>
                                    <i class="fas fa-handshake"></i>
                                </a>
                                <a href="<?php echo esc_url(home_url('/contact')); ?>" class="tdi-btn tdi-btn-accent">
                                    <?php _e('Contact Our Team', 'tdi-arms'); ?>
                                    <i class="fas fa-phone"></i>
                                </a>
                            </div>
                        </div>
                    </section>

                </article>

            <?php endwhile; // End of the loop. ?>

        </main>
    </div>
</div>

<?php
get_footer();