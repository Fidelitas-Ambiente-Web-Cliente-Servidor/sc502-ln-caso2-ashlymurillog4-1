<?php

require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../models/Solicitud.php';
require_once __DIR__ . '/../models/Taller.php';

class AdminController
{
    private $solicitudModel;
    private $tallerModel;

    public function __construct()
    {
        $database = new Database();
        $db = $database->connect();
        $this->solicitudModel = new Solicitud($db);
        $this->tallerModel = new Taller($db);
    }

    public function solicitudes()
    {
        if (!isset($_SESSION['id']) || $_SESSION['rol'] !== 'admin') {
            header('Location: index.php?page=login');
            return;
        }
        require __DIR__ . '/../views/admin/solicitudes.php';
    }

    // Aprobar solicitud
    public function aprobar()
    {
        if (!isset($_SESSION['id']) || $_SESSION['rol'] !== 'admin') {
            echo json_encode([
                'success' => false,
                'message' => 'Error al aprobar'
            ]);
            return;
        }

        $id = $_POST['id_solicitud'];

        $solicitud = $this->solicitudModel->getById($id);

        if (!$solicitud) {
            echo json_encode([
                'success' => false,
                'message' => 'Error al aprobar'
            ]);
            return;
        }

        $taller = $this->tallerModel->getById($solicitud['taller_id']);

        if ($taller['cupo_disponible'] <= 0) {
            echo json_encode([
                'success' => false,
                'message' => 'Ya no hay cupo'
            ]);
            return;
        }

        $this->tallerModel->descontarCupo($taller['id']);
        $this->solicitudModel->aprobar($id);

        echo json_encode([
            'success' => true,
            'message' => 'Solicitud aprobada correctamente'
        ]);
    }
    public function rechazar()
    {
        if (!isset($_SESSION['id']) || $_SESSION['rol'] !== 'admin') {
            echo json_encode(['success' => false, 'error' => 'No autorizado']);
            return;
        }

        $solicitudId = $_POST['id_solicitud'] ?? 0;

        if ($this->solicitudModel->rechazar($solicitudId)) {
            echo json_encode(['success' => true, 'message' => 'Solicitud rechazada correctamente']);
        } else {
            echo json_encode(['success' => false, 'error' => 'Error al rechazar']);
        }
    }
    public function getSolicitudesJson()
    {
        $data = $this->solicitudModel->getPendientes();
        echo json_encode(["data" => $data->fetch_all(MYSQLI_ASSOC)]);
    }
}