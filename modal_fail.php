<div id="modal_inicio_sesion_fail" style="display: block;">
    <div class="modal_nav">
        <span class="modal_cerrar">X</span>
    </div>
    <div class="modal_main" style="margin: auto;">
        <h1 class="modal_titulo">¡Ingresá en Torino Fútbol!</h1><br>
        <form action="./iniciar_sesion.php" method="post">
            <div class="form_opcion">
                <label for="email">Correo Electrónico</label>
                <input class="modal_input" type="email" name="email" required autocomplete="off">
            </div>
            <div class="form_opcion">
                <label for="pass">Contraseña</label>
                <input class="modal_input" type="password" name="pass" required autocomplete="off">
            </div>
            <span style="color: crimson;"><i>Usuario o contraseña incorrectos!</i></span>
            <div class="form_opcion">
                <input class="modal_enviar modal_input" type="submit" value="Iniciar Sesión">
            </div>
        </form>
    </div>
</div>