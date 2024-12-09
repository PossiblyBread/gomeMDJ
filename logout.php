<?php
session_start();
// Destroy all session data
session_unset();
session_destroy();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="refresh" content="0;url=index.php"> <!-- Redirect to login page -->
    <script>
        sessionStorage.removeItem('modalShown');
    </script>
</head>
<body>
</body>
</html>
