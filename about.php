<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - Sugar Studio</title>
    <link rel="stylesheet" href="style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600&family=Playfair+Display:wght@400;500;600&display=swap" rel="stylesheet">
    <!-- Font Awesome for WhatsApp icon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>

    <?php include 'header.php'; ?>

    <main class="engaging-about">
        <!-- Hero Section with Background Image -->
        <section class="about-hero">
            <div class="hero-overlay">
                <div class="container">
                    <h1>About Sugar Studio</h1>
                    <p class="hero-subtitle">Crafting edible art since 2015</p>
                    <div class="hero-stats">
                        <div class="stat-item">
                            <span class="stat-number">5000+</span>
                            <span class="stat-label">Cakes Created</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-number">98%</span>
                            <span class="stat-label">Client Satisfaction</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-number">15+</span>
                            <span class="stat-label">Awards Won</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Philosophy Section -->
        <section class="content-section philosophy-section">
            <div class="container">
                <div class="section-header">
                    <h2>Our Philosophy</h2>
                    <p class="section-subtitle">We believe that exceptional desserts are created through a harmonious blend of artistry, quality ingredients, and meticulous attention to detail.</p>
                </div>
                
                <div class="philosophy-wrapper">
                    <div class="philosophy-item">
                        <div class="icon-wrapper">
                            <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="#d4a373" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                <circle cx="12" cy="7" r="4"></circle>
                            </svg>
                        </div>
                        <h3>Artistry</h3>
                        <p>Each cake is a canvas. We approach every creation as both artist and artisan, ensuring visual impact meets gustatory excellence.</p>
                    </div>
                    
                    <div class="philosophy-item">
                        <div class="icon-wrapper">
                            <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="#d4a373" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="10"></circle>
                                <line x1="12" y1="8" x2="12" y2="12"></line>
                                <line x1="12" y1="16" x2="12.01" y2="16"></line>
                            </svg>
                        </div>
                        <h3>Premium Ingredients</h3>
                        <p>We source the finest local and international ingredients, from single-origin chocolates to organic dairy, ensuring every bite is exceptional.</p>
                    </div>
                    
                    <div class="philosophy-item">
                        <div class="icon-wrapper">
                            <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="#d4a373" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                <circle cx="12" cy="7" r="4"></circle>
                                <line x1="22" y1="11" x2="16" y2="11"></line>
                                <line x1="2" y1="11" x2="8" y2="11"></line>
                            </svg>
                        </div>
                        <h3>Customization</h3>
                        <p>Your vision, our expertise. We specialize in translating your dreams into edible masterpieces that exceed expectations.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Commitment Section -->
        <section class="content-section commitment-section">
            <div class="container">
                <div class="commitment-content">
                    <div class="commitment-image">
                        <img src="https://images.unsplash.com/photo-1602351436046-314284090494?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80" alt="Crafting desserts">
                    </div>
                    <div class="commitment-text">
                        <h2>Our Commitment</h2>
                        <p>We believe in responsible creation. Our commitment extends beyond taste to environmental stewardship:</p>
                        <ul class="commitment-list">
                            <li>
                                <span class="list-icon">✓</span>
                                Eco-friendly packaging made from recycled materials
                            </li>
                            <li>
                                <span class="list-icon">✓</span>
                                Local sourcing to reduce carbon footprint
                            </li>
                            <li>
                                <span class="list-icon">✓</span>
                                Composting organic waste for our herb garden
                            </li>
                            <li>
                                <span class="list-icon">✓</span>
                                Energy-efficient kitchen equipment
                            </li>
                        </ul>
                        <a href="contact.php" class="cta-button">Learn More</a>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <?php include 'footer.php'; ?>
    
    <!-- WhatsApp Chat Icon -->
    <a href="https://wa.me/919876543210" class="whatsapp-chat" target="_blank">
        <i class="fab fa-whatsapp"></i>
    </a>

</body>
</html>