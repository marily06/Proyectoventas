<?php

namespace Database\Seeders;

use App\Models\Option;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('users')->truncate();

        //Usuario admin
        User::factory(1)->create([
            "username" => "dev",
            "name" => "Developer",
            "password" => bcrypt("admin")
        ])->each(function (User $user){
            $user->syncRoles([Role::DEVELOPER]);
            $user->options()->sync(Option::pluck('id')->toArray());
            $user->shortcuts()->sync([3,4,5,6]);
        });

        User::factory(1)->create([
            "username" => "Super",
            "name" => "Super Admin",
            "password" => bcrypt("admin")
        ])->each(function (User $user){
            $user->syncRoles(Role::SUPERADMIN);
            $user->options()->sync([
//                Option::PANEL_DE_CONTROL,
                Option::PEDIDOS,
                Option::NUEVA_VENTA,
                Option::COMPRAS,
                Option::NUEVA_COMPRA,
                Option::BUSCAR_COMPRAS,
                Option::PROVEEDORES,
                Option::COMPRA_ESTADOS,
                Option::TIPOS,
                Option::VENTAS,
                Option::BUSCAR_VENTA,
                Option::VENTA_ESTADOS,
                Option::CLIENTES,
                Option::TIPOS_DE_PAGO,
                Option::ARTICULOS,
                Option::BUSCAR_ARTICULO,
                Option::NUEVO_ARTICULO,
                Option::IMPORTAR_EXCEL,
                Option::CATEGORIAS,
                Option::UNIDADES_DE_MEDIDA,
                Option::MARCAS,
                Option::ADMIN,
                Option::USUARIOS,
                Option::ROLES,
                Option::PERMISOS,
                Option::CONFIGURACIONES_USER,
                Option::ECOMMERCE,
            ]);
            $user->shortcuts()->sync([
                Option::PANEL_DE_CONTROL,
                Option::PEDIDOS,
                Option::NUEVA_COMPRA,
                Option::BUSCAR_COMPRAS,
                Option::PROVEEDORES,
                Option::BUSCAR_VENTA,
                Option::CLIENTES,
                Option::BUSCAR_ARTICULO,
                Option::NUEVO_ARTICULO,
                Option::USUARIOS,
                Option::CONFIGURACIONES_USER,
                Option::ECOMMERCE,
            ]);

        });

        User::factory(1)->create([
            "username" => "Admin",
            "name" => "Administrador",
            "password" => bcrypt("admin")
        ])->each(function (User $user){
            $user->syncRoles(Role::ADMIN);
            $user->options()->sync([
//                Option::PANEL_DE_CONTROL,
                Option::PEDIDOS,
                Option::NUEVA_VENTA,
                Option::COMPRAS,
                Option::NUEVA_COMPRA,
                Option::BUSCAR_COMPRAS,
                Option::PROVEEDORES,
                Option::COMPRA_ESTADOS,
                Option::TIPOS,
                Option::VENTAS,
                Option::BUSCAR_VENTA,
                Option::VENTA_ESTADOS,
                Option::CLIENTES,
                Option::TIPOS_DE_PAGO,
                Option::ARTICULOS,
                Option::BUSCAR_ARTICULO,
                Option::NUEVO_ARTICULO,
                Option::IMPORTAR_EXCEL,
                Option::CATEGORIAS,
                Option::UNIDADES_DE_MEDIDA,
                Option::MARCAS,
                Option::ADMIN,
                Option::USUARIOS,
                Option::ROLES,
                Option::PERMISOS,
                Option::CONFIGURACIONES_USER,
                Option::ECOMMERCE,
            ]);
            $user->shortcuts()->sync([
                Option::PANEL_DE_CONTROL,
                Option::PEDIDOS,
                Option::NUEVA_COMPRA,
                Option::BUSCAR_COMPRAS,
                Option::PROVEEDORES,
                Option::BUSCAR_VENTA,
                Option::CLIENTES,
                Option::BUSCAR_ARTICULO,
                Option::NUEVO_ARTICULO,
                Option::USUARIOS,
                Option::CONFIGURACIONES_USER,
                Option::ECOMMERCE,
            ]);

        });


        User::factory(2)->create([
            "password" => bcrypt("123")
        ])->each(function (User $user){
            $user->syncRoles(Role::CLIENTE);

        });
    }
}
