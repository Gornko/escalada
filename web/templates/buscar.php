<?php ob_start() ?>


<div class="content">

    <div class="home-container">

        <div class="avisos">
            <?php if (isset($params['mensaje'])) : ?>
                <b><span style="color: rgba(200, 119, 119, 1);"><?php echo $params['mensaje'] ?></span></b>
            <?php endif; ?>

            <br>
            <?php foreach ($errores as $error) { ?>
                <b><span style="color: rgba(200, 119, 119, 1);"><?php echo $error . "<br>"; ?></span></b>
            <?php } ?>

        </div>

        <div class="register-container">
            <h2>Buscar por:</h2>
            <br>
            <form action="index.php?ctl=buscar" method="post" class="register-form">

                <label for="routename">Nombre</label>
                <input type="text" id="routename" name="routename" placeholder="Nombre de la ruta">
                <button type="submit" class="logout-button" name="bNombre">Buscar</button>
                <br>

                <!--
            <label for="metros">Metros</label>
            <input type="number" id="metros" name="metros" required placeholder="Metros">
            <br>
            -->

                <!--
            <label for="cintas">Cintas</label>
            <input type="number" id="cintas" name="cintas" required placeholder="Cintas">
            <br>
            -->

                <label for="pais">País</label>
                <input type="text" id="pais" name="pais" placeholder="Pais">
                <button type="submit" class="logout-button" name="bPais">Buscar</button>
                <br>

                <!--
            <label for="localidad">Localidad</label>
            <input type="text" id="localidad" name="localidad" required placeholder="Localidad">
            <br>
            -->

                <label for="estilo">Estilo</label>
                <select name="estilo" id="estilo">
                    <option value="3">Bulder</option>
                    <option value="2">Clásica</option>
                    <option value="1">Deportiva</option>
                </select>
                <button type="submit" class="logout-button" name="bEstilo">Buscar</button>
                <br>

                <!--
            <label for="largos">Largos</label>
            <input type="number" id="largos" name="largos" required placeholder="Largos">
            <br>
            -->

                <!--
            <label for="pegues">Pegues</label>
            <input type="number" id="pegues" name="pegues" required placeholder="Pegues">
            <br>
            -->

                <label for="encadene">Encadene</label>
                <select name="encadene" id="encadene">
                    <option value="1">A vista</option>
                    <option value="2">Ensayada</option>
                    <option value="3">Flash</option>
                    <option value="4">Toprope</option>
                </select>
                <button type="submit" class="logout-button" name="bEncadene">Buscar</button>
                <br>

                <!--
            <label for="fecha">Fecha</label>
            <input type="date" id="fecha" name="fecha" required>
            <br>
            -->

                <!--
            <label for="comentarios">Comentarios</label>
            <input type="text" id="comentarios" name="comentarios" required placeholder="Max 100 caracteres">
            <br>
            -->

            </form>
        </div>

    </div>
    <br>

    <div class="tablaContainer">
        <h2 class="title-table">Resultado:</h2>



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
                </tr>
            </thead>
            <tbody>
                <?php if (isset($params['mensaje'])): ?>
                    <p><?php echo $params['mensaje'] ?></p>
                <?php else: ?>
                    <?php foreach ($rutas as $ruta): ?>
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
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>

    </div>

</div>





<?php
$contenido = ob_get_clean();
include __DIR__ . '/layout.php';

?>