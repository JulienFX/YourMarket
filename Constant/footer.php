<!DOCTYPE html>
<html>

<head>
    <style>
        .footer {
            background-color: #333;
            color: #fff;
            padding: 20px;
            text-align: center;
        }

        .footer-content {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            align-items: center;
            gap: 20px;
        }

        .footer-links {
            flex-grow: 1;
            text-align: center;
        }

        .footer-links a {
            color: #fff;
            text-decoration: none;
            display: block;
            margin-bottom: 10px;
            transition: color 0.3s ease;
            font-family: 'Poppins', sans-serif;
            font-size: 14px;
        }

        .footer-links a:hover {
            color: #aaa;
        }

        .footer-newsletter {
            flex-grow: 1;
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .newsletter-title {
            font-family: 'Poppins', sans-serif;
            font-size: 16px;
            margin-bottom: 10px;
        }

        .subscribe-input {
            border-radius: 5px;
            padding: 8px;
            width: 200px;
            margin-bottom: 10px;
        }

        .subscribe-button {
            border-radius: 20px;
            padding: 10px 20px;
            background-color: #000;
            color: #fff;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s ease;
            font-family: 'Poppins', sans-serif;
            font-size: 14px;
        }

        .subscribe-button:hover {
            background-color: #333;
        }

        .footer-contact {
            flex-grow: 1;
            text-align: center;
        }

        .contact-title {
            font-family: 'Poppins', sans-serif;
            font-size: 16px;
            margin-bottom: 10px;
        }

        .contact-address {
            margin-bottom: 10px;
            font-family: 'Poppins', sans-serif;
            font-size: 14px;
        }

        .social-media {
            display: flex;
            justify-content: center;
        }

        .social-media img {
            width: 20px;
            height: 20px;
            margin-left: 5px;
            cursor: pointer;
            transition: opacity 0.3s ease;
        }

        .social-media img:hover {
            opacity: 0.7;
        }
    </style>
</head>

<body>
    <footer class="footer">
        <div class="footer-content">
            <div class="footer-links">
                <a href="#">Useful Links</a>
                <a href="#">About</a>
                <a href="#">FAQ</a>
                <a href="#">Delivery</a>
                <a href="#">Returns</a>
            </div>
            <div class="footer-newsletter">
                <div class="newsletter-title">Newsletter</div>
                <input class="subscribe-input" type="text" placeholder="Email Address">
                <button class="subscribe-button" type="button">Subscribe Now</button>
            </div>
            <div class="footer-contact">
                <div class="contact-title">Contact</div>
                <div class="contact-address">123 Commerce Street, City</div>
                <div class="social-media">
                    <img src="Photos/facebook-icon.png" alt="Facebook">
                    <img src="Photos/twitter-icon.png" alt="Twitter">
                    <img src="Photos/instagram-icon.png" alt="Instagram">
                </div>
            </div>
        </div>
    </footer>
</body>

</html>
