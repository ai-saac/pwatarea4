<div class="fixed inset-0 flex items-center justify-center z-50 hidden">
    <div class="bg-black opacity-80 fixed inset-0" id="modalOverlayAT"></div> <!-- Fondo oscurecido -->
    <div class="bg-white pt-8 pr-8 pl-8 rounded-lg shadow-md z-10 relative" style="width: 50%;">
        <button class="absolute top-2 right-2 text-gray-500 hover:text-gray-700" id="closeModalButtonAT">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
        <h2 class="text-xl font-semibold mb-8 text-blue-500">Agregar Tarea</h2>
        <form action="../sql/add-tasks.php" method="POST" enctype="multipart/form-data" class="grid grid-flow-row grid-cols-3 gap-4">
            <!-- Columna 1 -->
            <div class="col-span-1 w-48">
                <label class="block mb-2 text-gray-700">Usuario:</label>
                <select name="user_id" class="border w-full border-blue-500 rounded-xl p-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" required onchange="updateCategoriaPadreID(this)">
                    <!-- Aquí se cargarán las categorías principales dinámicamente -->
                    <?php
                    // Conectarse a la base de datos usando PDO
                    try {
                        $pdo = new PDO("mysql:host=localhost;dbname=pwa", "root", "");
                        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    } catch (PDOException $e) {
                        die("Error al conectar a la base de datos: " . $e->getMessage());
                    }
                    // Obtener categorías principales desde la base de datos y cargar las opciones
                    $queryUsuarios = "SELECT id, name FROM users WHERE role = 'User'";
                    $stmtUsuarios = $pdo->query($queryUsuarios);
                    while ($row = $stmtUsuarios->fetch(PDO::FETCH_ASSOC)) {
                        echo '<option value="' . $row['id'] . '">' . $row['name'] . '</option>';
                    }
                    ?>
                </select>
            </div>

            <div class="col-span-2">
                <label class="block mb-2 text-gray-700">Descripción:</label>
                <textarea name="description" class="border w-full h-28 border-blue-500 rounded-xl p-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" style="resize: none;" required></textarea>
            </div>


            <!-- Botón de envío -->
            <div class="col-span-3 flex justify-end items-end mb-4">
                <div>
                    <button type="submit" class="bg-blue-500 text-white rounded-xl px-4 py-2 hover:bg-blue-700">Agregar</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    const modalAT = document.querySelector('.fixed.inset-0');
    const modalOverlayAT = document.getElementById('modalOverlayAT');
    const closeModalButtonAT = document.getElementById('closeModalButtonAT');
    const openModalAT = document.getElementById('openModalAT');

    openModalAT.addEventListener('click', () => {
        modalAT.classList.remove('hidden');
    });

    const closeModal = () => {
        modalAT.classList.add('hidden');
    };

    closeModalButtonAT.addEventListener('click', closeModal);
    modalOverlayAT.addEventListener('click', closeModal);

    window.addEventListener('keydown', (event) => {
        if (event.key === 'Escape' || event.key === 'Esc') {
            closeModal();
        }
    });
</script>
<script>
    // Función para actualizar el campo oculto con el ID de la categoría principal seleccionada
    function updateCategoriaPadreID(selectElement) {
        var categoriaPadreID = selectElement.value;
        document.getElementById("categoriaPadreID").value = categoriaPadreID;
    }
</script>