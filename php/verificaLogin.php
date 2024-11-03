<?php
session_start();

if (!isset($_SESSION['usuario_logado'])) {
    header("Location: ../html-css/areaAluno.html");
    exit();
} else {
    echo "<script>
    window.location.href = 'home.php';
  </script>";
}
?>