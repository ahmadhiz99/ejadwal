<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;
use App\Helpers\ControllerHelper;


class RoomsController extends Controller
{
     function configController($params = null){
        $config = [
            'model'=>'Room'
        ];

        if($params != null){
            $config = array_merge($config, $params);
        }
        
        return $config;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $req = [
            'id'=>null
        ];

        $config = Self::configController($req);

        $data = ControllerHelper::ch_datas($config);
        return redirect('/room')->with("SessTableData", $data);// Variable has to come from here

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $req = [
            'id'=>null,
            // 'model_selection'=>[
            //     'user'=>[
            //         'id','name','email'
            //     ],
            //     'room'=>[
            //         '*'
            //     ]
            // ]
        ];

        $config = Self::configController($req);

        $data_selection = ControllerHelper::ch_datas_selection($config);
        
        return to_route('room.formroom')->with("SessSelectionData",$data_selection);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'room_name' => 'required'
        ]);

        $req = [
            'id'=>null,
            'request'=> $request->all()
        ];

        if($validator->fails()){
            return response()->json([
                'message' => 'Store Role Failed!',
                'status' => 'false',
                'data'=> [$validator->messages()]
            ],400);
        }else{
            $config = Self::configController($req);
            ControllerHelper::ch_insert($config);
            return to_route('rooms.index');
        }
      
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $req = [
            'id'=>$id,
            'model_selection'=>[
                'Programstudies'=>[
                    'id','prodi_name','description'
                ],
                'Role'=>[
                    'id','role_name','level'
                ]
            ]
        ];

        $config = Self::configController($req);
        $data_selection = ControllerHelper::ch_datas_selection($config);
        $config = Self::configController($req);        
        $data = ControllerHelper::ch_datas($config);

        return redirect('/room/show')->with(["SessTableData"=>$data,"SessSelectionData"=>$data_selection]);

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
        //
        $role = Role::find($request);

        try {
          
            if(count($role)>0){
                // return Inertia::render('Profile/Edit');
                return response()->json([
                    'message' => 'Data Exist!',
                    'status' => 'true',
                    'data'=> [$role]
                ],200);
            }else{
                return response()->json([
                    'message' => 'Data Empty!',
                    'status' => 'true',
                    'data'=> [$role]
                ],200);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Failed',
                'status' => 'false',
                'data'=> $th->getMessage()
            ],500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'room_name' => 'required'
        ]);

        $req = [
            'id'=>$id,
            'request'=> $request->all()
        ];

        if($validator->fails()){
            return response()->json([
                'message' => 'Store Role Failed!',
                'status' => 'false',
                'data'=> [$validator->messages()]
            ],400);
        }else{
            $config = Self::configController($req);
            ControllerHelper::ch_insert($config);
            return to_route('rooms.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $req = [
            'id'=>$id
        ];

        $config = Self::configController($req);
         ControllerHelper::ch_destroy($config);
        return to_route('rooms.index');

    }
}
