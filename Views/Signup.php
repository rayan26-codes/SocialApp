<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create an Account</title>
    <!-- Link to the shared Auth stylesheet -->
    <link rel="stylesheet" href="Assets/Css/Auth.css">
</head>
<body>

    <main class="auth-container">
        <section class="auth-card">
            <header class="auth-header">
                <h2>Get Started</h2>
                <p>Create your account to join us</p>
            </header>

            <section class="auth-card">

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
                
                <!-- Name Row -->
                <div class="form-row">
                    <div class="form-group">
                        <label for="first_name">First Name</label>
                        <input type="text" name="firstname" id="first_name" placeholder="John" required>
                    </div>
                    <div class="form-group">
                        <label for="last_name">Last Name</label>
                        <input type="text" name="lastname" id="last_name" placeholder="Doe" required>
                    </div>
                </div>

                <!-- Email Field -->
                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input type="email" name="email" id="email" placeholder="john.doe@example.com" required>
                </div>

                <!-- Age Field -->
                <div class="form-group">
                    <label for="age">Age</label>
                    <input type="number" name="age" id="age" placeholder="21" min="1" max="120" required>
                </div>

                <!-- Password Field with Toggle -->
                <div class="form-group">
                    <label for="password">Password</label>
                    <div class="password-wrapper">
                        <input type="password" name="password" id="password" placeholder="Create a password" required>
                        <button type="button" class="toggle-password-btn" aria-label="Show password">
                            <span class="eye-icon"></span>
                        </button>
                    </div>
                </div>

                <!-- Confirm Password Field with Toggle -->
                <div class="form-group">
                    <label for="confirm_password">Confirm Password</label>
                    <div class="password-wrapper">
                        <input type="password" name="confirm_password" id="confirm_password" placeholder="Confirm your password" required>
                        <button type="button" class="toggle-password-btn" aria-label="Show password">
                            <span class="eye-icon"></span>
                        </button>
                    </div>
                </div>

                <!-- Submit Button -->
                <button type="submit" name="signup" class="auth-btn">Create Account</button>
            </form>

            <footer class="auth-footer">
                <p>Already have an account? <a href="index.php?page=login">Login</a></p>
            </footer>
        </section>
    </main>

    <!-- External JavaScript for toggle password interaction -->
    <script src="Assets/JS/Auth.js"></script>
</body>
</html>