<html>
    <head>
        <meta charset="UTF-8">
        <title>Mostrar incidencias</title>
        <style>
            table{
                border-collapse: collapse;
            }
            tr:nth-child(odd) {background-color: #e5e5e5;}/*Esto hace que pinte las líneas impares con un fondo gris. Para las pares sería (even) en lugar de (odd)*/
        </style>
    </head>
    <body>
        <form method="get" name="for_edita">
        <h2><p>Esta página muestra una tabla con todas las incidencias</p></h2>
        <p><input type="button" onclick="location.href='http://localhost/Pruebas_PHP/horfeus'" name="boton_atras" value="Volver a página principal">
        <input type="submit" style="background-color: #66ccff "name="boton_editar" value="Editar incidencia"</p>

        <?php
        require ('datos_conexion.php');//Uso los datos de conexcion que están en el fichero conexion.php
        $conexion= mysqli_connect($db_host, $db_usuario, $db_clave);
        if (mysqli_connect_errno()){
            echo "No se ha podido conectar con la BD";
            exit();
        }
        mysqli_select_db($conexion, $db_nombre) or die("No se encuentra la BD");
        mysqli_set_charset($conexion, "utf8");
        $consulta="Select * from horfeus order by Id";
        $resultado= mysqli_query($conexion, $consulta);
        echo "<table border=1>";
        echo "<tr><th bgcolor='#BDC3C7'>Id</th>";
        echo "<th bgcolor='#BDC3C7'>Texto de apertura</th>";
        echo "<th bgcolor='#BDC3C7'>Resumen</th>";
        echo "<th bgcolor='#BDC3C7'>Texto de cierre</th>";
        echo "<th bgcolor='#BDC3C7'>Fecha</th>";
        while($fila= mysqli_fetch_array($resultado,MYSQLI_ASSOC)){
            echo "<tr><td style='padding-left:10px;padding-right:10px'>";
            echo $fila['Id'] . "</td><td style='padding-left:10px;padding-right:10px; width: 35%'>";
            echo $fila['Texto_apertura'] . "</td><td style='padding-left:10px;padding-right:10px'> ";
            echo $fila['Resumen_cierre'] . "</td><td style='padding-left:10px;padding-right:10px; width: 35%'> ";
            echo $fila['Texto_cierre'] . "</td><td style='padding-left:10px;padding-right:10px'>";
            echo $fila['Fecha'] . "</td></tr>";
         }
        echo"</table>";
        
        // Hasta aquí muestra una tabla con los registros que hay en la tabla alumnos
        ?>
        <p><input type="button" onclick="location.href='http://localhost/Pruebas_PHP/horfeus'" name="boton_atras" value="Volver a página principal">
            <input type="submit" style="background-color: #66ccff "name="boton_editar" value="Editar incidencia"</p>
        <?php
        if (isset($_GET['boton_editar'])){
            echo "<p>Selecciona el Número de incidencia que quieres modificar</p>";
            echo "<select name='combo_id' onchange='submit()'>";//Uso la funcion onchange para que cada vez que cambie una opción del combo se muestre el formulario en vez de dar al botón "Enviar"
            echo "<option value=0>Seleccione un número</option>";//Pongo el combo a 0 para que al cambiar a un id me muestre ese alumno
            $sql="select Id from horfeus order by Id";
            $result_nombre= mysqli_query($conexion, $sql);
            while($fila= mysqli_fetch_array($result_nombre,MYSQLI_ASSOC)){
                echo '<option value="'.$fila[Id].'">'.$fila[Id].'</option>';//Rellena el combo con los nombres de los alumnos
            }

            echo "</select>";
        }
        if (isset($_GET['combo_id'])){
            $seleccionada=$_GET['combo_id'];
            echo "<p>La incidencia es $seleccionada</p>";
            echo "<p>Aquí puedes modificar los datos de la incidencia</p>";
            echo "<table border=1>";
            $sql_buscar="select * from horfeus where Id like'$seleccionada'";
            $result_buscar= mysqli_query($conexion, $sql_buscar);
            echo "<tr><th bgcolor='#BDC3C7'>Id</th>";
            echo "<th bgcolor='#BDC3C7'>Texto de apertura</th>";
            echo "<th bgcolor='#BDC3C7'>Resumen</th>";
            echo "<th bgcolor='#BDC3C7'>Texto de cierre</th>";
            echo "<th bgcolor='#BDC3C7'>Fecha</th>";
            while($fila= mysqli_fetch_array($result_buscar,MYSQLI_ASSOC)){
                echo "<tr><td style='padding-left:10px;padding-right:10px'>";
                echo "<input type='text' name='id' readonly value='{$fila['Id']}'>" . "</td><td style='padding-left:10px;padding-right:10px; width: 37%'>";
                echo "<textarea name='t_apertura' rows='10' cols='100'>" . $fila['Texto_apertura'] . "</textarea>" . "</td><td style='padding-left:10px;padding-right:10px'>";
                echo "<textarea name='t_resumen' rows='2' cols='40'>" . $fila['Resumen_cierre'] . "</textarea>" . "</td><td style='padding-left:10px;padding-right:10px; width: 37%'> ";
                echo "<textarea name='t_cierre' rows='10' cols='100'>" . $fila['Texto_cierre'] .  "</textarea>" . "</td><td style='padding-left:10px;padding-right:10px'>";
                echo $fila['Fecha'] . "</td></tr>";
            }
            echo "</table>";
            echo '<br><input type="reset" name="cancel" value="Cancelar">';
            echo '&nbsp<input type="submit" name="actualizar" style="background-color:#77FF33" value="Actualizar">';
        }
        if (isset($_GET['actualizar'])){
            $id=$_GET['id'];
            $text_ap=$_GET['t_apertura'];
            $text_res=$_GET['t_resumen'];
            $text_cierre=$_GET['t_cierre'];
            $sql_actualizar="update horfeus set Texto_apertura='$text_ap', Resumen_cierre='$text_res', Texto_cierre='$text_cierre' where Id='$id'";
            $result_actualizar= mysqli_query($conexion, $sql_actualizar);
            if ($result_actualizar==FALSE){
                echo 'Error en la consulta';
            }else{
                echo "<br><br>Registro actualizado<br><br>";
                echo "<table border='1' style='border-collapse: collapse' cellpadding=7px>";
                echo "<tr><th bgcolor='#BDC3C7' colspan='5'>Estos son los nuevos datos</th></tr>";
                echo "<tr><td>$id</td><td>$text_ap</td><td>$text_res</td><td>$text_cierre</td></tr>";
                echo "</table>";
            }
        }
        ?>
        </form>
    </body>
</html>
