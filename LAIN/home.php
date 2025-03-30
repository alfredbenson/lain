<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Split-Bill</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <style>
        body { background: #f8f9fa; font-family: Arial, sans-serif; overflow: hidden;  width: 100%;
            height: 100%;
        }
        .background-text {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            overflow: hidden;
        }
        .background-text span {
            position: absolute;
            font-size: 4rem;
            font-weight: bold;
            color: rgba(255, 255, 255, 0.1);
            animation: moveText 10s linear infinite;
        }
        @keyframes moveText {
            0% { transform: translateY(100vh); opacity: 0; }
            50% { opacity: 1; }
            100% { transform: translateY(-100vh); opacity: 0; }
        }
        .hero-section {
            background: linear-gradient(135deg, #343a40,rgb(16, 49, 73));
            color: white;
            padding: 120px 20px;
            text-align: center;
            position: relative;
        }
        .hero-section h1 { font-size: 2.5rem; }
        .hero-section p { font-size: 1.2rem; }
        .features-section {
            padding: 60px 20px;
        }
        .feature-box {
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(146, 28, 28, 0.1);
            text-align: center;
            transition: transform 0.3s ease-in-out;
        }
        .feature-box:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        }
        .feature-box i { color: #007bff; margin-bottom: 15px; }
        .footer {
            background: #212529;
            color: white;
            text-align: center;
            padding: 20px;
            position: relative;
            bottom: 0;
            width: 100%;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">
                <img src="images/logo.png" alt="Bill Management Logo" height="40">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="dashboard.php">Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link" href="">Features</a></li>
                    <li class="nav-item"><a class="nav-link" href="">Contact</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="background-text">
        <span style="left: 10%; animation-delay: 0s;">ITech</span>
        <span style="left: 30%; animation-delay: 2s;">ITech</span>
        <span style="left: 50%; animation-delay: 4s;">ITech</span>
        <span style="left: 70%; animation-delay: 6s;">ITech</span>
        <span style="left: 90%; animation-delay: 8s;">ITech</span>
    </div>

    <!-- Hero Section -->
    <div class="hero-section">
        <h1>Welcome to Split-Bill </h1>
        <p>Efficiently track, split, and manage your bills with ease.</p>
        <a href="dashboard.php" class="btn btn-primary btn-lg mt-3">Go to Dashboard</a>
    </div>

    <!-- Features Section -->
    <div class="container features-section">
        <div class="row g-4">
            <div class="col-md-4">
                <div class="feature-box">
                    <i class="fas fa-file-invoice-dollar fa-3x"></i>
                    <h3>Bill Tracking</h3>
                    <p>Keep a record of all your bills and payments in one place.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-box">
                    <i class="fas fa-users fa-3x"></i>
                    <h3>Bill Splitting</h3>
                    <p>Split expenses with friends, roommates, or colleagues easily.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-box">
                    <i class="fas fa-chart-line fa-3x"></i>
                    <h3>Reports & Insights</h3>
                    <p>Generate reports and gain insights on your spending habits.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <div class="footer">
        <p>&copy; 2025 Bill Management System. All rights reserved.</p>
    </div>
</body>
</html>
