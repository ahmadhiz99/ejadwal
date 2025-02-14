<?php

namespace App\Http\Controllers;

use App\Models\SysMenu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;
use App\Helpers\ControllerHelper;


class SysMenuController extends Controller
{
     function configController($params = null){
        $config = [
            'model'=>'Sysmenu'
        ];

        if($params != null){
            $config = array_merge($config, $params);
        }
        
        return $config;
    }

    function purgeConfig(){
        $configTemp = Self::configController();
        $config = [];
        $config = $configTemp;
    }

    function get_validator(){
        return [
            'name' => 'required',
            'code' => 'required',
            'parent' => 'required',
            'route' => 'required',
            'is_active' => 'required'
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $req = [
            'id'=>null,
            'table_master'=>[
                'table_name' => 'sys_menu',
                'alias' => 'a',
                'select'=> 'a.*'
            ],
            'join'=>[
                    'tx_menu_roles'=>[
                            'join_type'=>'leftJoin',
                            'alias'=> 'b',
                            'on'=>'a.id = b.menu_id',
                            'select'=> 'b.description',
                    ],
            ],
            'where_condition' => [
                "equals" => [
                    ['a.parent','=','0'],
                    ['b.role_id','=',auth()->user()->role_id],
                    ['a.is_active','=','1'],
                ],
                // "in" => [
                //     "column" => "id",
                //     "value" => [1,2,3]
                // ],
                // "not_in" => [
                //     "column" => "id",
                //     "value" => [1,2]
                // ],
                "order_by"=>[
                    "column"=>"a.id",
                    "value"=>"asc"
                ],
                "paginate" => [
                    "column" => "null",
                    "value" => 10
                ],
            ]
        ];

        $config = Self::configController($req);

        // return ControllerHelper::ch_datas($config);
        $data = ControllerHelper::ch_datas($config)->getContent();
        // return($data);
        
        Self::purgeConfig();
        $req = [
            "where_condition" => [
                "equals" => [
                    ['parent','<>','0'],
                    ['is_active','=','1'],
                ],
                "paginate" => [
                    "column" => null,
                    "value" => 10
                ]
            ]
        ];

        $config = Self::configController($req);
        $subData = ControllerHelper::ch_datas($config)->getContent();
        $dataFromJson = json_decode($data);
        $dataSubFromJson = json_decode($subData);

        foreach($dataFromJson->data->data as $key => $data ){
            $data->subMenus = [];
            foreach($dataSubFromJson->data->data as $key2 => $data2 ){
                if($data->id == $data2->parent ){
                    array_push($data->subMenus, $data2);
                }
            }
        }

        $dataEncode = json_encode($dataFromJson);

        // return redirect('/menu-page')->with("SessTableData", $dataEncode);// Variable has to come from here

        return $dataEncode;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return response()->json([
            'message' => 'true',
            'data'=> []
        ],200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
       
        // $data = $request->all();
        // $role = new Role;

        $validator = Validator::make($request->all(), Self::get_validator());

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
            return ControllerHelper::ch_insert($config);
        }
      
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //   $role = Role::find($id);
        $req = [
            'id'=>$id
        ];

        $config = Self::configController($req);
        return ControllerHelper::ch_datas($config);

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
        $validator = Validator::make($request->all(), Self::get_validator());

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
            return ControllerHelper::ch_insert($config);
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
        return ControllerHelper::ch_destroy($config);
    }
}
