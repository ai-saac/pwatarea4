<head>
  <title>Tareas</title>
</head>

<?php
  include '../../../dashboard.php';
  include '../sql/get-tasks.php';
?>

<?php
$userRole = $_SESSION['user']['role'];
if ($userRole === 'User') {
  header("Location: tasks.php");
  exit;
}
?>

<style>
  .sortable-header {
    cursor: pointer;
    position: relative;
  }

  .sortable-header::after {
    content: "";
    display: inline-block;
    width: 0;
    height: 0;
    border-left: 5px solid transparent;
    border-right: 5px solid transparent;
    position: absolute;
    right: 5px;
    top: 50%;
    transition: transform 0.2s ease-in-out;
  }

  .sortable-header.sort-asc::after {
    border-bottom: 5px solid #333;
    /* Cambia el color según tu estilo */
    transform: translateY(-50%) rotate(180deg);
  }

  .sortable-header.sort-desc::after {
    border-top: 5px solid #333;
    /* Cambia el color según tu estilo */
    transform: translateY(-50%);
  }
</style>

<!-- Sección de Lista de Productos -->
<main class="ml-56 pt-4 px-8">
  <section class="p-6 rounded-lg">
    <div class="flex justify-between items-center mb-4">
      <div>
        <button id="openModalAT" class="shadow-lg hover:shadow-xl bg-gradient-to-r from-cyan-400 to-blue-400 text-white px-4 py-2 rounded-md hover:from-cyan-500 hover:to-blue-500">Agregar Tarea</button>
      </div>
      <section>
        <span class="text-slate-600 text-xl font-semibold mr-4">
          <?php echo $_SESSION['user']['name'] ?>
        </span>
        <a href="../../../../auth/loginout.php"><i class="fa-solid fa-right-from-bracket"></i>
          <span class="text-slate-700 font-bold hover:text-orange-600">Cerrar Sesion</span>
        </a>
      </section>
    </div>
    <table class="w-full text-sm border-gray-400 bg-white shadow-xl rounded-lg mb-4">
      <thead>
        <tr class="rounded-lg border-b light:border-white/40 text-slate-600">
          <th class="py-3 px-2">#</th>
          <th class="py-3 px-2">Nombre</th>
          <th class="py-3 px-2">Rol</th>
          <th class="py-3 px-2">Tarea</th>
          <th class="py-3 px-2">Estado</th>
          <th class="py-3 px-2">Completada</th>
          <th class="py-3 px-2">Acciones</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $contadorFilas = 1;
        foreach ($tareas as $tarea) { ?>
          <tr class="border-b light:border-white/40 text-slate-500">
            <td data-column="id" style="display: none;"><?= $tarea['id'] ?></td>
            <!-- <td class="px-4 py-2 w-5 text-slate-400"><?= $tarea['id'] ?></td> -->
            <td class="px-4 py-2 w-5 text-slate-400"><?= $contadorFilas ?></td>
            <?php
            $contadorFilas++;
            ?>
            <td class="px-2 py-2 w-40"><?= $tarea['nombre'] ?></td>
            <td class="px-2 py-2 w-28"><?= $tarea['rol'] ?></td>
            <td class="px-2 py-2 " data-column="description"><?= $tarea['description'] ?></td>
            <td class="px-2 py-2 w-48 text-center">
              <span data-task-id="<?= $tarea['id'] ?>">
                <?php
                if ($tarea['completed'] == 1) {
                  echo "Completado";
                } else if ($tarea['completed'] == 0) {
                  echo "En Curso";
                };
                ?>
              </span>
            </td>
            <td class="px-2 py-2 w-32 text-center">
              <?php
              if ($tarea['completed'] == 1) {
                echo '<input type="checkbox" class="completed-checkbox" checked="checked" disabled="disabled">';
              } else if ($tarea['completed'] == 0) {
                echo '<button class="complete-task rounded bg-indigo-500 text-white p-1" data-task-id="' . $tarea['id'] . '">
                  Completar Tarea
                </button>';
              }
              ?>
            </td>
            <td class="px-2 py-2 w-32 text-center">
              <?php
              if ($tarea['completed'] == 1) {
                // no muestra acciones ya que la tarea esta completadda
              } else if ($tarea['completed'] == 0) {
                echo '<button class="text-blue-600 hover:text-blue-800 edit-task" data-task-id="' . $tarea['id'] . '">
                  <i class="fa-solid fa-pen-to-square"></i>
                </button>';
                echo '<button class="text-green-600 hover:text-green-800 save-changes hidden" data-task-id="' . $tarea['id'] . '">
                  <i class="fa-solid fa-floppy-disk"></i> Guardar
                </button>';
                echo '<button class="text-red-600 hover:text-red-800 delete-task px-2" data-task-id="' . $tarea['id'] . '">
                  <i class="fa-solid fa-trash"></i>
                </button>';
                echo '<button class="text-gray-600 hover:text-gray-900 cancel-edit px-2 hidden">
                  <i class="fa-solid fa-ban"></i>
                </button>';
              }
              ?>
            </td>
          </tr>
        <?php } ?>
      </tbody>
    </table>
  </section>

  <?php
    require '../components/update-task.php';
    require '../components/add-task.php';
  ?>

  <!-- Completar Tarea -->
  <script>
    document.querySelectorAll('.complete-task').forEach(function(element) {
      element.addEventListener('click', function() {
        var taskId = this.getAttribute('data-task-id');
        Swal.fire({
          title: '¿Estás seguro?',
          text: 'No podrás deshacer esta acción.',
          icon: 'warning',
          showCancelButton: true,
          confirmButtonText: 'Sí, completar',
          cancelButtonText: 'Cancelar'
        }).then((result) => {
          if (result.isConfirmed) {
            // Realiza la solicitud AJAX para eliminar la tarea
            fetch('../sql/complete-tasks.php', {
                method: 'POST',
                headers: {
                  'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: 'task_id=' + encodeURIComponent(taskId)
              })
              .then(response => response.json())
              .then(data => {
                if (data.message) {
                  Swal.fire('Completado', 'La tarea ha sido completada con éxito.', 'success');
                  // Actualiza la vista para reflejar los cambios
                  location.reload(); // Esto recargará la página
                } else {
                  Swal.fire('Error', 'No se pudo completar la tarea.', 'error');
                }
              })
              .catch(error => {
                console.error('Error al completar la tarea:', error);
                Swal.fire('Error', 'No se pudo completar la tarea.', 'error');
              });
          }
        });
      });
    });
  </script>

  <!-- Eliminar Tarea -->
  <script>
    document.querySelectorAll('.delete-task').forEach(function(element) {
      element.addEventListener('click', function() {
        var taskId = this.getAttribute('data-task-id');
        Swal.fire({
          title: '¿Estás seguro?',
          text: 'No podrás deshacer esta acción.',
          icon: 'warning',
          showCancelButton: true,
          confirmButtonText: 'Sí, eliminar',
          cancelButtonText: 'Cancelar'
        }).then((result) => {
          if (result.isConfirmed) {
            // Realiza la solicitud AJAX para eliminar la tarea
            fetch('../sql/delete-tasks.php', {
                method: 'POST',
                headers: {
                  'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: 'task_id=' + encodeURIComponent(taskId)
              })
              .then(response => response.json())
              .then(data => {
                if (data.message) {
                  Swal.fire('Eliminado', 'La tarea ha sido eliminada con éxito.', 'success');
                  // Actualiza la vista para reflejar los cambios
                  location.reload(); // Esto recargará la página
                } else {
                  Swal.fire('Error', 'No se pudo eliminar la tarea.', 'error');
                }
              })
              .catch(error => {
                console.error('Error al eliminar la tarea:', error);
                Swal.fire('Error', 'No se pudo eliminar la tarea.', 'error');
              });
          }
        });
      });
    });
  </script>
</main>