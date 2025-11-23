<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - Sugar Studio</title>
    <link rel="stylesheet" href="style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;700&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>

    <?php include 'header.php'; ?>

    <main>
        <section class="content-section">
            <div class="page-header">
                <h1>Contact Us</h1>
                <p class="intro-text">We'd love to hear from you. Reach out to us for consultations, custom orders, or any inquiries.</p>
            </div>

            <div class="contact-layout">
                <div class="contact-info">
                    <h2>Get In Touch</h2>
                    <div class="contact-method">
                        <i class="fas fa-map-marker-alt"></i>
                        <div>
                            <h3>Visit Our Studio</h3>
                            <p>Sugar Studio</p>
                            <p>Rajakumari , Idukki</p>
                            <p>Kerala 685619</p>
                        </div>
                    </div>

                    <div class="contact-method">
                        <i class="fas fa-phone"></i>
                        <div>
                            <h3>Call Us</h3>
                            <p>+91 98765 43210</p>
                            <p>By appointment only</p>
                        </div>
                    </div>

                    <div class="contact-method">
                        <i class="fas fa-envelope"></i>
                        <div>
                            <h3>Email Us</h3>
                            <p>contact@sugarstudio.com</p>
                            <p>For general inquiries</p>
                        </div>
                    </div>

                    <div class="contact-method">
                        <i class="fab fa-whatsapp"></i>
                        <div>
                            <h3>WhatsApp</h3>
                            <p>+91 98765 43210</p>
                            <p>Quick responses & consultations</p>
                        </div>
                    </div>
                </div>

                <div class="contact-form">
                    <h2>Send a Message</h2>
                    <form action="#" method="POST">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" id="name" name="name" required>
                        </div>

                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" id="email" name="email" required>
                        </div>

                        <div class="form-group">
                            <label for="phone">Phone</label>
                            <input type="tel" id="phone" name="phone">
                        </div>

                        <div class="form-group">
                            <label for="subject">Subject</label>
                            <input type="text" id="subject" name="subject" required>
                        </div>

                        <div class="form-group">
                            <label for="message">Message</label>
                            <textarea id="message" name="message" rows="5" required></textarea>
                        </div>

                        <button type="submit" class="cta-button">Send Message</button>
                    </form>
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