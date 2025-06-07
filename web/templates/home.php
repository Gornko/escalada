<?php ob_start() ?>


<div class="tablaContainer">
    <h2 class="title-table">Logbook de ascensiones</h2>



    <table border="1" cellpadding="8" cellspacing="0">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Metros</th>
                <th>Cintas</th>
                <th>País</th>
                <th>Localidad</th>
                <th>Estilo</th>
                <th>Largos</th>
                <th>Pegues</th>
                <th>Encadene</th>
                <th>Fecha</th>
                <th>Comentarios</th>
                <th>Media</th>
            </tr>
        </thead>
        <tbody>
            <?php if (isset($params['mensaje'])): ?>
                <p><?php echo $params['mensaje'] ?></p>
            <?php else: ?>
                <?php foreach ($params as $ruta): ?>
                    <tr>
                        <td><?= htmlspecialchars($ruta['route_name']) ?></td>
                        <td><?= htmlspecialchars($ruta['meters']) ?></td>
                        <td><?= htmlspecialchars($ruta['draws']) ?></td>
                        <td><?= htmlspecialchars($ruta['country']) ?></td>
                        <td><?= htmlspecialchars($ruta['location']) ?></td>
                        <td><?= htmlspecialchars($ruta['style']) ?></td>
                        <td><?= htmlspecialchars($ruta['pitches']) ?></td>
                        <td><?= htmlspecialchars($ruta['tries']) ?></td>
                        <td><?= htmlspecialchars($ruta['ascent_type']) ?></td>
                        <td><?= htmlspecialchars($ruta['date']) ?></td>
                        <td><?= nl2br(htmlspecialchars($ruta['comments'])) ?></td>
                        <td><?= htmlspecialchars($ruta['photo']) ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>

</div>


<?php
$contenido = ob_get_clean();
include __DIR__ . '/layout.php';
