<?php
// includes/footer.php

// Include config
require_once __DIR__ . '/../config/config.php';
?>



<footer class="bg-primary text-secondary py-12">
    <div class="container mx-auto px-6">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            <div>
                <h3 class="text-xl font-bold mb-4">STYLED</h3>
                <p class="text-secondary">Your one-stop shop for premium fashion essentials.</p>
            </div>

            <div>
                <h4 class="font-semibold mb-4">Quick Links</h4>
                <ul class="space-y-2">
                    <li><a href="../index.php" class="text-secondary  transition-colors duration-300">Home</a></li>
                    <li><a href="../products.php" class="text-secondary  transition-colors duration-300">Products</a>
                    </li>
                    <li><a href="../about.php" class="text-secondary  transition-colors duration-300">About Us</a></li>
                    <li><a href="../contact.php" class="text-secondary  transition-colors duration-300">Contact</a></li>
                </ul>
            </div>

            <div>
                <h4 class="font-semibold mb-4">Categories</h4>
                <ul class="space-y-2">
                    <li><a href="../products.php?category=hoodies"
                            class="text-secondary  transition-colors duration-300">Hoodies</a></li>
                    <li><a href="../products.php?category=tshirts"
                            class="text-secondary  transition-colors duration-300">T-Shirts</a></li>
                    <li><a href="../products.php?category=pants"
                            class="text-secondary  transition-colors duration-300">Pants</a></li>
                    <li><a href="../products.php?category=accessories"
                            class="text-secondary  transition-colors duration-300">Accessories</a></li>
                </ul>
            </div>

            <div>
                <h4 class="font-semibold mb-4">Contact Info</h4>
                <ul class="space-y-2 text-secondary">
                    <li>123 Fashion Street</li>
                    <li>Style City, SC 12345</li>
                    <li>info@styled.com</li>
                    <li>(123) 456-7890</li>
                </ul>
            </div>
        </div>

        <div class="border-t border-gray-800 mt-8 pt-8 text-center text-secondary">
            <p>&copy; <?php echo date('Y'); ?> STYLED. All rights reserved.</p>
        </div>
    </div>
</footer>

<script src="<?php echo BASE_URL; ?>assets/js/main.js"></script>
<?php include BASE_PATH . 'includes/cart-drawer.php'; ?>

</body>

</html>