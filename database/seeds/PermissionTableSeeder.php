<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$permissions = [
    		'user-list',
    		'user-create',
    		'role-list',
    		'role-create',
    		'role-edit',
    		'role-delete',
    		'todo-list',
    		'todo-create',
    		'todo-edit',
    		'todo-delete',
    		'todo_all-list',
    	];

    	foreach ($permissions as $permission) {
    		Permission::create(['name' => $permission]);
    	}
    }
}
