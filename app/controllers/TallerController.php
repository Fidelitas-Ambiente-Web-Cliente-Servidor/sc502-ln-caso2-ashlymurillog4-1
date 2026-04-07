<?php

require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../models/Taller.php';
require_once __DIR__ . '/../models/Solicitud.php';

class TallerController
{
    private $tallerModel;
    private $solicitudModel;

    public function __construct()
    {
        $database = new Database();
        $db = $database->connect();
        $this->tallerModel = new Taller($db);
        $this->solicitudModel = new Solicitud($db);
    }

    public function index()
    {
        if (!isset($_SESSION['id'])) {
            header('Location: index.php?page=login');
            return;
        }
        require __DIR__ . '/../views/taller/listado.php';
    }

    public function getTalleresJson()
    {
        if (!isset($_SESSION['id'])) {
            echo json_encode([]);
            return;
        }

        $talleres = $this->tallerModel->getAllDisponibles();
        header('Content-Type: application/json');
        echo json_encode($talleres);
    }

    public function solicitar()
    {
        if (!isset($_SESSION['id'])) {
            echo json_encode(['success' => false, 'message' => 'Debe iniciar sesión']);
            return;
        }

        $tallerId = $_POST['taller_id'];
        $usuarioId = $_SESSION['id'];

        // validar si està disponible
        $taller = $this->tallerModel->getById($tallerId);

        if ($taller['cupo_disponible'] <= 0) {
            echo json_encode([
                'success' => false,
                'message' => 'No hay cupo disponible'
            ]);
            return;
        }

        // validar si está duplicado
        if ($this->solicitudModel->existeSolicitud($tallerId, $usuarioId)) {
            echo json_encode(['success' => false, 'message' => 'Ya solicitó este taller']);
            return;
        }
        $taller = $this->tallerModel->getById($tallerId);

        if ($taller['cupo_disponible'] <= 0) {
            echo json_encode([
                'success' => false,
                'message' => 'No hay cupo disponible'
            ]);
            return;
        }
        if ($this->solicitudModel->crear($tallerId, $usuarioId)) {
            echo json_encode(['success' => true, 'message' => 'Solicitud enviada']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error al solicitar']);
        }
    }
}