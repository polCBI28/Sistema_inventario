<!DOCTYPE html>
<html lang="es" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Proveedores</title>
    {{-- Asume que Vite/Tailwind está configurado --}}
    @vite(['resources/css/app.css', 'resources/js/app.js']) 
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    {{-- Font Awesome para iconos --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />
    {{-- Alpine.js si no está incluido en app.js --}}
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-gray-950 text-gray-100 min-h-screen">

<div class="w-full py-8 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto" x-data="proveedorTable()">
    
    {{-- ALERTA DE ÉXITO --}}
    @if (session('success'))
        <script>
            Swal.fire({
                icon: "success",
                title: "¡Éxito!",
                text: "{{ session('success') }}",
                background: '#1f2937', 
                color: '#f4f4f5',
                iconColor: '#10b981', 
                confirmButtonColor: '#3b82f6',
                customClass: { popup: 'rounded-xl shadow-2xl' },
                timer: 3500,
                timerProgressBar: true
            });
        </script>
    @endif

    {{-- ALERTA DE ERRORES (ej. si falla la edición en el modal) --}}
    @if ($errors->any())
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Error al procesar',
            html: '<ul class="text-left list-disc list-inside space-y-1 text-sm">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>',
            background: '#1f2937',
            color: '#f4f4f5',
            iconColor: '#ef4444',
            confirmButtonColor: '#3b82f6',
            customClass: { popup: 'rounded-xl shadow-2xl' }
        });
    </script>
    @endif

    <!-- Contenedor de la Tabla -->
    <div class="w-full bg-gray-900 rounded-2xl shadow-2xl overflow-hidden p-6 border border-gray-800">
        <div class="flex justify-between items-center mb-6 border-b border-gray-700/50 pb-4">
            <h1 class="text-3xl font-extrabold text-white flex items-center gap-3">
                <i class="fas fa-truck-moving text-blue-500"></i>
                Gestión de Proveedores
            </h1>
            
            <a href="{{ route('admin.proveedor.index') }}" 
               class="px-6 py-3 bg-blue-600 text-white font-medium rounded-xl hover:bg-blue-700 transition-all duration-200 shadow-lg shadow-blue-500/30">
                <i class="fas fa-plus mr-2"></i>
                Nuevo Proveedor
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-800">
                <thead class="bg-gray-800">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider w-12">#</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">RUC</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Razón Social</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider hidden sm:table-cell">Contacto (Tel/Email)</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Estado</th>
                        <th class="px-6 py-3 text-right text-xs font-semibold text-gray-400 uppercase tracking-wider w-32">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-800/70">
                    @forelse ($proveedores as $proveedor)
                    <tr class="hover:bg-gray-800 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-400">{{ $loop->iteration }}</td>
                        
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-mono text-blue-400">{{ $proveedor->ruc }}</td>
                        
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-white">{{ $proveedor->razon_social ?? 'N/A' }}</td>
                        
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300 hidden sm:table-cell">
                            <div class="space-y-1">
                                <p class="flex items-center gap-1 text-xs">
                                    <i class="fas fa-phone-alt text-gray-500 w-4"></i> {{ $proveedor->telefono ?? 'Sin Teléfono' }}
                                </p>
                                <p class="flex items-center gap-1 text-xs">
                                    <i class="fas fa-envelope text-gray-500 w-4"></i> {{ $proveedor->email ?? 'Sin Email' }}
                                </p>
                            </div>
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold
                                {{ $proveedor->estado ? 'bg-green-900/50 text-green-300 ring-1 ring-green-500' : 'bg-red-900/50 text-red-300 ring-1 ring-red-500' }}">
                                <i class="fas fa-circle mr-1 text-[8px]"></i>
                                {{ $proveedor->estado ? 'Activo' : 'Inactivo' }}
                            </span>
                        </td>
                        
                        <td class="px-6 py-4 whitespace-nowrap text-right space-x-3">
                            <!-- Botón Editar -->
                            <button
                                @click="openModal(
                                    {{ $proveedor->id }}, 
                                    '{{ addslashes($proveedor->ruc) }}', 
                                    '{{ addslashes($proveedor->razon_social ?? '') }}', 
                                    '{{ addslashes($proveedor->direccion ?? '') }}', 
                                    '{{ addslashes($proveedor->telefono ?? '') }}',
                                    '{{ addslashes($proveedor->email ?? '') }}',
                                    {{ $proveedor->estado ? 1 : 0 }}
                                )"
                                class="text-blue-500 hover:text-blue-400 transition-colors p-1.5 rounded-full hover:bg-gray-700" title="Editar">
                                <i class="fas fa-pencil-alt text-sm"></i>
                            </button>
                            <!-- Botón Eliminar -->
                            <button onclick="confirmDelete({{ $proveedor->id }})"
                                class="text-red-500 hover:text-red-400 transition-colors p-1.5 rounded-full hover:bg-gray-700" title="Eliminar">
                                <i class="fas fa-trash-alt text-sm"></i>
                            </button>
                            <!-- Formulario Eliminar (oculto) -->
                            <form id="delete-form-{{ $proveedor->id }}"
                                action="{{ route('admin.proveedor.destroy', $proveedor->id) }}"
                                method="POST" class="hidden">
                                @csrf
                                @method('DELETE')
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-gray-500 font-medium">
                            <i class="fas fa-box-open mr-2"></i> No hay proveedores registrados. ¡Comienza agregando uno!
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Paginación --}}
        @if (isset($proveedores) && $proveedores->hasPages())
        <div class="mt-6 border-t border-gray-800 pt-4">
            {{ $proveedores->links() }}
        </div>
        @endif
    </div>

    <!-- MODAL DE EDICIÓN (Alpine.js) -->
    <div x-show="isOpen"
        x-cloak
        @keydown.escape.window="closeModal"
        x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 overflow-y-auto z-[9999]"
        style="display: none;">
        <div class="flex items-center justify-center min-h-screen px-4 py-6">
            <div class="fixed inset-0 bg-black/80 backdrop-blur-sm transition-opacity"
                @click="closeModal" style="z-index: 9998;"></div>

            <div x-transition:enter="ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-4 scale-95"
                x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                x-transition:leave="ease-in duration-200"
                x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                x-transition:leave-end="opacity-0 translate-y-4 scale-95"
                class="relative bg-gray-900 rounded-xl shadow-2xl w-full max-w-3xl border border-gray-700"
                style="z-index: 9999;" @click.stop>

                <form :action="'/admin/proveedor/' + currentId" method="POST">
                    @csrf
                    @method('PUT')

                    <!-- Header -->
                    <div class="px-6 py-5 border-b border-gray-700 flex justify-between items-center">
                        <h3 class="text-xl font-semibold text-white flex items-center gap-2">
                            <i class="fas fa-edit text-blue-400"></i> Editar Proveedor
                        </h3>
                        <button type="button" @click="closeModal"
                            class="text-gray-400 hover:text-white transition-colors p-1">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>

                    <!-- Body -->
                    <div class="p-6 space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            
                            {{-- RUC --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-300 mb-2">RUC <span class="text-red-500">*</span></label>
                                <input type="text" x-model="currentRuc" name="ruc" required maxlength="11"
                                    class="w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-lg text-white placeholder-gray-500 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                            </div>

                            {{-- Razón Social --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-300 mb-2">Razón Social</label>
                                <input type="text" x-model="currentRazonSocial" name="razon_social"
                                    class="w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-lg text-white placeholder-gray-500 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            {{-- Teléfono --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-300 mb-2">Teléfono</label>
                                <input type="tel" x-model="currentTelefono" name="telefono"
                                    class="w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-lg text-white placeholder-gray-500 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                            </div>

                            {{-- Email --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-300 mb-2">Email</label>
                                <input type="email" x-model="currentEmail" name="email"
                                    class="w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-lg text-white placeholder-gray-500 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                            </div>
                        </div>

                        {{-- Dirección --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">Dirección</label>
                            <textarea x-model="currentDireccion" name="direccion" rows="3"
                                class="w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-lg text-white placeholder-gray-500 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all resize-none"
                                placeholder="Dirección completa del proveedor"></textarea>
                        </div>

                    <!-- Footer -->
                    <div class="px-6 py-4 bg-gray-800/50 border-t border-gray-700 flex justify-end gap-3 rounded-b-xl">
                        <button type="button" @click="closeModal"
                            class="px-5 py-2.5 text-sm font-medium text-gray-300 hover:text-white bg-gray-700 hover:bg-gray-600 rounded-lg transition-colors">
                            <i class="fas fa-times-circle mr-1"></i> Cancelar
                        </button>
                        <button type="submit"
                            class="px-5 py-2.5 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-lg transition-colors shadow-lg shadow-blue-500/30">
                            <i class="fas fa-save mr-1"></i> Guardar Cambios
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // SweetAlert2 function para confirmar eliminación
    function confirmDelete(id) {
        Swal.fire({
            title: '¿Eliminar Proveedor?',
            text: "¡El proveedor y sus datos asociados serán eliminados permanentemente!",
            icon: 'warning',
            background: '#1f2937', 
            color: '#f4f4f5',
            iconColor: '#ef4444',
            confirmButtonColor: '#3b82f6',
            cancelButtonColor: '#6b7280',
            showCancelButton: true,
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar',
            customClass: {
                popup: 'rounded-xl shadow-2xl'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                // Envía el formulario de eliminación oculto
                document.getElementById('delete-form-' + id).submit();
            }
        });
    }

    // Alpine.js component para manejar el estado del modal
    function proveedorTable() {
        return {
            isOpen: false,
            currentId: null,
            currentRuc: '',
            currentRazonSocial: '',
            currentDireccion: '',
            currentTelefono: '',
            currentEmail: '',
            currentEstado: 1,

            openModal(id, ruc, razon_social, direccion, telefono, email, estado) {
                this.currentId = id;
                this.currentRuc = ruc;
                this.currentRazonSocial = razon_social;
                this.currentDireccion = direccion;
                this.currentTelefono = telefono;
                this.currentEmail = email;
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

</body>
</html>