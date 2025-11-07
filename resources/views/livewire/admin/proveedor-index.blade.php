<!DOCTYPE html>
<html lang="es" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Proveedor</title>
    {{-- Asume que Vite está configurado para Tailwind --}}
    @vite(['resources/css/app.css', 'resources/js/app.js']) 
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    {{-- Fuente para iconos --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />
</head>
<body class="bg-gray-950 text-gray-100 min-h-screen p-4 sm:p-8">

    <div class="w-full max-w-5xl mx-auto">
        
        {{-- Alerta de Éxito usando SweetAlert --}}
        @if (session('success'))
            <script>
                Swal.fire({
                    icon: "success",
                    title: "¡Éxito!",
                    text: "{{ session('success') }}",
                    background: '#1f2937', // bg-gray-800
                    color: '#f4f4f5',
                    iconColor: '#10b981', // emerald-500
                    confirmButtonColor: '#3b82f6',
                    customClass: { popup: 'rounded-xl shadow-2xl' },
                    timer: 3500,
                    timerProgressBar: true
                });
            </script>
        @endif

        {{-- Alerta de Errores de Validación usando SweetAlert --}}
        @if ($errors->any())
            <script>
                Swal.fire({
                    icon: 'error',
                    title: 'Errores en el formulario',
                    html: '<ul class="text-left list-disc list-inside space-y-1 text-sm">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>',
                    background: '#1f2937',
                    color: '#f4f4f5',
                    iconColor: '#ef4444',
                    confirmButtonColor: '#3b82f6',
                    customClass: { popup: 'rounded-xl shadow-2xl' }
                });
            </script>
        @endif

        {{-- Contenedor Principal del Formulario --}}
        <div class="w-full bg-gray-800 rounded-2xl shadow-xl overflow-hidden p-8 border border-gray-700/50">
            <h1 class="text-3xl font-extrabold text-white mb-8 border-b border-blue-600/30 pb-3 flex items-center gap-3">
                <i class="fas fa-truck-moving text-blue-500"></i>
                Registro de Nuevo Proveedor
            </h1>

            <form action="{{ route('admin.proveedor.store') }}" method="POST" class="space-y-6">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    {{-- CAMPO RUC (ÚNICO) --}}
                    <div>
                        <label for="ruc" class="block text-sm font-semibold text-gray-300 mb-2">
                            RUC <span class="text-red-500">*</span>
                        </label>
                        <input 
                            type="text" 
                            id="ruc" 
                            name="ruc"
                            value="{{ old('ruc') }}"
                            maxlength="11"
                            class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 text-white placeholder-gray-500 shadow-md"
                            placeholder="Ej: 10456789123" 
                            required
                        >
                        @error('ruc')
                            <p class="mt-1 text-xs text-red-400 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- CAMPO RAZÓN SOCIAL --}}
                    <div>
                        <label for="razon_social" class="block text-sm font-semibold text-gray-300 mb-2">
                            Razón Social
                        </label>
                        <input 
                            type="text" 
                            id="razon_social" 
                            name="razon_social"
                            value="{{ old('razon_social') }}"
                            class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 text-white placeholder-gray-500 shadow-md"
                            placeholder="Ej: Suministros Médicos S.A.C." 
                        >
                        @error('razon_social')
                            <p class="mt-1 text-xs text-red-400 font-medium">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- SECCIÓN DE CONTACTO --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-4 border-t border-gray-700/50">
                    
                    {{-- CAMPO TELÉFONO --}}
                    <div>
                        <label for="telefono" class="block text-sm font-semibold text-gray-300 mb-2">
                            Teléfono
                        </label>
                        <input 
                            type="tel" 
                            id="telefono" 
                            name="telefono"
                            value="{{ old('telefono') }}"
                            class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 text-white placeholder-gray-500 shadow-md"
                            placeholder="Ej: +51 987 654 321" 
                        >
                        @error('telefono')
                            <p class="mt-1 text-xs text-red-400 font-medium">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    {{-- CAMPO EMAIL --}}
                    <div>
                        <label for="email" class="block text-sm font-semibold text-gray-300 mb-2">
                            Email
                        </label>
                        <input 
                            type="email" 
                            id="email" 
                            name="email"
                            value="{{ old('email') }}"
                            class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 text-white placeholder-gray-500 shadow-md"
                            placeholder="Ej: contacto@suministrosmedicos.com" 
                        >
                        @error('email')
                            <p class="mt-1 text-xs text-red-400 font-medium">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- CAMPO DIRECCIÓN (TEXTAREA) --}}
                <div class="pt-4">
                    <label for="direccion" class="block text-sm font-semibold text-gray-300 mb-2">
                        Dirección
                    </label>
                    <textarea 
                        id="direccion" 
                        name="direccion" 
                        rows="3"
                        class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 text-white placeholder-gray-500 shadow-md resize-none"
                        placeholder="Dirección completa del proveedor (calle, número, distrito, etc.)"
                    >{{ old('direccion') }}</textarea>
                    @error('direccion')
                        <p class="mt-1 text-xs text-red-400 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <div class="border-t border-gray-700/50 pt-6">
                    {{-- Nota de campos obligatorios --}}
                    <div class="text-sm text-gray-400 mb-6">
                        Campos marcados con <span class="text-red-500 font-bold">*</span> son obligatorios.
                    </div>

                    {{-- Botones de acción --}}
                    <div class="flex justify-end items-center gap-4">
                        <a href="{{ route('admin.proveedor.index') }}" 
                           class="px-6 py-3 bg-gray-600 text-gray-200 font-medium rounded-xl hover:bg-gray-700 transition-all duration-200 shadow-lg hover:shadow-xl">
                            <i class="fas fa-times-circle mr-2"></i>
                            Cancelar
                        </a>
                        <button type="submit"
                            class="px-8 py-3 bg-blue-600 text-white font-bold rounded-xl hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 focus:ring-offset-gray-900 transition-all duration-200 shadow-blue-500/50 shadow-xl hover:shadow-blue-500/70">
                            <i class="fas fa-save mr-2"></i>
                            Guardar Proveedor
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

</body>
</html>