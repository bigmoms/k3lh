<?php

namespace App\Http\Services;

use Throwable;
use App\Models\User;
use App\Models\UserDivisi;
use App\Models\UserLokasiLingkungan;
use App\DataTable\UserDataTable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class userService {
    private $UserDataTable;

    public function __construct(UserDataTable $UserDataTable) {
        $this->UserDataTable = $UserDataTable;
    }

    public function getUsers() {
        $allUser = User::with('roles')->get();
        return $allUser;
    }

    public function getUserById($id) {
        $getUser = User::findOrFail($id);
        return $getUser;
    }

    public function storeUser($request) {
        try {
            DB::beginTransaction();
            $chk = $request->vdrcheck;
            if ($chk=='1'){
                $createUser = User::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'is_vendor' => $chk,
                    'vendor_id' => $request->vendor_id,
                    'password' => bcrypt('initial.1'),
                ]);
            }else{
                $createUser = User::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => bcrypt('initial.1'),
                ]);
            }
            DB::commit();
            return $createUser;
        } catch (Throwable $th) {
            DB::rollback();
            return false;
        }
    }

    public function updateUser($request, $user) {
        try {
            DB::beginTransaction();
            $updateUser = $user->update([
                'name' => $request->name,
                'email' => $request->email
            ]);
            DB::commit();
            return $updateUser;
        } catch (Throwable $th) {
            DB::rollback();
            return false;
        }
    }

    public function checkUserDelete($user) {
        $authUser = Auth::user();
        if($authUser != $user) {
            return true;
        }
        return false;
    }
}
