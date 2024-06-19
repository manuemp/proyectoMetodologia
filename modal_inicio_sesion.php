<script>
    var iniciar_sesion_desplegable = document.getElementById("iniciar_sesion_desplegable");
    var iniciar_sesion = document.getElementById("iniciar_sesion");
    var modal = document.getElementById("modal_inicio_sesion");
    var modal_fail = document.getElementById("modal_inicio_sesion_fail");
    var cerrar_modal = document.querySelectorAll(".modal_cerrar");
    var modal_background = document.getElementById("modal_background");

    window.onbeforeunload = history.pushState(null, null, "index.php");

    iniciar_sesion.addEventListener('click', ()=>
    {
        modal_background.style.display = "block";
        modal.style.display = "block";
    });

    iniciar_sesion_desplegable.addEventListener('click', ()=>
    {
        modal_background.style.display = "block";
        modal.style.display = "block";
    });

    cerrar_modal.forEach(cerrar =>{
        cerrar.addEventListener('click', ()=>
        {
            modal_background.style.display = "none";
            modal.style.display = "none";
            modal_fail.style.display = "none";
        });
    })
</script>