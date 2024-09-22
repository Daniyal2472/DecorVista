<?php
session_start();

session_unset();
session_destroy();

echo "<script>
    window.location.href = '/DecorVista/decorvista/login.php';
</script>";
exit();
?>
