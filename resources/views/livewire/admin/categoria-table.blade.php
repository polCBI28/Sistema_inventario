<div class="w-full py-8 px-4 sm:px-6 lg:px-8" x-data="categoriaTable()">
    <!-- Notificaciones -->
    @if (session('success'))
    <script>
        Swal.fire({
            icon: "success",
            title: "¡Éxito!",
            text: "{{ session('success') }}",
            background: '#18181b',
            color: '#f4f4f5',
            iconColor: '#22c55e',
            confirmButtonColor: '#3b82f6',
            customClass: {
                popup: 'rounded-lg shadow-lg'
            },
            timer: 3000,
            timerProgressBar: true
        });
    </script>
    @endif

    @if ($errors->any())
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Error',
            html: '<ul class="text-left list-disc list-inside space-y-1">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>',
            background: '#18181b',
            color: '#f4f4f5',
            iconColor: '#ef4444',
            confirmButtonColor: '#3b82f6',
            customClass: {
                popup: 'rounded-lg shadow-lg'
            }
        });
    </script>
    @endif

    <!-- Tabla de Categorías -->
    <div class="w-full bg-zinc-900 rounded-xl shadow-2xl overflow-hidden p-6 border border-zinc-800">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-white flex items-center gap-2">
                <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7h18M3 12h18M3 17h18"></path>
                </svg>
                Lista de Categorías
            </h1>
            <a href="{{ route('admin.categoria.create') }}"
                class="px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-all duration-200 shadow-lg hover:shadow-xl">
                + Nueva Categoría
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-zinc-800">
                    <tr>
                        <th class="px-4 py-3 text-left text-sm font-medium text-zinc-300 uppercase">#</th>
                        <th class="px-4 py-3 text-left text-sm font-medium text-zinc-300 uppercase">Nombre</th>
                        <th class="px-4 py-3 text-left text-sm font-medium text-zinc-300 uppercase">Descripción</th>
                        <th class="px-4 py-3 text-left text-sm font-medium text-zinc-300 uppercase">Estado</th>
                        <th class="px-4 py-3 text-right text-sm font-medium text-zinc-300 uppercase">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-800">
                    @forelse ($categorias as $categoria)
                    <tr class="hover:bg-zinc-800/50 transition-colors">
                        <td class="px-4 py-4 text-sm text-zinc-300">{{ $loop->iteration }}</td>
                        <td class="px-4 py-4 text-sm font-medium text-white">{{ $categoria->nombre }}</td>
                        <td class="px-4 py-4 text-sm text-zinc-300">
                            {{ $categoria->descripcion ? Str::limit($categoria->descripcion, 60) : '<em class="text-zinc-500">Sin descripción</em>' }}
                        </td>
                        <td class="px-4 py-4 text-sm">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    {{ $categoria->estado ? 'bg-green-900 text-green-300' : 'bg-red-900 text-red-300' }}">
                                {{ $categoria->estado ? 'Activa' : 'Inactiva' }}
                            </span>
                        </td>
                        <td class="px-4 py-4 text-sm text-right space-x-2">
                            <!-- Botón Editar -->
                            <button
                                @click="openModal({{ $categoria->id }}, '{{ addslashes($categoria->nombre) }}', '{{ addslashes($categoria->descripcion ?? '') }}', {{ $categoria->estado ? 1 : 0 }})"
                                class="text-blue-500 hover:text-blue-400 inline-flex transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                            </button>
                            <!-- Botón Eliminar -->
                            <button onclick="confirmDelete({{ $categoria->id }})"
                                class="text-red-500 hover:text-red-400 inline-flex transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>
                            <!-- Formulario Eliminar (oculto) -->
                            <form id="delete-form-{{ $categoria->id }}"
                                action="{{ route('admin.categoria.destroy', $categoria->id) }}"
                                method="POST" class="hidden">
                                @csrf
                                @method('DELETE')
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-4 py-8 text-center text-zinc-400">
                            No hay categorías registradas
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Paginación -->
        @if ($categorias->hasPages())
        <div class="mt-6">
            {{ $categorias->links() }}
        </div>
        @endif
    </div>

    <!-- MODAL DE EDICIÓN -->
    <div x-show="isOpen"
        x-cloak
        @keydown.escape.window="closeModal"
        x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 overflow-y-auto"
        style="z-index: 9999; display: none;">
        <div class="flex items-center justify-center min-h-screen px-4 py-6">
            <div class="fixed inset-0 bg-black/80 backdrop-blur-sm transition-opacity"
                @click="closeModal" style="z-index: 9998;"></div>

            <div x-transition:enter="ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-4 scale-95"
                x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                x-transition:leave="ease-in duration-200"
                x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                x-transition:leave-end="opacity-0 translate-y-4 scale-95"
                class="relative bg-zinc-900 rounded-xl shadow-2xl w-full max-w-2xl border border-zinc-700"
                style="z-index: 9999;" @click.stop>

                <form :action="'/admin/categoria/' + currentId" method="POST">
                    @csrf
                    @method('PUT')

                    <!-- Header -->
                    <div class="px-6 py-5 border-b border-zinc-700">
                        <div class="flex items-center justify-between">
                            <h3 class="text-xl font-semibold text-white">Editar Categoría</h3>
                            <button type="button" @click="closeModal"
                                class="text-zinc-400 hover:text-white transition-colors">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Body -->
                    <div class="px-6 py-6 space-y-5">
                        <!-- Nombre -->
                        <div>
                            <label class="block text-sm font-medium text-zinc-300 mb-2">
                                Nombre <span class="text-red-500">*</span>
                            </label>
                            <input type="text" x-model="currentNombre" name="nombre" required
                                class="w-full px-4 py-3 bg-zinc-800 border border-zinc-600 rounded-lg text-white placeholder-zinc-500 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                                placeholder="Ej: Medicamentos">
                        </div>

                        <!-- Descripción -->
                        <div>
                            <label class="block text-sm font-medium text-zinc-300 mb-2">Descripción</label>
                            <textarea x-model="currentDescripcion" name="descripcion" rows="4"
                                class="w-full px-4 py-3 bg-zinc-800 border border-zinc-600 rounded-lg text-white placeholder-zinc-500 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all resize-none"
                                placeholder="Opcional..."></textarea>
                        </div>

                        <!-- Estado -->
                        <div>
                            <label class="block text-sm font-medium text-zinc-300 mb-2">
                                Estado <span class="text-red-500">*</span>
                            </label>
                            <div class="flex gap-6">
                                <label class="flex items-center cursor-pointer">
                                    <input type="radio" x-model="currentEstado" value="1"
                                        class="w-4 h-4 text-green-500 bg-zinc-800 border-zinc-700 focus:ring-blue-500">
                                    <span class="ml-2 text-zinc-300">Activa</span>
                                </label>
                                <label class="flex items-center cursor-pointer">
                                    <input type="radio" x-model="currentEstado" value="0"
                                        class="w-4 h-4 text-red-500 bg-zinc-800 border-zinc-700 focus:ring-blue-500">
                                    <span class="ml-2 text-zinc-300">Inactiva</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Footer -->
                    <div class="px-6 py-4 bg-zinc-800/50 border-t border-zinc-700 flex justify-end gap-3">
                        <button type="button" @click="closeModal"
                            class="px-5 py-2.5 text-sm font-medium text-zinc-300 hover:text-white bg-zinc-700 hover:bg-zinc-600 rounded-lg transition-colors">
                            Cancelar
                        </button>
                        <button type="submit"
                            class="px-5 py-2.5 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-lg transition-colors shadow-lg shadow-blue-500/20">
                            Guardar Cambios
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function confirmDelete(id) {
        Swal.fire({
            title: '¿Eliminar categoría?',
            text: "¡No podrás revertir esto!",
            icon: 'warning',
            background: '#18181b',
            color: '#f4f4f5',
            iconColor: '#ef4444',
            confirmButtonColor: '#3b82f6',
            cancelButtonColor: '#6b7280',
            showCancelButton: true,
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar',
            customClass: {
                popup: 'rounded-lg shadow-lg'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + id).submit();
            }
        });
    }

    function categoriaTable() {
        return {
            isOpen: false,
            currentId: null,
            currentNombre: '',
            currentDescripcion: '',
            currentEstado: 1,

            openModal(id, nombre, descripcion, estado) {
                this.currentId = id;
                this.currentNombre = nombre;
                this.currentDescripcion = descripcion;
                this.currentEstado = estado;
                this.isOpen = true;
                document.body.classList.add('overflow-hidden');
            },

            closeModal() {
                this.isOpen = false;
                document.body.classList.remove('overflow-hidden');
            }
        }
    }
</script>