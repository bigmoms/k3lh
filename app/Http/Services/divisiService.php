<?php

namespace App\Http\Services;

use App\Models\Division;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\DataTable\DivisiDataTable;
use Illuminate\Database\Eloquent\Builder;



class divisiService
{
    /**
     * Create a new class instance.
     */
    private $DivisiDataTable;

    public function __construct(DivisiDataTable $DivisiDataTable) {
        $this->DivisiDataTable = $DivisiDataTable;
    }

    public function getAllDivisi() {
        $getAllMenu = Division::get();
        return $getAllMenu;
    }

    public function getDivisiById($id) {
        $divisi = Division::findOrFail($id);
        return $divisi;
    }

    public function getDivisiByName($slug) {
        $divisi = Division::where('nama_divisi', $slug)->first();
        return $menu;
    }

    public function search($request)
    {
        $query = Division::query();

        if ($request->has('q')) {
            $query->where('nama_divisi', 'like', '%' . $request->q . '%');
        }

        $divisi = $query->limit(10)->get(['id', 'nama_divisi']);

        return $divisi;

        // return response()->json([
        //     'data' => $divisi
        // ]);
    }

    public function storeDivisi($request) {
        try {
            DB::beginTransaction();
            //dd($request->data);
            foreach ($request->data as $item) {
                // dd($k);
                // $createDivisi = Division::upsert([
                //     'id' => $item->id,
                //     'nama_divisi' => $item->name,
                //     'code' => $item->code,
                // ]);
                $createDivisi = Division::upsert([
                    'id' => $item->id,
                    'nama_divisi' => $item->name,
                    'code' => $item->code,
                ],
                uniqueBy: ['id'],
                update: ['nama_divisi','code']);
            }

            DB::commit();
            return $createDivisi;
        } catch (Throwable $th) {
            DB::rollback();
            return false;
        }
    }




}
