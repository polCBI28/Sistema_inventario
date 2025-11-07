<?php

namespace Database\Factories;
use App\Models\Proveedor;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProveedorFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Proveedor::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
             // 1. RUC (Registro Único de Contribuyentes)
            // Genera una cadena de 11 dígitos, asegurando que sea única.
            // Usamos 'numerify' para garantizar que sean solo números.
            'ruc' => $this->faker->unique()->numerify('##########'), // 10 dígitos (puedes ajustar el patrón)
            
            // 2. Razón Social
            // Genera nombres de empresas o nombres de personas más creíbles.
            'razon_social' => $this->faker->company(), 

            // 3. Dirección
            // Usa una dirección real.
            // 90% tiene dirección.
            'direccion' => $this->faker->optional(0.9)->address(), 
            
            // 4. Teléfono
            // Genera un número de teléfono con formato realista.
            'telefono' => $this->faker->optional(0.9)->phoneNumber(), 
            
            // 5. Email
            // Genera un email real (usando el nombre de la compañía para el dominio).
            'email' => $this->faker->optional(0.9)->unique()->companyEmail(), 

            // 6. Estado
            // Asigna un booleano (true o false) al azar.
            'estado' => $this->faker->boolean(90), // 90% de probabilidad de que esté activo (true)
            
        ];
    }
}