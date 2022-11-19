<?php

namespace Controllers;

use Model\Cita;
use Model\CitaServicio;
use Model\Servicio;

class APIController
{
    public static function index()
    {
        $servicio = Servicio::all();

        echo json_encode($servicio);
    }

    public static function guardar()
    {
        // Creamos la Cita con los datos recibidos desde fetch
        $cita = new Cita($_POST);
        // Guardamos la cita y devuelve el ID de la cita
        $resultado = $cita->guardar();

        if ($resultado) {
            $idCita = $resultado['id'];
            // Separamos el String de servicios separado por comas a un arreglo
            $idServicios = explode(",", $_POST['servicios']);

            // Itera todos los servicios y crea su relación CitaServicios
            foreach ($idServicios as $idServicio) {
                $array = [
                    'citas_id' => $idCita,
                    'servicios_id' => $idServicio
                ];
                // Instanciamos un nuevo CitaServicio
                $citaServicio = new CitaServicio($array);
                // Guardamos en DB
                $citaServicio->guardar();
            }
        }
        // Retornamos la Respuesta
        echo json_encode(['resultado' => $resultado]);
    }

    public static function eliminar()
    {
        $resultado = null;
        // Busca la cita por su id
        $cita = Cita::find($_POST['citaId']);
        // Elimina la cita en caso de ser encontrada
        if ($cita) $resultado = $cita->eliminar();

        echo json_encode(['resultado' => $resultado]);
    }
}
