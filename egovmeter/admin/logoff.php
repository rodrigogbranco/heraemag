<?php
session_start();
// Eliminar todas as vari�veis de sess�o.
session_unset();
// Finalmente, destrui��o da sess�o.
session_destroy(); 
header("Location:.");
?>
