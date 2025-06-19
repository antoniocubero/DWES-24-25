<?php

function obtenerMascotasPorTipo(PDO $pdo, array $tipos):array|int
{
    if (empty($tipos)) {        
        return -1;
    }    

    try {
        $tipos=array_values($tipos); //Reindexamos el array (para recorrerlo con bucle for/count)
        $SQLPART=implode (" OR ",array_fill(0,count($tipos),'tipo=?'));
        $query = "SELECT id, nombre, tipo FROM mascotas WHERE ($SQLPART) AND publica = \"si\"";
        $stmt = $pdo->prepare($query);
        for ($i=1;$i<=count($tipos);$i++)
        {
            $stmt->bindValue($i,$tipos[$i-1]);
        }        
        $mascotas = $stmt->execute()?$stmt->fetchAll(PDO::FETCH_ASSOC):false;
        return $mascotas ? $mascotas : -1;

    } catch (PDOException $e) {
        return -2;
    }
}

function obtenerMascotasDeUsuario(PDO $pdo, int $userid): array|int
{
    try {
        $query = "
            SELECT 
                m.nombre AS mascota_nombre,
                m.tipo AS mascota_tipo,
                m.publica AS mascota_publica,
                u.login AS propietario_login
            FROM 
                mascotas m
            INNER JOIN 
                usuarios u
            ON 
                m.usuario_id = u.id
            WHERE 
                u.id = :userid
        ";
        $stmt = $pdo->prepare($query);
        $stmt->bindValue(':userid', $userid, PDO::PARAM_INT);        
        $mascotas = (!$stmt->execute())?:$stmt->fetchAll(PDO::FETCH_ASSOC);
        return $mascotas ?: -1;
    } catch (PDOException $e) {
        return -2;
    }
}
