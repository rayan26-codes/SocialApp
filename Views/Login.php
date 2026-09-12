<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- Reuses your existing shared Auth stylesheet -->
    <link rel="stylesheet" href="Assets/Css/Auth.css">
</head>
<body>

    <main class="auth-container">
        <section class="auth-card">
            <header class="auth-header">
                <h2>Welcome Back</h2>
                <p>Please enter your details to sign in</p>
            </header>

            <?php if (isset($_SESSION['message']) && isset($_SESSION['status'])): ?>
                <div class="auth-message <?php echo $_SESSION['status']; ?>" id="authMessage" role="alert">
                    <p class="message-text"><?php echo $_SESSION['message']; ?></p>
                    <button type="button" class="close-message-btn" id="closeMessageBtn" aria-label="Close message">×</button>
                </div>
                <?php 
                    unset($_SESSION['message']);
                    unset($_SESSION['status']);
                ?>
            <?php endif; ?>

            <form action="" method="POST" class="auth-form">
                
                <!-- Email Field -->
                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input type="email" name="email" id="email" placeholder="john.doe@example.com" required>
                </div>

                <!-- Password Field with Toggle -->
                <div class="form-group">
                    <label for="password">Password</label>
                    <div class="password-wrapper">
                        <input type="password" name="password" id="password" placeholder="Enter your password" required>
                        <button type="button" class="toggle-password-btn" aria-label="Toggle password visibility">
                            <span class="eye-icon">👁️</span>
                        </button>
                    </div>
                </div>

                <!-- Submit Button -->
                <button type="submit" name="login" class="auth-btn">Login</button>
            </form>

            <footer class="auth-footer">
                <p>Don't have an account? <a href="index.php?page=signup">Sign Up</a></p>
            </footer>
        </section>
    </main>

    <script src="Assets/JS/Auth.js"></script>
</body>
</html>