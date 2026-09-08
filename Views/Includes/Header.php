<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <!-- Stylesheet Integrations -->
    <link rel="stylesheet" href="Assets/Css/Main.css">
    <link rel="stylesheet" href="Assets/Css/Header.css">
    <link rel="stylesheet" href="Assets/Css/Sidebar.css">
    <link rel="stylesheet" href="Assets/Css/Footer.css">
    <link rel="stylesheet" href="Assets/Css/Home.css">
    <link rel="stylesheet" href="Assets/Css/Profile.css">
    <link rel="stylesheet" href="Assets/Css/Friends.css">
    <link rel="stylesheet" href="Assets/Css/CreatePosts.css">
</head>
<body>

    <!-- Opened global wrapper -->
    <div class="app-wrapper">

        <!-- Top Header Navigation -->
        <header class="app-header">
            <div class="header-left">
                <!-- Hamburger menu for mobile screen control -->
                <button type="button" id="sidebarToggle" class="menu-toggle-btn" aria-label="Toggle Navigation">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>
                <div class="header-logo">
                    <span class="logo-icon">⚡</span>
                    <span class="logo-text">MVCSocialApp</span>
                </div>
            </div>

            <div class="header-right">
                <nav class="header-nav">
                    <a href="index.php?page=home" class="nav-link active">Main App</a>
                    <a href="#" class="nav-link">Documentation</a>
                </nav>
                
                <div class="notification-badge">
                    <span class="badge-icon">🔔</span>
                    <span class="badge-count">3</span>
                </div>

                <div class="user-profile">
                    <div class="avatar">🪽</div>
                    <span class="user-name"><?php echo $_SESSION['firstname']; ?></span>
                </div>
            </div>
        </header>