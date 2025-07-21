<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\DataTable\DivisiDataTable;
use App\Http\Services\DivisiService;
use GuzzleHttp\Client;


class DivisionsController extends Controller
{
    private $divisiService;
    private $DivisiDataTable;

    public function __construct(
        DivisiDataTable $DivisiDataTable,
        divisiService $divisiService
        ) {
            $this->divisiService = $divisiService;
            $this->DivisiDataTable = $DivisiDataTable;
        }

    public function index(Request $request)
    {
        // $routeName = RouteHelper::getName();
        // if (!Gate::allows($routeName)) {
        //     //dd('You are not authorized to view '.$routeName.' page');
        //     return redirect()->route('dashboard')->with([
        //         'alert-icon' => 'error',
        //         'alert-type' => 'Not Authorized!',
        //         'alert-message' => 'You are not authorized to view '.$routeName.' page',
        //     ]);
        // }

        // $getAllPost = $this->postService->getAllPost();
        $getAllRole = $this->divisiService->getAllDivisi();
        if($request->ajax()) {
            return $this->DivisiDataTable->divisiTable($getAllRole);
        }
        $menus  = $request->get('dtmenus');

        return view('admin.divisi.index',[
            'menus' => $menus,

        ]);
    }

    public function getData(Request $request)
    {
        $client = new Client();
        $options = [
            'verify' => false,
            'Accept' => 'application/json',
        ];
        // $uri = 'http://115.85.65.125:8084/microservices/public/api/v1/departments';


        // Membuat permintaan HTTP GET
        // $response = $client->request('GET', 'http://115.85.65.125:8084/microservices/public/api/v1/departments');
        try {
            // $response = $client->get($uri, $options)->getBody()->getContents();
            // $response_json = json_decode($response);
            // dd($response);
            $response = $client->request('GET', 'http://115.85.65.125:8084/microservices/public/api/v1/divisions');
            $response_json = json_decode($response->getBody());
            //dd($response_json);
            $createDivisi = $this->divisiService->storeDivisi($response_json);


            // // Memproses respons
            // if ($response->getStatusCode() == 200) {
            //     $response_json = json_decode($response);
            //     // $data = json_decode($response->getBody());

            //     // dd($data);
            //     $createDivisi = $this->divisiService->storeDivisi($data);
            // }
            $menus  = $request->get('dtmenus');

            return view('admin.divisi.index',[
                'menus' => $menus,

            ]);
        } catch (Throwable $th) {
            echo "Terjadi kesalahan saat memproses permintaan: " . $th;
            return false;
        }
    }

    public function searchDivisi(Request $request)
    {

        $divisi = $this->divisiService->search($request);

        return response()->json([
            'data' => $divisi
        ]);
    }
}
