<?php ob_start(); ?>

<!-- VISTA ADMIN, PERMITE ELIMINAR USUARIO POR ID-->
<div class="delete-user-container">
    <h2>Eliminar usuario</h2>

    <?php if (isset($params['mensaje'])): ?>
        <p style="color:red;"><?php echo htmlspecialchars($params['mensaje']); ?></p>
    <?php endif; ?>

    <form action="index.php?ctl=admin" method="post" onsubmit="return confirm('¿Estás seguro de que deseas eliminar este usuario?');">
        <label for="user_id">ID del usuario a eliminar:</label>
        <input type="number" id="user_id" name="user_id" required>

        <button type="submit" class="logout-button" name="bEliminar">Eliminar usuario</button>
    </form>
</div>

<?php
$contenido = ob_get_clean();
include __DIR__ . '/layout.php';
?>
