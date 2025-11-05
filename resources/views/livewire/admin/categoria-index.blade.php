<!DOCTYPE html>
<html lang="es" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Categoría</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="bg-zinc-950 text-zinc-100 min-h-screen">

<div class="w-full py-8 px-4 sm:px-6 lg:px-8 max-w-4xl mx-auto">
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

    <div class="w-full bg-zinc-900 rounded-xl shadow-2xl overflow-hidden p-6 border border-zinc-800">
        <h1 class="text-2xl font-bold text-white mb-6 flex items-center gap-2">
            <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7h18M3 12h18M3 17h18"></path>
            </svg>
            Registrar Nueva Categoría
        </h1>

        <form action="{{ route('admin.categoria.store') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Campo Nombre -->
            <div>
                <label for="nombre" class="block text-sm font-medium text-zinc-300 mb-1">
                    Nombre de la categoría <span class="text-red-500">*</span>
                </label>
                <input 
                    type="text" 
                    id="nombre" 
                    name="nombre"
                    value="{{ old('nombre') }}"
                    class="w-full px-4 py-3 bg-zinc-800 border border-zinc-700 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 text-white placeholder-zinc-500"
                    placeholder="Ej: Medicamentos, Vitaminas, Equipos Médicos" 
                    required
                >
                @error('nombre')
                    <p class="mt-1 text-sm text-red-500 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <!-- Campo Descripción -->
            <div>
                <label for="descripcion" class="block text-sm font-medium text-zinc-300 mb-1">
                    Descripción
                </label>
                <textarea 
                    id="descripcion" 
                    name="descripcion" 
                    rows="3"
                    class="w-full px-4 py-3 bg-zinc-800 border border-zinc-700 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 text-white placeholder-zinc-500 resize-none"
                    placeholder="Describe el propósito o contenido de esta categoría (opcional)"
                >{{ old('descripcion') }}</textarea>
                @error('descripcion')
                    <p class="mt-1 text-sm text-red-500 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <!-- Campo Estado -->
            <div>
                <label class="block text-sm font-medium text-zinc-300 mb-1">
                    Estado <span class="text-red-500">*</span>
                </label>
                <div class="flex items-center gap-6">
                    <label class="flex items-center cursor-pointer">
                        <input 
                            type="radio" 
                            name="estado" 
                            value="1" 
                            {{ old('estado', '1') == '1' ? 'checked' : '' }}
                            class="w-4 h-4 text-green-500 bg-zinc-800 border-zinc-700 focus:ring-blue-500"
                        >
                        <span class="ml-2 text-zinc-300">Activa</span>
                    </label>
                    <label class="flex items-center cursor-pointer">
                        <input 
                            type="radio" 
                            name="estado" 
                            value="0" 
                            {{ old('estado') == '0' ? 'checked' : '' }}
                            class="w-4 h-4 text-red-500 bg-zinc-800 border-zinc-700 focus:ring-blue-500"
                        >
                        <span class="ml-2 text-zinc-300">Inactiva</span>
                    </label>
                </div>
                @error('estado')
                    <p class="mt-1 text-sm text-red-500 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <!-- Separador -->
            <div class="relative my-8">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-zinc-800"></div>
                </div>
                <div class="relative flex justify-center text-xs">
                    <span class="bg-zinc-900 px-2 text-zinc-500">Fin del formulario</span>
                </div>
            </div>

            <!-- Nota de campos obligatorios -->
            <div class="text-sm text-zinc-500 mb-6">
                Campos marcados con <span class="text-red-500 font-bold">*</span> son obligatorios
            </div>

            <!-- Botones de acción -->
            <div class="flex justify-between items-center">
                <a href="{{ route('admin.categoria.index') }}" 
                   class="px-5 py-3 bg-zinc-700 text-zinc-300 font-medium rounded-lg hover:bg-zinc-600 transition-all duration-200">
                    Cancelar
                </a>
                <button type="submit"
                    class="px-6 py-3 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 focus:ring-offset-zinc-900 transition-all duration-200 shadow-lg hover:shadow-xl">
                    Registrar Categoría
                </button>
            </div>
        </form>
    </div>
</div>

</body>
</html>