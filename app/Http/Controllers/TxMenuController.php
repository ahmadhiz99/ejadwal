<?php

namespace App\Http\Controllers;

use App\Models\Menurole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;
use App\Helpers\ControllerHelper;


class TxMenuController extends Controller
{
    public static $title = 'TX Menu';
    public static $mainRoute = 'txmenu';
    public static $mainBuilder = 'builder';
    public static $subRoute = [];
    public static $model = 'Menurole';
    
    public  function __construct() {
        // routingan backend
        self::$subRoute = [
            'index' => self::$mainBuilder . '.index',
            'table' => self::$mainRoute . '.table',
            'show' => self::$mainRoute . '.show',
            'create' => self::$mainRoute . '.create',
            'store' => '/' . self::$mainRoute . '-store', /* /route-store  */
            'edit' => self::$mainRoute . '-edit',
            'update' => '/'.self::$mainRoute . '-update',
            'destroy' => self::$mainRoute . '-destroy'
        ];
    }

    function get_validator(){
        return [
            // 'menu_id' => 'required',
            'role_id' => 'required',
            'is_active' => 'required'
        ];
    }

    function table_view($params = null){
        Self::purgeConfig();

        $req = [
            'id'=>null,
            'table_master' => [
                'table_name' => 'tx_menu_roles',
                'alias' => 'a',
                // 'select'=>"a.*",
                'select'=>[
                    'a.*',
                    ['IF(a.is_active = 0,"Non Active","Active") as is_active','raw()']
                ]
            ],
            'join' => [
                'sys_menu'=>[
                    'join_type'=>'leftJoin',
                    'alias'=> 'b',
                    'on'=>'a.menu_id = b.id',
                    'select'=> [
                        ['b.name']
                    ],
                ],
                'roles'=>[
                    'join_type'=>'leftJoin',
                    'alias'=> 'c',
                    'on'=>'a.role_id = c.id',
                    'select'=> [
                        ['c.role_name']
                    ],
                ],
            ],
        ];

        if($params == 'get_req'){
            return $req;
        }

        $tableReq = [
            'type' => 'generate', /* generate/manual */
            'column_show' => '',
            'column_block' => [
                'description','created_at','updated_at','program_study_id','role_id','menu_id','id'
            ],
        ];

        $config = Self::configController($req);
        $dataTable = (ControllerHelper::ch_datas($config));

        return self::generate_table_view($tableReq, $dataTable);
       
    }

