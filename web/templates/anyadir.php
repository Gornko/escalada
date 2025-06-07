<?php ob_start() ?>



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

    <h2>Nueva ascensión</h2>
    <div class="register-container">
        
        <br>
        <form action="index.php?ctl=anyadir" method="post" class="register-form">

            <label for="routename">Nombre de la ruta</label>
            <input type="text" id="routename" name="routename" required placeholder="Nombre de la ruta">
            <br>

            <label for="metros">Metros</label>
            <input type="number" id="metros" name="metros" required placeholder="Metros">
            <br>

            <label for="cintas">Cintas</label>
            <input type="number" id="cintas" name="cintas" required placeholder="Cintas">
            <br>

            <label for="pais">País</label>
            <input type="text" id="pais" name="pais" required placeholder="Pais">
            <br>

            <label for="localidad">Localidad</label>
            <input type="text" id="localidad" name="localidad" required placeholder="Localidad">
            <br>

            <label for="estilo">Estilo</label>
            <select name="estilo" id="estilo">
                <option value="3">Bulder</option>
                <option value="2">Clásica</option>
                <option value="1">Deportiva</option>
            </select>
            <br>

            <label for="largos">Largos</label>
            <input type="number" id="largos" name="largos" required placeholder="Largos">
            <br>

            <label for="pegues">Pegues</label>
            <input type="number" id="pegues" name="pegues" required placeholder="Pegues">
            <br>

            <label for="encadene">Encadene</label>
            <select name="encadene" id="encadene">
                <option value="1">A vista</option>
                <option value="2">Ensayada</option>
                <option value="3">Flash</option>
                <option value="4">Toprope</option>
            </select>
            <br>

            <label for="fecha">Fecha</label>
            <input type="date" id="fecha" name="fecha" required>
            <br>

            <label for="comentarios">Comentarios</label>
            <input type="text" id="comentarios" name="comentarios" required placeholder="Max 100 caracteres">
            <br>


            <br>
            <button type="submit" class="btn btn-register" name="bAnyadir">Añadir</button>
        </form>
    </div>

</div>





<?php
$contenido = ob_get_clean();
include __DIR__ . '/layout.php';

?>