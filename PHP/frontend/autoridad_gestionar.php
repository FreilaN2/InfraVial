<?php
session_start();
if (!isset($_SESSION['usuario_id']) || $_SESSION['rol'] !== 'autoridad') {
    header('Location: /VialBarinas/login.php');
    exit();
}

include_once('../../Templates/header_4.php');
require_once '../../database.php';

$query = "SELECT r.id, r.titulo, r.descripcion, r.tipo_incidente, r.fecha_reporte,
                 r.latitud, r.longitud, r.imagen, r.estado, r.estatus,
                 u.nombre AS ciudadano, u.cedula AS cedula
          FROM reportes r
          JOIN usuarios u ON r.usuario_id = u.id
          WHERE r.estado = 'pendiente'
          ORDER BY r.fecha_reporte DESC";
$result = $conn->query($query);
?>

<div class="container mt-5">
    <h2 class="mb-4">Reportes</h2>
    <div class="table-responsive">
        <table class="table table-bordered align-middle">
            <thead class="table-dark">
                <tr>
                    <th>Título</th>
                    <th>Descripción</th>
                    <th>Tipo</th>
                    <th>Fecha</th>
                    <th>Ciudadano</th>
                    <th>Cédula</th>
                    <th>Imagen</th>
                    <th>Ubicación</th>
                    <th>Estado</th>
                    <th>Estatus</th>
                    <th>Prioridad</th>
                </tr>
            </thead>
            <tbody>
            <?php while ($row = $result->fetch_assoc()) : ?>
                <tr>
                    <td><?= htmlspecialchars($row['titulo']) ?></td>
                    <td><?= htmlspecialchars($row['descripcion']) ?></td>
                    <td><?= $row['tipo_incidente'] ?></td>
                    <td><?= $row['fecha_reporte'] ?></td>
                    <td><?= $row['ciudadano'] ?></td>
                    <td><?= $row['cedula'] ?></td>
                    <td>
                        <a href="#" class="btn btn-link p-0" data-bs-toggle="modal" data-bs-target="#imgModal<?= $row['id'] ?>">Ver</a>
                        <div class="modal fade" id="imgModal<?= $row['id'] ?>" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Imagen del Reporte</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                                    </div>
                                    <div class="modal-body text-center">
                                        <img src="<?= $row['imagen'] ?>" class="img-fluid">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <a href="#" class="btn btn-link p-0" data-bs-toggle="modal" data-bs-target="#mapModal<?= $row['id'] ?>">Mapa</a>
                        <div class="modal fade" id="mapModal<?= $row['id'] ?>" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Ubicación del Reporte</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                                    </div>
                                    <div class="modal-body">
                                        <iframe src="https://www.google.com/maps?q=<?= $row['latitud'] ?>,<?= $row['longitud'] ?>&output=embed" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                    <td><?= $row['estado'] ?></td>
                    <td><?= $row['estatus'] ?></td>
                    <td>
                        <form action="/VialBarinas/PHP/backend/actualizar_estado.php" method="POST" class="d-flex flex-column gap-1">
                            <input type="hidden" name="reporte_id" value="<?= $row['id'] ?>">
                            <select name="prioridad" class="form-select form-select-sm" required>
                                <option value="alta">Alta</option>
                                <option value="media">Media</option>
                                <option value="baja">Baja</option>
                            </select>
                            <div class="d-flex gap-1">
                                <button name="accion" value="aprobar" class="btn btn-success btn-sm">Aprobar</button>
                                <button name="accion" value="rechazar" class="btn btn-danger btn-sm">Rechazar</button>
                            </div>
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<?php include_once('../../Templates/footer.php'); ?>
