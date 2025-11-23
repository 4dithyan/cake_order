<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sugar Studio: Where Art Meets Confection</title>
    <link rel="stylesheet" href="style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;700&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
    <!-- Font Awesome for WhatsApp icon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>

    <?php include 'header.php'; ?>

    <main>
        <section class="hero">
            <div class="hero-text">
                <h1>Sugar Studio</h1>
                <p>Where Art Meets Confection.</p>
                <a href="products.php" class="cta-button">Begin Your Custom Cake Journey</a>
            </div>
        </section>

        <section class="content-section" id="welcome">
            <h2>Crafting Edible Masterpieces</h2>
            <p class="intro-text">We believe cake should be more than a dessert—it should be a centerpiece. Our philosophy combines exquisite flavors with breathtaking design to create a memorable experience for your most important moments.</p>
        </section>

        <section class="content-section" id="bestseller">
            <div class="bestseller-layout">
                <div class="bestseller-image">
                    <img src="https://images.unsplash.com/photo-1588195538326-c5b1e9f80a1b?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1050&q=80" alt="Our signature gold-dusted rose cake">
                </div>
                <div class="bestseller-info">
                    <h2>Our Signature Creation</h2>
                    <h3>The Gold-Dusted Rose</h3>
                    <p>Experience perfection with our most requested cake: layers of delicate vanilla bean sponge, raspberry-rosewater jam, and Swiss meringue buttercream, adorned with a handcrafted sugar rose and a touch of edible gold.</p>
                    <a href="products.php" class="cta-button">Explore Flavors</a>
                </div>
            </div>
        </section>

        <section class="content-section" id="sweets">
            <h2>Beyond the Cake</h2>
            <p class="intro-text">Discover our collection of delicate confections, perfect for any occasion.</p>
            <div class="gallery-grid-featured">
                <div class="featured-item">
                    <img src="https://images.unsplash.com/photo-1558326567-98ae2405596b?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=687&q=80" alt="A box of colorful macarons">
                    <h3>Artisanal Macarons</h3>
                </div>
                <div class="featured-item">
                    <img src="https://images.unsplash.com/photo-1614707267537-b85aaf00c8b2?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=687&q=80" alt="Beautifully decorated cupcakes with floral designs">
                    <h3>Designer Cupcakes</h3>
                </div>
                <div class="featured-item">
                    <img src="https://images.unsplash.com/photo-1599784379462-35a1a684a23b?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=687&q=80" alt="Custom iced sugar cookies">
                    <h3>Custom Cookies</h3>
                </div>
            </div>
        </section>

        <section class="content-section" id="reviews">
            <h2>What Our Clients Say</h2>
            <div class="reviews-container">
                <div class="review-card">
                    <blockquote>"The most stunning wedding cake I have ever seen. It was the centerpiece of our reception and tasted even better than it looked! Thank you, Sugar Studio."</blockquote>
                    <cite>- Priya & Rohan</cite>
                </div>
                <div class="review-card">
                    <blockquote>"An absolute artist. The sculpture cake for my husband's 40th was a masterpiece. Every detail was perfect. Unforgettable!"</blockquote>
                    <cite>- Anjali R.</cite>
                </div>
            </div>
        </section>

        <section class="content-section" id="gallery-glimpse">
            <h2>A Glimpse of the Gallery</h2>
            <div class="gallery-grid-featured">
                <div class="featured-item">
                    <img src="https://images.unsplash.com/photo-1574085733319-396567b41b4a?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=688&q=80" alt="Elegant white wedding cake with gold leaf">
                    <h3>Wedding Cakes</h3>
                </div>
                <div class="featured-item">
                    <img src="https://images.unsplash.com/photo-1627834585641-58d7211a76f2?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=687&q=80" alt="Sculptural birthday cake with abstract blue shapes">
                    <h3>Sculptural Art</h3>
                </div>
                <div class="featured-item">
                    <img src="https://images.unsplash.com/photo-1606983340126-99ab4feaa64a?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=687&q=80" alt="Minimalist cake with a single sugar flower">
                    <h3>Celebration Cakes</h3>
                </div>
            </div>
             <a href="gallery.php" class="view-gallery-link">View Full Gallery →</a>
        </section>

        <section class="content-section" id="location">
             <h2>Visit Our Studio</h2>
             <div class="location-layout">
                   <div class="location-details">
                       <p><strong>Sugar Studio</strong></p>
                       <p>123 Lilly Street, Panampilly Nagar</p>
                       <p>Kochi, Kerala 682036</p>
                       <p><strong>Hours:</strong> By Appointment Only</p>
                       <a href="#" class="cta-button">Get Directions</a>
                   </div>
                   <div class="map-embed">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3929.132899478114!2d76.306538!3d9.993916!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3b080d3091986927%3A0x2d544622b7a201a1!2sPanampilly%20Nagar%2C%20Kochi%2C%20Ernakulam%2C%20Kerala!5e0!3m2!1sen!2sin!4v1694708123456" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                   </div>
             </div>
        </section>

        <section class="content-section" id="contact-promo">
            <h2>Have a Vision?</h2>
            <p class="intro-text">Let's bring your dream cake to life. We'd love to hear about your event and begin the creative process with you.</p>
            <a href="#" class="cta-button">Start a Consultation</a>
        </section>
    </main>

    <?php include 'footer.php'; ?>
    
    <!-- WhatsApp Chat Icon -->
    <a href="https://wa.me/919876543210" class="whatsapp-chat" target="_blank">
        <i class="fab fa-whatsapp"></i>
    </a>

</body>
</html>