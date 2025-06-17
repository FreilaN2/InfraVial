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
    <h2 class="mb-4"><i class="bi bi-clipboard-check"></i> Reportes</h2>
    <div class="table-responsive">
        <table class="table table-striped table-hover table-bordered align-middle rounded-3 overflow-hidden">
            <thead class="table-dark text-center">
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
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody class="text-center">
            <?php while ($row = $result->fetch_assoc()) : ?>
                <tr>
                    <td><?= htmlspecialchars($row['titulo']) ?></td>
                    <td class="text-start"><?= htmlspecialchars($row['descripcion']) ?></td>
                    <td><?= $row['tipo_incidente'] ?></td>
                    <td><?= date('d/m/Y H:i', strtotime($row['fecha_reporte'])) ?></td>
                    <td><?= $row['ciudadano'] ?></td>
                    <td><?= $row['cedula'] ?></td>
                    <td>
                        <a href="#" data-bs-toggle="modal" data-bs-target="#imgModal<?= $row['id'] ?>">
                            <img src="<?= $row['imagen'] ?>" alt="Reporte" style="width: 60px; height: 45px; object-fit: cover; border-radius: 5px;" class="shadow-sm">
                        </a>

                        <!-- Modal de imagen -->
                        <div class="modal fade" id="imgModal<?= $row['id'] ?>" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Imagen del Reporte</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body text-center">
                                        <img src="<?= $row['imagen'] ?>" class="img-fluid rounded shadow">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>

                    <td>
                        <a href="#" class="btn btn-outline-info btn-sm" title="Ver en mapa" data-bs-toggle="modal" data-bs-target="#mapModal<?= $row['id'] ?>">
                            <i class="bi bi-geo-alt-fill"></i>
                        </a>
                        <!-- Modal de mapa -->
                        <div class="modal fade" id="mapModal<?= $row['id'] ?>" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Ubicación del Reporte</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <iframe src="https://www.google.com/maps?q=<?= $row['latitud'] ?>,<?= $row['longitud'] ?>&output=embed"
                                                width="100%" height="450" style="border:0;" allowfullscreen loading="lazy"></iframe>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <span class="badge bg-secondary"><?= ucfirst($row['estado']) ?></span>
                    </td>
                    <td>
                        <span class="badge bg-<?= $row['estatus'] === 'activo' ? 'success' : 'dark' ?>">
                            <?= ucfirst($row['estatus']) ?>
                        </span>
                    </td>
                    <td>
                        <form action="/VialBarinas/PHP/backend/actualizar_estado.php" method="POST" class="d-grid gap-2">
                            <input type="hidden" name="reporte_id" value="<?= $row['id'] ?>">
                            <select name="prioridad" class="form-select form-select-sm rounded-pill" required>
                                <option value="" selected disabled>-- Seleccionar --</option>
                                <option value="alta">Alta</option>
                                <option value="media">Media</option>
                                <option value="baja">Baja</option>
                            </select>
                            <div class="d-flex gap-1 justify-content-center">
                                <button name="accion" value="aprobar" class="btn btn-success btn-sm rounded-pill">Aprobar</button>
                                <button name="accion" value="rechazar" class="btn btn-danger btn-sm rounded-pill">Rechazar</button>
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
