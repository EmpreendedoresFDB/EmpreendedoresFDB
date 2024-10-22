<?php
session_start();

if (!isset($_SESSION['usuario_logado'])) {
    header("Location: areaAluno.html");
    exit();
} else {
    echo "<script>
    window.location.href = 'home.html';
  </script>";
}
?>