<script>
    var navbar_desplegable = document.querySelector(".navbar_desplegable");
    var flag = false;

    document.getElementById("boton_desplegable").addEventListener('click', ()=>{
        flag = !flag;
        if(flag)
        {
            navbar_desplegable.style.display = "block";
        }
        else
        {
            navbar_desplegable.style.display = "none";
        }
    });
</script>