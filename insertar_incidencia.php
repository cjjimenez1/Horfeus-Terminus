<html>
    <!--
Esta página pinta un formulario que se rellena para insertar esos datos en una BBDD
-->
    <head>
        <meta charset="UTF-8">
        <title>Formulario insertar incidencias en BBDD</title>
    </head>
    <body>
        <?php
        
        require ('datos_conexion.php');//Uso los datos de conexcion que están en el fichero conexion.php
        $conexion= mysqli_connect($db_host, $db_usuario, $db_clave);
        if (mysqli_connect_errno()){
            echo "No se ha podido conectar con la BD";
            exit();
        }
        mysqli_select_db($conexion, $db_nombre) or die("No se encuentra la BD");
        mysqli_set_charset($conexion, "utf8");
        ?>
        <form method="get" name="form">
            <table border="1" style="border-collapse: collapse">
                <tr><th colspan="2" bgcolor='#BDC3C7'>Datos de la incidencia a insertar</th></tr>
                <tr><td>Texto completo de apertura:</td><td><textarea name="t_apertura" rows="10" cols="100"></textarea></td></tr>
                <tr><td>Resumen de cierre:</td><td><textarea name="resumen" rows="2" cols="100"></textarea></td></tr>
                <tr><td>Texto completo de cierre:</td><td><textarea name="t_cierre" rows="10" cols="100"></textarea></td></tr>
            </table>
                <p><input type="submit" name="boton_insertar" value="Insertar">
                <input type="submit" name="boton_cancelar" value="Cancelar">
                <!--<input type="button" onclick="history.go(-2)" name="boton_atras" value="Volver atrás"> Esto es un botón que retrocede en el historial 2 veces pero me gusta más el del enlace-->
                <input type="button" onclick="location.href='http://localhost/Pruebas_PHP/horfeus/'" name="boton_atras" value="Volver a página principal"></p>
            
        </form>
        <?php
        if (isset($_GET['boton_insertar'])){
            $t_apertura=$_GET['t_apertura'];//Guardo en $t_apertura el texto del cuadro de texto de apertura de la incidencia
            $resumen=$_GET['resumen'];//Guardo en $resumen el el texto del cuadro de texto resumen de la incidencia
            $t_cierre=$_GET['t_cierre'];//Guardo en $t_cierre el texto del cuadro de texto de cierre de la incidencia
            $fecha=date('Y-m-d H:i:s');////Guardo en $fecha la fecha actual
            if ($t_apertura==""){
                echo "Debe introducir el texto de apertura de la incidencia";
                exit();
            }else if ($resumen==""){
                echo "Debe introducir el resumen del cierre de la incidencia";
                exit();
            }else if ($t_cierre==""){
                echo "Debe introducir el texto completo de cierre de la incidencia";
                exit();
            }
            require ('datos_conexion.php');//Uso los datos de conexcion que están en el fichero conexion.php
            $conexion= mysqli_connect($db_host, $db_usuario, $db_clave);
            if (mysqli_connect_errno()){
                echo "No se ha podido conectar con la BD";
                exit();
            }
            mysqli_select_db($conexion, $db_nombre) or die("No se encuentra la BD");
            mysqli_set_charset($conexion, "utf8");
            $sql_id="SELECT MAX(Id)+1 FROM horfeus";//guardo en $sql_id el mayor número id y le sumo 1
            $resulset_id= mysqli_query($conexion, $sql_id);//ejecuto la sentencia
            $resultado_id= mysqli_fetch_row($resulset_id);//guardo el resultado de la sentencia en $resultado_id que es un array
            $sql="INSERT INTO horfeus (Id, Texto_apertura, Resumen_cierre, Texto_cierre, Fecha) VALUES ('$resultado_id[0]', '$t_apertura','$resumen','$t_cierre','$fecha')";
            /*Esto es otra forma de sacar el id. Primero hago el SELECT MAX(id)+1 y lo guardo en $SQL_id, ejecuto la consulta y la guardo en $resulset_id
             luego recorro el resulset y guardo el resultado en $resultado_id que es un array. Después inserto y muestro en la tabla la primera posición del array "$resultado_id[0]"*/
            $resultado= mysqli_query($conexion, $sql);
            if($resultado==FALSE){
                echo"Error en la consulta";
            }else{
                echo "Registro insertado<br><br>";
                echo "<table border='1' style='border-collapse: collapse'><tr><td>Id</td><td>$resultado_id[0]</td></tr>";
                echo "<tr><td>Texto apertura</td><td>$t_apertura</td></tr>";
                echo "<tr><td>Resumen cierre</td><td>$resumen</td></tr>";
                echo "<tr><td>Texto cierre</td><td>$t_cierre</td></tr>";
                echo "<tr><td>Fecha</td><td>$fecha</td></tr></table>";

            }
        }
        
        ?>
    </body>
</html>