    function form_view($params = null) {
        Self::purgeConfig();
        $req = [
            'id'=>null,
            'table_master' => [
                'table_name' => 'sys_menu',
                'alias' => 'a',
                'select'=>'a.*',
            ],
            'where_condition' => [
                "equals" => [
                    ['a.parent','=','0'],
                ],
            ],
        ];
        $config = Self::configController($req);
        $dataDropdown = ControllerHelper::ch_datas($config);
        $data_menu = ['default'=>'0','id'=>'id','name'=>'name','data'=>$dataDropdown];

       
        Self::purgeConfig();
        $req = [
            'id'=>null,
            'table_master' => [
                'table_name' => 'sys_menu',
                'alias' => 'a',
                'select'=>'a.*',
            ],
            'where_condition' => [
                "equals" => [
                    ['a.parent','<>','0'],
                ],
            ],
        ];
        $config = Self::configController($req);
        $dataDropdownSub = ControllerHelper::ch_datas($config);
        $data_menu_sub = ['default'=>'0','id'=>'id','name'=>'name','data'=>$dataDropdownSub];

        Self::purgeConfig();
        $req = [
            'id'=>null,
            'table_master' => [
                'table_name' => 'roles',
                'alias' => 'a',
                'select'=>'a.*',
            ],
        ];
        $config = Self::configController($req);
        $dataDropdown = ControllerHelper::ch_datas($config);
        // $dataDropdown =[
        //     ['id'=>'1','name'=>'active'],
        //     ['id'=>'0','name'=>'no active'],
        // ];
        $data_role = ['default'=>'0','id'=>'id','name'=>'role_name','data'=>$dataDropdown];

        Self::purgeConfig();
       
        $dataDropdown =[
            ['id'=>'1','name'=>'active'],
            ['id'=>'0','name'=>'no active'],
        ];
        $data_active = ['default'=>'0','id'=>'id','name'=>'name','data'=>$dataDropdown];
    
        $data = [
            [
                'inputType'=>'dropdown',
                'dataType'=>'text',
                'alias'=>'Menu Name',
                'state'=>'menu_id',
                'required'=>'true',
                'note'=>'Gunakan nama yang singkat namun informatif',
                'data'=>$data_menu
            ],
            [
                'inputType'=>'checkbox_relation',
                'dataType'=>'text',
                'alias'=>'Sub Menu',
                'required'=>'true',
                'note'=>'Gunakan nama yang singkat namun informatif',
                'state'=>'menu_id',
                'state_relation'=>'menu_id',
                'data'=>$data_menu_sub
            ],
            [
                'inputType'=>'dropdown',
                'dataType'=>'number',
                'alias'=>'Role Name',
                'state'=>'role_id',
                'required'=>'true',
                'note'=>'Gunakan nama yang singkat namun informatif',
                'data'=>$data_role
            ],
            [
                'inputType'=>'textarea',
                'dataType'=>'number',
                'alias'=>'Deskripsi',
                'state'=>'description',
                'required'=>'true',
                'note'=>'Gunakan nama yang singkat namun informatif',
                'data'=>''
            ],
            [
                'inputType'=>'dropdown',
                'dataType'=>'text',
                'alias'=>'Aktif',
                'state'=>'is_active',
                'required'=>'true',
                'note'=>'Gunakan nama yang singkat namun informatif',
                'data'=>$data_active
            ],
        ];
        return $data;
    }


     function configController($params = null){
        $config = [
            'model'=> self::$model,
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

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $req = [
            'id'=>null,
            'table_master' => [
                'table_name' => 'classes',
                'alias' => 'a',
                'select'=>'a.*',
            ],
            'join' => [
                'program_studies'=>[
                    'join_type'=>'leftJoin',
                    'alias'=> 'b',
                    'on'=>'a.program_study_id = b.id',
                    'select'=> [
                        ['b.prodi_name'],['b.description as prodi_description']
                    ],
                ],
            ],
        ];

        $config = Self::configController($req);
        $data = ControllerHelper::ch_datas($config);
        
        Self::purgeConfig();
      

        $config = Self::configController($req);
        $subData = ControllerHelper::ch_datas($config);
        $dataFromJson = $data;
        $dataSubFromJson = $subData;


        $dataEncode = json_encode($dataFromJson);
        // return redirect('/menu-page')->with("SessTableData", $dataEncode);// Variable has to come from here
        return $dataEncode;
    }

    public function table(){

       $req = self::table_view('get_req');

        $config = Self::configController($req);
        $data = ControllerHelper::ch_datas($config);
        $dataTable = [
                        'tableConfig' => [
                            'idType'=>['alias'=>'No','type'=>'number'],/* number/alphabet */
                            'columnMode'=>'manual',/* manual/auto */
                            'columnCase'=>'camel',/* upper/lowercase/camel/pascal */
                            'orderColumn' =>'id,asc', /* name column then asc or desc */
                            'title' => self::$title, 
                            'action' => [ 
                                'alias' => 'Aksi',
                                'feature' => [ /*feature = add,edit,delete */
                                    // ['feature'=>'detail', 'alias'=> 'Detail', 'route'=>self::$subRoute['show'], 'icon'=>'bx-info-circle','disabled'=>'false','hide'=>'false'], 
                                    ['feature'=>'edit', 'alias'=> 'Edit', 'route'=>self::$subRoute['edit'], 'icon'=>'bx-pencil','disabled'=>'false','hide'=>'false'], 
                                    ['feature'=>'delete', 'alias'=> 'Hapus', 'route'=>self::$subRoute['destroy'], 'icon'=>'bx-trash','disabled'=>'false','hide'=>'false'], 
                                    ['feature'=>'add', 'alias'=> 'Tambah', 'route'=>self::$subRoute['create'], 'icon'=>'','disabled'=>'false','hide'=>'false'], 
                                ]
                            ]
                        ],
                        'data'=> self::table_view()
                    ];


        $data = ['data'=>$data,'dataTable'=>$dataTable];
        session()->put("SessTableData", $data);
        return redirect('/builder/table');// Variable has to come from here
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        $dataForm = [
            'formConfig' => [
                'title' => 'Tambah '.self::$title.' Baru', /*title page*/
                'route'=> self::$subRoute['store'], /*route backend*/
                'formInput' => self::form_view(),
            ],
        ];

        $data = ['dataForm'=>$dataForm];
        session()->put("SessFormData", $data);
        return redirect('/builder/table/add');// Variable has to come from here
 
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), Self::get_validator());

