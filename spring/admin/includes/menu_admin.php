<?php
//Funciones generales DB

function get_usuarios(){
}



?>
<div class="container" style="height: 100%;">
    <div class="row vertical-align1">
        <div class="btn-group btn-group-justified" role="group" aria-label="...">
            <div class="btn-group" role="group">
                <form action="<? echo $_SERVER['PHP_SELF']; ?>" method="post">
                    <input class="btn btn-default" type="submit" value="Salir"/>
                    <input type="hidden" name="close" value="0"/>
                </form>
            </div>
            <div class="btn-group" role="group">
                <button type="button" class="btn btn-default" onclick="javascript:location.href='main.php'">Dashboard</button>
            </div>
            <div class="btn-group" role="group">
                <button type="button" class="btn btn-default" onclick="javascript:location.href='sel1.php'">Registros</button>
            </div>
        </div>
    </div>
    <div id="loader">
        <p>Subiendo Archivo</p>
        <div id="bar_blank">
            <div id="bar_color"></div>
        </div>
        <div id="status"></div>
    </div>
