{{-- resources/views/admin/productos/create.blade.php --}}
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Nuevo Producto</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</head>
<body class="bg-zinc-950 text-white min-h-screen">

<div class="w-full py-8 px-4 sm:px-6 lg:px-8">
    {{-- Alerta de Éxito --}}
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
                customClass: { popup: 'rounded-lg shadow-lg' },
                timer: 3000,
                timerProgressBar: true
            });
        </script>
    @endif

    {{-- Alerta de Errores de Validación --}}
    @if ($errors->any())
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Errores en el formulario',
                html: '<ul class="text-left list-disc list-inside space-y-1">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>',
                background: '#18181b',
                color: '#f4f4f5',
                iconColor: '#ef4444',
                confirmButtonColor: '#3b82f6',
                customClass: { popup: 'rounded-lg shadow-lg' }
            });
        </script>
    @endif

    <div class="max-w-4xl mx-auto">
        <div class="bg-zinc-900 rounded-xl shadow-2xl overflow-hidden p-8 border border-zinc-800">
            <h1 class="text-3xl font-bold text-white mb-8 text-center">
                Registrar Nuevo Producto
            </h1>

            <form action="{{ route('admin.producto.store') }}" method="POST" class="space-y-7">
                @csrf

                <!-- Nombre -->
                <div>
                    <label for="nombre" class="block text-sm font-medium text-zinc-300 mb-2">
                        Nombre del producto <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="nombre" id="nombre" value="{{ old('nombre') }}"
                        class="w-full px-4 py-3 bg-zinc-800 border border-zinc-700 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition text-white placeholder-zinc-500"
                        placeholder="Ej: Ibuprofeno 600mg, Alcohol en gel 500ml" required>
                    @error('nombre')
                        <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Descripción -->
                <div>
                    <label for="descripcion" class="block text-sm font-medium text-zinc-300 mb-2">
                        Descripción
                    </label>
                    <textarea name="descripcion" id="descripcion" rows="4"
                        class="w-full px-4 py-3 bg-zinc-800 border border-zinc-700 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition text-white placeholder-zinc-500"
                        placeholder="Información adicional, indicaciones, presentaciones...">{{ old('descripcion') }}</textarea>
                    @error('descripcion')
                        <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Código de barras -->
                    <div>
                        <label for="codigo_barras" class="block text-sm font-medium text-zinc-300 mb-2">
                            Código de barras (EAN-13) <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="codigo_barras" id="codigo_barras" value="{{ old('codigo_barras') }}"
                            class="w-full px-4 py-3 bg-zinc-800 border border-zinc-700 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition text-white"
                            placeholder="1234567890123" maxlength="13" required>
                        @error('codigo_barras')
                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Categoría -->
                    <div>
                        <label for="categoria_id" class="block text-sm font-medium text-zinc-300 mb-2">
                            Categoría <span class="text-red-500">*</span>
                        </label>
                        <select name="categoria_id" id="categoria_id" required
                            class="w-full px-4 py-3 bg-zinc-800 border border-zinc-700 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition text-white">
                            <option value="">-- Seleccionar categoría --</option>
                            @foreach(\App\Models\Categoria::all() as $categoria)
                                <option value="{{ $categoria->id }}" {{ old('categoria_id') == $categoria->id ? 'selected' : '' }}>
                                    {{ $categoria->nombre }}
                                </option>
                            @endforeach
                        </select>
                        @error('categoria_id')
                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Proveedor -->
                    <div>
                        <label for="proveedor_id" class="block text-sm font-medium text-zinc-300 mb-2">
                            Proveedor <span class="text-red-500">*</span>
                        </label>
                        <select name="proveedor_id" id="proveedor_id" required
                            class="w-full px-4 py-3 bg-zinc-800 border border-zinc-700 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition text-white">
                            <option value="">-- Seleccionar proveedor --</option>
                            @foreach(\App\Models\Proveedor::all() as $proveedor)
                                <option value="{{ $proveedor->id }}" {{ old('proveedor_id') == $proveedor->id ? 'selected' : '' }}>
                                    {{ $proveedor->nombre }}
                                </option>
                            @endforeach
                        </select>
                        @error('proveedor_id')
                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Estado -->
                    <div>
                        <label for="estado" class="block text-sm font-medium text-zinc-300 mb-2">
                            Estado
                        </label>
                        <select name="estado" id="estado"
                            class="w-full px-4 py-3 bg-zinc-800 border border-zinc-700 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition text-white">
                            <option value="1" {{ old('estado', 1) == 1 ? 'selected' : '' }}>Activo</option>
                            <option value="0" {{ old('estado') == '0' ? 'selected' : '' }}>Inactivo</option>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Precio Compra -->
                    <div>
                        <label for="precio_compra" class="block text-sm font-medium text-zinc-300 mb-2">
                            Precio de compra <span class="text-red-500">*</span>
                        </label>
                        <input type="number" step="0.01" min="0" name="precio_compra" id="precio_compra" value="{{ old('precio_compra') }}"
                            class="w-full px-4 py-3 bg-zinc-800 border border-zinc-700 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition text-white"
                            placeholder="0.00" required>
                        @error('precio_compra')
                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Precio Venta -->
                    <div>
                        <label for="precio_venta" class="block text-sm font-medium text-zinc-300 mb-2">
                            Precio de venta <span class="text-red-500">*</span>
                        </label>
                        <input type="number" step="0.01" min="0" name="precio_venta" id="precio_venta" value="{{ old('precio_venta') }}"
                            class="w-full px-4 py-3 bg-zinc-800 border border-zinc-700 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition text-white"
                            placeholder="0.00" required>
                        @error('precio_venta')
                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Stock Mínimo -->
                    <div>
                        <label for="stock_minimo" class="block text-sm font-medium text-zinc-300 mb-2">
                            Stock mínimo <span class="text-red-500">*</span>
                        </label>
                        <input type="number" min="0" name="stock_minimo" id="stock_minimo" value="{{ old('stock_minimo', 10) }}"
                            class="w-full px-4 py-3 bg-zinc-800 border border-zinc-700 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition text-white"
                            required>
                        @error('stock_minimo')
                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Stock Actual -->
                <div>
                    <label for="stock" class="block text-sm font-medium text-zinc-300 mb-2">
                        Stock actual <span class="text-red-500">*</span>
                    </label>
                    <input type="number" min="0" name="stock" id="stock" value="{{ old('stock', 0) }}"
                        class="w-full px-4 py-3 bg-zinc-800 border border-zinc-700 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition text-white"
                        required>
                    @error('stock')
                        <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div class="pt-6 flex justify-between items-center">
                    <a href="{{ route('admin.producto.index') }}"
                        class="px-6 py-3 bg-zinc-700 text-zinc-300 font-medium rounded-lg hover:bg-zinc-600 transition">
                        Cancelar
                    </a>

                    <button type="submit"
                        class="px-8 py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-500 focus:ring-offset-2 focus:ring-offset-zinc-900 transition shadow-lg">
                        Guardar Producto
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>