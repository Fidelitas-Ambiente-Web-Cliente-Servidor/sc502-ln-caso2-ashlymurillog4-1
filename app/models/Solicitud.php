<?php
class Solicitud
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function existeSolicitud($tallerId, $usuarioId)
    {
        $stmt = $this->conn->prepare(
            "SELECT * FROM solicitudes 
             WHERE taller_id = ? AND usuario_id = ? 
             AND estado IN ('pendiente','aprobada')"
        );
        $stmt->bind_param("ii", $tallerId, $usuarioId);
        $stmt->execute();
        return $stmt->get_result()->num_rows > 0;
    }

    public function crear($tallerId, $usuarioId)
    {
        $stmt = $this->conn->prepare(
            "INSERT INTO solicitudes (taller_id, usuario_id) VALUES (?, ?)"
        );
        $stmt->bind_param("ii", $tallerId, $usuarioId);
        return $stmt->execute();
    }

    public function getPendientes()
    {
        $sql = "SELECT s.*, t.nombre as taller, u.username as usuario 
                FROM solicitudes s
                JOIN talleres t ON s.taller_id = t.id
                JOIN usuarios u ON s.usuario_id = u.id
                WHERE s.estado = 'pendiente'";
        return $this->conn->query($sql);
    }

    public function aprobar($id)
    {
        $stmt = $this->conn->prepare(
            "UPDATE solicitudes SET estado = 'aprobada' WHERE id = ?"
        );
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    public function rechazar($id)
    {
        $stmt = $this->conn->prepare(
            "UPDATE solicitudes SET estado = 'rechazada' WHERE id = ?"
        );
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    public function getById($id)
    {
        $stmt = $this->conn->prepare(
            "SELECT * FROM solicitudes WHERE id = ?"
        );
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }
}