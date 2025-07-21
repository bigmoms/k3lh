<?php

namespace App\Http\Services;

use App\DataTable\RoleDataTable;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\role_menu_route;


class RoleService {
    private $RoleDataTable;

    public function __construct(RoleDataTable $RoleDataTable) {
        $this->RoleDataTable = $RoleDataTable;
    }

    public function getAllRole() {
        $getAllRole = Role::get();
        return $getAllRole;
    }

    public function getRoleById($id) {
        $getRole = Role::findOrFail($id);
        return $getRole;
    }

    public function getRoleByUser($id) {
        $role = Role::whereRelation('users', 'id', '=', $id)
                        ->get('name');
        return $role;
    }

    public function storeRole($request) {
        try {
            DB::beginTransaction();
            $createRole = Role::firstOrCreate(['name' => $request->name ]);

            // $createRole = Role::create([ 'name' => $request->name]);
            DB::commit();
            return $createRole;
        } catch (Exception $e) {
            DB::rollback();
            return $e;
        }
    }

    public function updateRole($request, $role) {
        try {
            $menus = $request->listmenu;
            // dd($menus);
            DB::beginTransaction();
            $deleted = DB::table('role_menu_route')->where('role_id', '=', $request->role_id)->delete();
            foreach ($menus as $m) {
                // dd($m);
                $role_menu_route = role_menu_route::create([
                    'role_id' => $request->role_id,
                    'menu_id' => $m,
                    'routename' => '3',
                ]);
            }

            $updateRole = $role->update([
                'name' => $request->name,
            ]);

            DB::commit();
            return $updateRole;
        } catch (Throwable $th) {
            DB::rollback();
            return false;
        }
    }

    public function checkRoleDelete($role) {
        $checkRoleUser = Role::find($role->id)->permission;
        if(is_null($checkRoleUser)) {
            return true;
        }
        return false;
    }

    public function syncRoleToUser($user, $request) {
        try {
            $role = $request->role;
            // dd($role);
            $dt = $user->AssignRole($request->role);
            // dd($dt);
            return true;
        } catch (\Throwable $th) {
            // dd($th);
            return false;
        }
    }
}
