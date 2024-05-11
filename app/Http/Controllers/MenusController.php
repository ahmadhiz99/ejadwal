<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;
use App\Helpers\ControllerHelper;


class MenusController extends Controller
{
     function configController($params = null){
        $config = [
            'model'=>'Menu'
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

    public function table(){
        $req = [
            'id'=>null
        ];

        $config = Self::configController($req);

        // return 
        $data = ControllerHelper::ch_datas($config);
        $dataTable = [
                        'tableConfig' => [
                            'idType'=>['alias'=>'No','type'=>'number'],/* number/alphabet */
                            'columnMode'=>'manual',/* manual/auto */
                            'columnCase'=>'camel',/* upper/lowercase/camel/pascal */
                            'orderColumn' =>'id,asc', /* name column then asc or desc */
                            'title' => 'Menus',
                            'action' => [ 
                                'alias' => 'Aksi',
                                'feature' => [ /*feature = add,edit,delete */
                                    // ['feature'=>'detail', 'alias'=> 'Detail', 'route'=>'menu-show', 'icon'=>'bx-info-circle','disabled'=>'false','hide'=>'false'], 
                                    ['feature'=>'edit', 'alias'=> 'Edit', 'route'=>'menu-edit', 'icon'=>'bx-pencil','disabled'=>'false','hide'=>'false'], 
                                    ['feature'=>'delete', 'alias'=> 'Hapus', 'route'=>'menu-destroy', 'icon'=>'bx-trash','disabled'=>'false','hide'=>'false'], 
                                    ['feature'=>'add', 'alias'=> 'Tambah', 'route'=>'menu.create', 'icon'=>'','disabled'=>'false','hide'=>'false'], 
                                ]
                            ]
                        ],
                        'data'=>[
                            ['column' => 'name', 'alias' => 'Nama Menu', 'data' => '', 'className'=>''],
                            ['column' => 'code', 'alias' => 'Kode', 'data' => '', 'className'=>''],
                            ['column' => 'route', 'alias' => 'BackendRoute', 'data' => '', 'className'=>''],
                            ['column' => 'activeRoute', 'alias' => 'FrontendRoute', 'data' => '', 'className'=>''],
                        ]
                    ];

        $data = ['data'=>$data,'dataTable'=>$dataTable];
        // return $data[1];
        return redirect('/menu')->with("SessTableData", $data);// Variable has to come from here
 
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $req = [
            'id'=>null
        ];
        $config = Self::configController($req);
        $data = ControllerHelper::ch_datas($config);
        $dataMenu = $data->original['data'];

        $dataForm = [
            'formConfig' => [
                'title' => 'Tambah Menu Baru', /*title page*/
                'route'=> '/menu-store', /*route backend*/
                'formInput' => [
                    ['inputType'=>'TextInput','dataType'=>'text','alias'=>'Nama Menu','state'=>'name','required'=>'true','note'=>'Gunakan nama yang singkat namun informatif','data'=>''],
                    ['inputType'=>'TextInput','dataType'=>'text','alias'=>'Nama Kode','state'=>'code','required'=>'true','note'=>'','data'=>''],
                    ['inputType'=>'dropdown','dataType'=>'text','alias'=>'Parent','state'=>'parent','required'=>'true','note'=>'','data'=>$dataMenu],
                    // ['inputType'=>'TextInput','dataType'=>'text','alias'=>'Parent','state'=>'parent','required'=>'true','note'=>'','data'=>''],
                    ['inputType'=>'TextInput','dataType'=>'text','alias'=>'Route','state'=>'route','required'=>'true','note'=>'','data'=>''],
                    ['inputType'=>'TextInput','dataType'=>'text','alias'=>'Active','state'=>'is_active','required'=>'true','note'=>'','data'=>''],
                    ['inputType'=>'textarea','dataType'=>'text','alias'=>'Deskripsi','state'=>'description','required'=>'false','note'=>'','data'=>''],
                ],
            ],
        ];

        $data = ['dataForm'=>$dataForm];
        return redirect('/menu/add')->with("SessTableData", $data);// Variable has to come from here
 
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
    public function edit(Request $request,$id)
    {
        //
        $req = [
            'id'=>$id
        ];

        $config = Self::configController($req);
        $data = ControllerHelper::ch_datas($config);
        // $data = Menu::find($id);
        $dataForm = [
            'formConfig' => [
                'title' => 'Edit Data Menu', /*title page*/
                'route'=> '/menu-update', /*route backend*/
                'method'=> 'post', /* post for create, put/patch for update */
                'formInput' => [
                    ['inputType'=>'TextInput','dataType'=>'text','alias'=>'Nama Menu','state'=>'name','required'=>'true','note'=>'Gunakan nama yang singkat namun informatif','data'=>''],
                    ['inputType'=>'TextInput','dataType'=>'text','alias'=>'Nama Kode','state'=>'code','required'=>'true','note'=>'','data'=>''],
                    ['inputType'=>'TextInput','dataType'=>'text','alias'=>'Parent','state'=>'parent','required'=>'true','note'=>'','data'=>''],
                    ['inputType'=>'TextInput','dataType'=>'text','alias'=>'Route','state'=>'route','required'=>'true','note'=>'','data'=>''],
                    ['inputType'=>'TextInput','dataType'=>'text','alias'=>'Active','state'=>'is_active','required'=>'true','note'=>'','data'=>''],
                    ['inputType'=>'textarea','dataType'=>'text','alias'=>'Deskripsi','state'=>'description','required'=>'false','note'=>'','data'=>''],
                ],
            ],
        ];
        $data = ['data'=>$data, 'dataForm'=>$dataForm];
        return redirect('/menu/edit')->with("SessTableData", $data);// Variable has to come from here
        
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