        $data = $request->all();
        $dataArr = [];

        $menuSubKeys = [];
        $otherKeys = [];
        
        // Iterate through the array
        foreach ($data as $key => $value) {
            if (strpos($key, "menu_id") === 0) {
                $menuSubKeys[$key] = $value;
            } else {
                $otherKeys[$key] = $value;
            }
        }

        foreach($menuSubKeys as $key => $val ){

            $otherKeys["menu_id"] = $val;

            $req = [
                'id'=>null,
                'request'=> $otherKeys,
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
            }
        }

        return to_route(self::$subRoute['table']);


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
        $req = [
            'id'=>$id
        ];

        $config = Self::configController($req);
        $data = ControllerHelper::ch_datas($config);
        // dd($data);
        
        $dataForm = [
            'formConfig' => [
                'title' => 'Edit Data '.self::$title, /*title page*/
                'route'=> self::$subRoute['update'], /*route backend*/
                'method'=> 'post', /* post for create, put/patch for update */
                'formInput' => self::form_view(),
            ],
        ];
        $data = ['data'=>$data, 'dataForm'=>$dataForm];
        session()->put("SessFormData", $data);
        return redirect('/builder/table/edit');// Variable has to come from here
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
                'message' => 'Update '. self::$title .' Failed!',
                'status' => 'false',
                'data'=> [$validator->messages()]
            ],400);
        }else{
            $config = Self::configController($req);
            if(ControllerHelper::ch_insert($config)){
                return to_route(self::$subRoute['table']);
            }else{
                return response()->json([
                    'message' => 'Update '. self::$title .' Failed!',
                    'status' => 'false',
                    'data'=> [$validator->messages()]
                ],400);
            }
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

    function generate_table_view($tableReq, $dataTable){
        if($tableReq['type'] == 'generate'){
            $data=[];
            $dataColumn=[];
            $dataForm = $dataTable[0];
            foreach($dataForm as $key1 => $data1){
                foreach($tableReq['column_block'] as $key2 => $data2){
                    if($key1 == $data2){
                        unset($dataForm->$key1);
                    }
                }
            }

            foreach($dataForm as $key => $val){
                $dataColumn['column'] = $key;
                if(str_contains($key,'_')){
                    $generate_column = str_replace('_', ' ', ucwords($key, '_'));
                    $dataColumn['alias'] = $generate_column;
                }else{
                    $generate_column = ucwords($key);
                    $dataColumn['alias'] = $generate_column;
                }
                array_push($data,$dataColumn);
            }
            return $data;
            
        }else{
            $data = [
                    ['column' => 'subject_name', 'alias' => 'Nama Mata Kuliah', 'data' => '', 'className'=>''],
                    ['column' => 'code', 'alias' => 'Kode', 'data' => '', 'className'=>''],
                    ['column' => 'sks', 'alias' => 'Sks', 'data' => '', 'className'=>''],
                    ['column' => 'semester', 'alias' => 'Semester', 'data' => '', 'className'=>''],
                    ['column' => 'prodi_name', 'alias' => 'Progam Studi', 'data' => '', 'className'=>''],
                ];
            return $data;
        }
    }
}
