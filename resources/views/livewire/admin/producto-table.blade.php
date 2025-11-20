{{-- resources/views/admin/productos/index.blade.php --}}
<div class="w-full py-8 px-4 sm:px-6 lg:px-8" x-data="productoTable()">
    {{-- Notificaciones con SweetAlert2 --}}
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
                timer: 3000,
                timerProgressBar: true
            });
        </script>
    @endif

    @if (session('error'))
        <script>
            Swal.fire({
                icon: "error",
                title: "Error",
                text: "{{ session('error') }}",
                background: '#18181b',
                color: '#f4f4f5',
                iconColor: '#ef4444',
                confirmButtonColor: '#3b82f6'
            });
        </script>
    @endif

    <!-- Header + Botón Crear -->
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold text-white">Lista de Productos</h1>
        <a href="{{ route('admin.producto.create') }}"
           class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg shadow-lg transition flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Nuevo Producto
        </a>
    </div>

    <!-- Tabla -->
    <div class="bg-zinc-900 rounded-xl shadow-2xl overflow-hidden border border-zinc-800">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-zinc-800 text-zinc-300 uppercase text-xs">
                    <tr>
                        <th class="px-6 py-4">#</th>
                        <th class="px-6 py-4">Nombre</th>
                        <th class="px-6 py-4">Código</th>
                        <th class="px-6 py-4">Categoría</th>
                        <th class="px-6 py-4">Proveedor</th>
                        <th class="px-6 py-4 text-center">Stock</th>
                        <th class="px-6 py-4 text-right">P. Compra</th>
                        <th class="px-6 py-4 text-right">P. Venta</th>
                        <th class="px-6 py-4 text-center">Estado</th>
                        <th class="px-6 py-4 text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-800">
                    @forelse ($productos as $producto)
                        <tr class="hover:bg-zinc-800/50 transition">
                            <td class="px-6 py-4 text-zinc-400">{{ $loop->iteration }}</td>
                            <td class="px-6 py-4 font-medium text-white">
                                {{ $producto->nombre }}
                                @if($producto->stock <= $producto->stock_minimo)
                                    <span class="ml-2 inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-orange-900 text-orange-300">
                                        Bajo stock
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-zinc-400">{{ $producto->codigo_barras }}</td>
                            <td class="px-6 py-4 text-zinc-300">
                                {{ $producto->categoria?->nombre ?? 'Sin categoría' }}
                            </td>
                            <td class="px-6 py-4 text-zinc-300">
                                {{ $producto->proveedor?->nombre ?? 'Sin proveedor' }}
                            </td>
                            <td class="px-6 py-4 text-center font-semibold 
                                @if($producto->stock == 0) text-red-500
                                @elseif($producto->stock <= $producto->stock_minimo) text-orange-500
                                @else text-green-500 @endif">
                                {{ $producto->stock }}
                            </td>
                            <td class="px-6 py-4 text-right text-zinc-400">
                                S/ {{ number_format($producto->precio_compra, 2) }}
                            </td>
                            <td class="px-6 py-4 text-right font-medium text-white">
                                S/ {{ number_format($producto->precio_venta ?? 0, 2) }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium
                                    {{ $producto->estado ? 'bg-green-900 text-green-300' : 'bg-red-900 text-red-300' }}">
                                    {{ $producto->estado ? 'Activo' : 'Inactivo' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center space-x-3">
                                <!-- Editar -->
                                <button @click="abrirModal(
                                    {{ $producto->id }},
                                    '{{ addslashes($producto->nombre) }}',
                                    '{{ $producto->codigo_barras }}',
                                    {{ $producto->categoria_id ?? 'null' }},
                                    {{ $producto->proveedor_id ?? 'null' }},
                                    {{ $producto->precio_compra }},
                                    {{ $producto->precio_venta ?? 0 }},
                                    {{ $producto->stock }},
                                    {{ $producto->stock_minimo }},
                                    {{ $producto->estado ? 'true' : 'false' }}
                                )"
                                    class="text-blue-500 hover:text-blue-400 transition">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </button>

                                <!-- Eliminar -->
                                <button onclick="confirmarEliminacion({{ $producto->id }})"
                                        class="text-red-500 hover:text-red-400 transition">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>

                                <!-- Form oculto para DELETE -->
                                <form id="delete-form-{{ $producto->id }}"
                                      action="{{ route('admin.producto.destroy', $producto->id) }}"
                                      method="POST" class="hidden">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="px-6 py-12 text-center text-zinc-500">
                                No hay productos registrados aún.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Paginación -->
        <div class="px-6 py-4 border-t border-zinc-800">
            {{ $productos->links() }}
        </div>
    </div>

    {{-- MODAL DE EDICIÓN RÁPIDA (Alpine.js) --}}
    <div x-show="modalAbierto" x-cloak class="fixed inset-0 z-50 overflow-y-auto" @keydown.escape.window="cerrarModal">
        <div class="flex items-center justify-center min-h-screen px-4">
            <div class="fixed inset-0 bg-black/80 backdrop-blur-sm" @click="cerrarModal"></div>

            <div class="relative bg-zinc-900 rounded-xl shadow-2xl w-full max-w-4xl border border-zinc-700">
                <form :action="'/admin/producto/' + productoId" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="px-8 py-6 border-b border-zinc-700">
                        <div class="flex justify-between items-center">
                            <h3 class="text-2xl font-bold text-white">Editar Producto</h3>
                            <button type="button" @click="cerrarModal" class="text-zinc-400 hover:text-white">
                                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <div class="p-8 space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-zinc-300 mb-2">Nombre *</label>
                                <input type="text" name="nombre" x-model="form.nombre" required
                                       class="w-full px-4 py-3 bg-zinc-800 border border-zinc-700 rounded-lg text-white focus:ring-2 focus:ring-blue-500">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-zinc-300 mb-2">Código de barras *</label>
                                <input type="text" name="codigo_barras" x-model="form.codigo_barras" required maxlength="13"
                                       class="w-full px-4 py-3 bg-zinc-800 border border-zinc-700 rounded-lg text-white focus:ring-2 focus:ring-blue-500">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-zinc-300 mb-2">Categoría *</label>
                                <select name="categoria_id" x-model="form.categoria_id" required
                                        class="w-full px-4 py-3 bg-zinc-800 border border-zinc-700 rounded-lg text-white focus:ring-2 focus:ring-blue-500">
                                    <option value="">Seleccionar</option>
                                    @foreach(\App\Models\Categoria::all() as $cat)
                                        <option value="{{ $cat->id }}">{{ $cat->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-zinc-300 mb-2">Proveedor *</label>
                                <select name="proveedor_id" x-model="form.proveedor_id" required
                                        class="w-full px-4 py-3 bg-zinc-800 border border-zinc-700 rounded-lg text-white focus:ring-2 focus:ring-blue-500">
                                    <option value="">Seleccionar</option>
                                    @foreach(\App\Models\Proveedor::all() as $prov)
                                        <option value="{{ $prov->id }}">{{ $prov->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-zinc-300 mb-2">P. Compra *</label>
                                <input type="number" step="0.01" name="precio_compra" x-model="form.precio_compra" required
                                       class="w-full px-4 py-3 bg-zinc-800 border border-zinc-700 rounded-lg text-white focus:ring-2 focus:ring-blue-500">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-zinc-300 mb-2">P. Venta *</label>
                                <input type="number" step="0.01" name="precio_venta" x-model="form.precio_venta" required
                                       class="w-full px-4 py-3 bg-zinc-800 border border-zinc-700 rounded-lg text-white focus:ring-2 focus:ring-blue-500">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-zinc-300 mb-2">Stock *</label>
                                <input type="number" name="stock" x-model="form.stock" required
                                       class="w-full px-4 py-3 bg-zinc-800 border border-zinc-700 rounded-lg text-white focus:ring-2 focus:ring-blue-500">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-zinc-300 mb-2">Stock Mínimo *</label>
                                <input type="number" name="stock_minimo" x-model="form.stock_minimo" required
                                       class="w-full px-4 py-3 bg-zinc-800 border border-zinc-700 rounded-lg text-white focus:ring-2 focus:ring-blue-500">
                            </div>
                        </div>

                        <div>
                            <label class="flex items-center gap-3">
                                <input type="checkbox" name="estado" x-model="form.estado" true-value="1" false-value="0"
                                       class="w-5 h-5 text-blue-600 bg-zinc-800 border-zinc-700 rounded focus:ring-blue-500">
                                <span class="text-sm font-medium text-zinc-300">Producto activo</span>
                            </label>
                        </div>
                    </div>

                    <div class="px-8 py-6 bg-zinc-800/50 border-t border-zinc-700 flex justify-end gap-4">
                        <button type="button" @click="cerrarModal"
                                class="px-6 py-3 bg-zinc-700 hover:bg-zinc-600 text-white rounded-lg transition">
                            Cancelar
                        </button>
                        <button type="submit"
                                class="px-8 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg shadow-lg transition">
                            Guardar Cambios
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function confirmarEliminacion(id) {
    Swal.fire({
        title: '¿Eliminar producto?',
        text: "Esta acción no se puede deshacer",
        icon: 'warning',
        background: '#18181b',
        color: '#f4f4f5',
        showCancelButton: true,
        confirmButtonColor: '#ef4444',
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('delete-form-' + id).submit();
        }
    });
}

function productoTable() {
    return {
        modalAbierto: false,
        productoId: null,
        form: {
            nombre: '', codigo_barras: '', categoria_id: '', proveedor_id: '',
            precio_compra: 0, precio_venta: 0, stock: 0, stock_minimo: 0, estado: true
        },

        abrirModal(id, nombre, codigo, catId, provId, pCompra, pVenta, stock, stockMin, estado) {
            this.productoId = id;
            this.form = {
                nombre, codigo_barras: codigo, categoria_id: catId, proveedor_id: provId,
                precio_compra: pCompra, precio_venta: pVenta, stock, stock_minimo: stockMin, estado
            };
            this.modalAbierto = true;
            document.body.classList.add('overflow-hidden');
        },

        cerrarModal() {
            this.modalAbierto = false;
            document.body.classList.remove('overflow-hidden');
        }
    }
}
</script>

{{-- Alpine.js --}}
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>