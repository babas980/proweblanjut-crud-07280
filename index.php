<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SISTEM INVENTORY</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: #0f172a; /* Warna dark navy yang modern */
            color: white;
            height: 100vh;
            display: flex;
            align-items: center;
            overflow: hidden;
        }
        .hero-section {
            background: linear-gradient(135deg, rgba(30, 41, 59, 0.9) 0%, rgba(15, 23, 42, 0.8) 100%);
            padding: 60px;
            border-radius: 30px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
        }
        .btn-start {
            background-color: #3b82f6;
            color: white;
            padding: 12px 35px;
            border-radius: 50px;
            font-weight: 600;
            transition: 0.3s;
            text-decoration: none;
            display: inline-block;
        }
        .btn-start:hover {
            background-color: #2563eb;
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(59, 130, 246, 0.4);
            color: white;
        }
        .feature-badge {
            background: rgba(59, 130, 246, 0.1);
            color: #60a5fa;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 0.8rem;
            margin-bottom: 20px;
            display: inline-block;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="row align-items-center">
        <div class="col-lg-6 hero-section">
            <span class="feature-badge">MUHAMMAD BABASSAMASI - A12.2024.07280</span>
            <h1 class="display-5 fw-bold mb-3">INVENTORY <span style="color: #3b82f6;">SEDERHANA.</span></h1>
            <p class="lead mb-5 text-secondary">
                Kelola stok produk elektronik dengan sistem inventory sederhana.
            </p>
            <div class="d-flex gap-3">
                <a href="dashboard.php" class="btn-start">Buka Dashboard</a>
            </div>
        </div>

        <div class="col-lg-6 d-none d-lg-block text-center">
            <img src="Muhammad Babassamasi.JPG" alt="Inventory Illustration" style="width: 50%; border-radius: 5%; filter: drop-shadow(0 0 30px rgba(59, 130, 246, 0.3));">
        </div>
    </div>
</div>

</body>
</html>