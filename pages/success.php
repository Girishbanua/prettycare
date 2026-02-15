<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Order Successful</title>
    <link rel="stylesheet" href="../assets/css/index.css">
    <style>
        ::afterbody {
            margin: 0;
            /* font-family: 'Segoe UI', sans-serif; */
            background: linear-gradient(135deg, #f5f5f7, #ffe5e5);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        /* Container */
        .success-container {
            width: 100%;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        /* Card */
        .success-card {
            background: #fff;
            padding: 40px;
            border-radius: 20px;
            text-align: center;
            width: 380px;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.1);
            animation: fadeIn 0.6s ease-in-out;
        }

        /* Checkmark */
        .checkmark {
            width: 80px;
            height: 80px;
            background: #e35d5b;
            color: white;
            font-size: 40px;
            line-height: 80px;
            border-radius: 50%;
            margin: 0 auto 20px;
            animation: pop 0.4s ease;
        }

        /* Title */
        .success-card h1 {
            color: #e35d5b;
            margin-bottom: 10px;
        }

        /* Text */
        .success-card p {
            color: #666;
            font-size: 14px;
            margin-bottom: 25px;
        }

        /* Buttons */
        .actions {
            display: flex;
            gap: 15px;
            justify-content: center;
        }

        /* Common button */
        .btn {
            padding: 10px 20px;
            border-radius: 10px;
            text-decoration: none;
            font-size: 14px;
            transition: 0.3s;
        }

        /* Primary */
        .btn.primary {
            background: #e35d5b;
            color: white;
        }

        .btn.primary:hover {
            background: #d94b48;
            transform: translateY(-2px);
        }

        /* Secondary */
        .btn.secondary {
            border: 1px solid #e35d5b;
            color: #e35d5b;
        }

        .btn.secondary:hover {
            background: #e35d5b;
            color: white;
        }

        /* Animations */
        @keyframes pop {
            0% {
                transform: scale(0);
            }

            100% {
                transform: scale(1);
            }
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>

<body>

    <div class="success-container">

        <div class="success-card">

            <!-- Tick icon -->
            <div class="checkmark">
                ✓
            </div>

            <h1>Order Placed Successfully!</h1>
            <p>Thank you for your purchase. Your order has been confirmed.</p>

            <div class="actions">
                <a href="products.php" class="btn secondary">Continue Shopping</a>
                <a href="../user/orders.php" class="btn primary">View Orders</a>
            </div>

        </div>

    </div>

</body>

</html>