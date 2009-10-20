<?php
session_start();
// Eliminar todas as variáveis de sessão.
session_unset();
// Finalmente, destruição da sessão.
session_destroy(); 
header("Location:.");
?>
