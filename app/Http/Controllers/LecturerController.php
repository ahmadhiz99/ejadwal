<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use App\Helpers\ControllerHelper;


class LecturerController extends Controller
{
    // new
    public static $title = 'Dosen';
    public static $mainRoute = 'lecturer';
    public static $mainBuilder = 'builder';
    public static $subRoute = [];
    public static $model = 'User';
    public static $master_table = 'users';
    
    public  function __construct() {
        // routingan backend
        self::$subRoute = [
            'index' => self::$mainRoute . '.index',
            'table' => self::$mainRoute . '.table',
            'show' => self::$mainRoute . '.show',
            'create' => self::$mainRoute . '.create',
            'store' => '/' . self::$mainRoute . '-store', /* /route-store  */
            'edit' => self::$mainRoute . '-edit',
            'update' => '/'.self::$mainRoute . '-update',
            'destroy' => self::$mainRoute . '-destroy'
        ];
    }

    function table_view() {
        $data = [
            ['column' => 'name', 'alias' => 'Nama', 'data' => '', 'className'=>''],
            ['column' => 'email', 'alias' => 'Email', 'data' => '', 'className'=>''],
            ['column' => 'role_id', 'alias' => 'Role', 'data' => '', 'className'=>''],
        ];
        return $data;
    }

    function form_view() {
        Self::purgeConfig();
        $req = [
            'id'=>null,
            'where_condition' => [
                'equals' => [
                    ['parent','=','0']
                ]
            ]
        ];
        $config = Self::configController($req);
        $dataParent = ControllerHelper::ch_datas($config);

        $data = [
            ['inputType'=>'TextInput','dataType'=>'text','alias'=>'Nama User','state'=>'name','required'=>'true','note'=>'Gunakan nama yang singkat namun informatif','data'=>''],
                    ['inputType'=>'TextInput','dataType'=>'text','alias'=>'Email','state'=>'email','required'=>'true','note'=>'','data'=>''],
                    ['inputType'=>'TextInput','dataType'=>'text','alias'=>'Password','state'=>'password','required'=>'true','note'=>'','data'=>''],
                    ['inputType'=>'TextInput','dataType'=>'text','alias'=>'Status','state'=>'status','required'=>'true','note'=>'','data'=>''],
                    ['inputType'=>'TextInput','dataType'=>'text','alias'=>'NIS','state'=>'nis','required'=>'true','note'=>'','data'=>''],
                    ['inputType'=>'TextInput','dataType'=>'text','alias'=>'Role Id','state'=>'role_id','required'=>'true','note'=>'','data'=>''],
                    ['inputType'=>'TextInput','dataType'=>'text','alias'=>'Program Studi Id','state'=>'program_study_id','required'=>'true','note'=>'','data'=>''],
        ];
        return $data;
    }

    function get_validator(){
        return [
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
            'nis' => 'required',
            'program_study_id' => 'required'
        ];
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

    public function table(){
        $req = [
            'id'=>null,
            'where_condition'=>[
                'equals' => [
                    ['role_id','=','3'],
                    ['status','=','1'],
                ]
            ]
        ];

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
        // $data = $request->all();
        $validator = Validator::make($request->all(), Self::get_validator());

        $req = [
            'id'=>null,
            'request'=> $request->all(),
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
            return to_route(self::$subRoute['table']);
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
        $req = [
            'id'=>$id
        ];

        $config = Self::configController($req);
        $data = ControllerHelper::ch_datas($config);
        
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
}
