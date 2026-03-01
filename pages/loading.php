<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>loading</title>
    <style>
        /* Full screen overlay */
        .loader {
            display: none;
            /* hidden by default */
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;

            background: rgba(0, 0, 0, 0.5);
            z-index: 9999;

            justify-content: center;
            align-items: center;
        }

        /* Spinner */
        .spinner {
            width: 50px;
            height: 50px;
            border: 6px solid #ccc;
            border-top: 6px solid #db344aff;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        /* Animation */
        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }
    </style>
</head>

<body>
    <div id="loader" class="loader">
        <div class="spinner">
        </div>
    </div>
    <form action="process.php" method="POST" onsubmit="showLoader()">
        <button type="submit">Submit</button>
    </form>

</body>
<script>
    function showLoader() {
        document.getElementById("loader").style.display = "flex";
    }

    function hideLoader() {
        document.getElementById("loader").style.display = "none";
    }
</script>

</html>