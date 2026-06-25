<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@modamx.com'],
            [
                'name' => 'Administrador Moda MX',
                'password' => Hash::make('overcloud123'),
            ]
        );

        $categories = [
            'Mujer' => 'Ropa y prendas para mujer con estilo mexicano contemporáneo.',
            'Hombre' => 'Moda masculina, casual y formal para toda ocasión.',
            'Accesorios' => 'Complementa tu look con bolsos, cinturones y más.',
            'Calzado' => 'Zapatos, tenis y botas para todos los estilos.',
            'Niños' => 'Ropa cómoda y divertida para los más pequeños.',
        ];

        $catModels = [];
        foreach ($categories as $name => $description) {
            $catModels[$name] = Category::updateOrCreate(
                ['slug' => Str::slug($name)],
                ['name' => $name, 'description' => $description]
            );
        }

        $sizesClothing = ['CH', 'M', 'G', 'XG'];
        $sizesShoes = ['24', '25', '26', '27', '28'];
        $sizesKids = ['2', '4', '6', '8', '10'];

        $products = [
            ['Vestido Floral Primavera', 'Mujer', 749.00, 'Vestido ligero con estampado floral, ideal para días cálidos.', $sizesClothing, true],
            ['Blusa Bordada Oaxaca', 'Mujer', 529.00, 'Blusa de manta con bordado artesanal inspirado en Oaxaca.', $sizesClothing, true],
            ['Jeans Skinny Tiro Alto', 'Mujer', 899.00, 'Jeans de mezclilla elástica con corte skinny y tiro alto.', $sizesClothing, false],
            ['Camisa Lino Casual', 'Hombre', 689.00, 'Camisa de lino transpirable, perfecta para clima cálido.', $sizesClothing, true],
            ['Playera Básica Premium', 'Hombre', 299.00, 'Playera de algodón peinado, suave y resistente.', $sizesClothing, false],
            ['Pantalón Chino Slim', 'Hombre', 759.00, 'Pantalón chino de corte slim, versátil y cómodo.', $sizesClothing, false],
            ['Bolsa de Piel Artesanal', 'Accesorios', 1290.00, 'Bolsa de piel genuina hecha a mano por artesanos mexicanos.', null, true],
            ['Cinturón de Cuero Trenzado', 'Accesorios', 389.00, 'Cinturón de cuero trenzado con hebilla metálica.', null, false],
            ['Tenis Urbanos Blancos', 'Calzado', 1099.00, 'Tenis casuales de piel sintética para uso diario.', $sizesShoes, true],
            ['Botines de Gamuza', 'Calzado', 1450.00, 'Botines de gamuza con suela antiderrapante.', $sizesShoes, false],
            ['Conjunto Deportivo Niño', 'Niños', 459.00, 'Conjunto deportivo cómodo para niños activos.', $sizesKids, true],
            ['Vestido Fiesta Niña', 'Niños', 549.00, 'Vestido elegante para ocasiones especiales.', $sizesKids, false],
        ];

        foreach ($products as [$name, $cat, $price, $desc, $sizes, $featured]) {
            $slug = Str::slug($name);
            Product::updateOrCreate(
                ['slug' => $slug],
                [
                    'category_id' => $catModels[$cat]->id,
                    'name' => $name,
                    'description' => $desc,
                    'price' => $price,
                    'stock' => rand(8, 40),
                    'image' => 'https://picsum.photos/seed/' . $slug . '/600/750',
                    'sizes' => $sizes,
                    'is_featured' => $featured,
                    'is_active' => true,
                ]
            );
        }
    }
}
