<?php ob_start(); ?>

<div class="tablaContainer">
    <h2 class="title-table">Datos del Usuario</h2>
    <table>
        <thead>
            <tr>
                <th>Campo</th>
                <th>Valor</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Nombre de usuario</td>
                <td><?php echo htmlspecialchars($_SESSION['nombreUsuario']); ?></td>
            </tr>
            <tr>
                <td>Correo electrónico</td>
                <td><?php echo htmlspecialchars($_SESSION['email']); ?></td>
            </tr>
            <tr>
                <td>Rol</td>
                <td><?php echo $_SESSION['nivel'] == 2 ? 'Administrador' : 'Usuario'; ?></td>
            </tr>
            <tr>
                <td>Foto de perfil</td>
                <td>
                    <img src="/dwes/Extraordinaria/evaluableextraordinaria/web/images/users/<?php echo htmlspecialchars($_SESSION['photo']); ?>" alt="Foto de perfil" class="userImg">
                </td>
            </tr>
        </tbody>
    </table>
</div>

<?php
$contenido = ob_get_clean();
include __DIR__ . '/layout.php';
?>
