<?php

// Unset all session variables
session_unset();

// Destroy the session
session_destroy();

// Redirect to login page or wherever you want
header("Location: admin-login.php");
exit();
?>

<script>
    history.pushState(null, null, location.href);
    window.onpopstate = function () {
        history.go(1);
    };
</script>