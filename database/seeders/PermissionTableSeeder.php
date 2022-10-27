<?php
namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {


        Permission::truncate();

        Permission::firstOrCreate(['name' => 'Todas las opciones menu']);
        Permission::firstOrCreate(['name' => 'Panel administrativo']);
        Permission::firstOrCreate(['name' => 'Panel administrativo']);

        Permission::firstOrCreate(['name' => 'Ver configuración']);
        Permission::firstOrCreate(['name' => 'Crear configuración']);
        Permission::firstOrCreate(['name' => 'Editar configuración']);
        Permission::firstOrCreate(['name' => 'Eliminar configuración']);

        Permission::firstOrCreate(['name' => 'Ver opcion menu']);
        Permission::firstOrCreate(['name' => 'Crear opcion menu']);
        Permission::firstOrCreate(['name' => 'Editar opcion menu']);
        Permission::firstOrCreate(['name' => 'Eliminar opcion menu']);

        Permission::firstOrCreate(['name' => 'Ver permisos']);
        Permission::firstOrCreate(['name' => 'Crear permisos']);
        Permission::firstOrCreate(['name' => 'Editar permisos']);
        Permission::firstOrCreate(['name' => 'Eliminar permisos']);

        Permission::firstOrCreate(['name' => 'Ver roles']);
        Permission::firstOrCreate(['name' => 'Crear roles']);
        Permission::firstOrCreate(['name' => 'Editar roles']);
        Permission::firstOrCreate(['name' => 'Eliminar roles']);

        Permission::firstOrCreate(['name' => 'Ver usuarios']);
        Permission::firstOrCreate(['name' => 'Crear usuarios']);
        Permission::firstOrCreate(['name' => 'Editar usuarios']);
        Permission::firstOrCreate(['name' => 'Eliminar usuarios']);
        Permission::firstOrCreate(['name' => 'Editar menu usuarios']);

        Permission::firstOrCreate(['name' => 'Ver Compras']);
        Permission::firstOrCreate(['name' => 'Crear Compras']);
        Permission::firstOrCreate(['name' => 'Editar Compras']);
        Permission::firstOrCreate(['name' => 'Eliminar Compras']);

        Permission::firstOrCreate(['name' => 'Ver Compra Tipos']);
        Permission::firstOrCreate(['name' => 'Crear Compra Tipos']);
        Permission::firstOrCreate(['name' => 'Editar Compra Tipos']);
        Permission::firstOrCreate(['name' => 'Eliminar Compra Tipos']);

        Permission::firstOrCreate(['name' => 'Ver Categorías']);
        Permission::firstOrCreate(['name' => 'Crear Categorías']);
        Permission::firstOrCreate(['name' => 'Editar Categorías']);
        Permission::firstOrCreate(['name' => 'Eliminar Categorías']);

        Permission::firstOrCreate(['name' => 'Ver Artículos']);
        Permission::firstOrCreate(['name' => 'Crear Artículos']);
        Permission::firstOrCreate(['name' => 'Editar Artículos']);
        Permission::firstOrCreate(['name' => 'Eliminar Artículos']);

        Permission::firstOrCreate(['name' => 'Ver Magnitudes']);
        Permission::firstOrCreate(['name' => 'Crear Magnitudes']);
        Permission::firstOrCreate(['name' => 'Editar Magnitudes']);
        Permission::firstOrCreate(['name' => 'Eliminar Magnitudes']);

        Permission::firstOrCreate(['name' => 'Ver Marcas']);
        Permission::firstOrCreate(['name' => 'Crear Marcas']);
        Permission::firstOrCreate(['name' => 'Editar Marcas']);
        Permission::firstOrCreate(['name' => 'Eliminar Marcas']);

        Permission::firstOrCreate(['name' => 'Ver Proveedores']);
        Permission::firstOrCreate(['name' => 'Crear Proveedores']);
        Permission::firstOrCreate(['name' => 'Editar Proveedores']);
        Permission::firstOrCreate(['name' => 'Eliminar Proveedores']);

        Permission::firstOrCreate(['name' => 'Ver unidades medida']);
        Permission::firstOrCreate(['name' => 'Crear unidades medida']);
        Permission::firstOrCreate(['name' => 'Editar unidades medida']);
        Permission::firstOrCreate(['name' => 'Eliminar unidades medida']);

        Permission::firstOrCreate(['name' => 'Ver Compra Estados']);
        Permission::firstOrCreate(['name' => 'Editar Compra Estados']);
        Permission::firstOrCreate(['name' => 'Eliminar Compra Estados']);

        Permission::firstOrCreate(['name' => 'Ver Compra Tipos']);
        Permission::firstOrCreate(['name' => 'Editar Compra Tipos']);
        Permission::firstOrCreate(['name' => 'Eliminar Compra Tipos']);

        Permission::firstOrCreate(['name' => 'Anular ingreso de compra']);
        Permission::firstOrCreate(['name' => 'Cancelar solicitud de compra']);

        Permission::firstOrCreate(['name' => 'Ver Categorías']);
        Permission::firstOrCreate(['name' => 'Editar Categorías']);
        Permission::firstOrCreate(['name' => 'Eliminar Categorías']);

        Permission::firstOrCreate(['name' => 'Crear Artículos']);
        Permission::firstOrCreate(['name' => 'Editar Artículos']);
        Permission::firstOrCreate(['name' => 'Eliminar Artículos']);


        Permission::firstOrCreate(['name' => 'Ver Marcas']);
        Permission::firstOrCreate(['name' => 'Editar Marcas']);
        Permission::firstOrCreate(['name' => 'Eliminar Marcas']);

        Permission::firstOrCreate(['name' => 'Ver Proveedores']);
        Permission::firstOrCreate(['name' => 'Editar Proveedores']);
        Permission::firstOrCreate(['name' => 'Eliminar Proveedores']);

        Permission::firstOrCreate(['name' => 'Ver Tipo Pagos']);
        Permission::firstOrCreate(['name' => 'Editar Tipo Pagos']);
        Permission::firstOrCreate(['name' => 'Eliminar Tipo Pagos']);

        Permission::firstOrCreate(['name' => 'Ver unidades medida']);
        Permission::firstOrCreate(['name' => 'Editar unidades medida']);
        Permission::firstOrCreate(['name' => 'Eliminar unidades medida']);

        Permission::firstOrCreate(['name' => 'Ver Venta Estados']);
        Permission::firstOrCreate(['name' => 'Editar Venta Estados']);
        Permission::firstOrCreate(['name' => 'Eliminar Venta Estados']);

        Permission::firstOrCreate(['name' => 'Anular venta']);




    }
}
