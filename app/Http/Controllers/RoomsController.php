<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;
use App\Helpers\ControllerHelper;


class RoomsController extends Controller
{
    public static $title = 'Ruangan';
    public static $mainRoute = 'room';
    public static $mainBuilder = 'builder';
    public static $subRoute = [];
    public static $model = 'Room';
    public static $master_table = 'sys_content';
    
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

    function table_view() {
        $data = [
                    ['column' => 'room_name', 'alias' => 'Nama Ruangan', 'data' => '', 'className'=>''],
                    ['column' => 'description', 'alias' => 'Deskripsi', 'data' => '', 'className'=>''],
                    ['column' => 'is_active', 'alias' => 'Aktif', 'data' => '', 'className'=>''],
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
            ['inputType'=>'TextInput','dataType'=>'text','alias'=>'Nama Ruangan','state'=>'room_name','required'=>'true','note'=>'Gunakan nama yang singkat namun informatif','data'=>''],
            ['inputType'=>'textarea','dataType'=>'text','alias'=>'Deskripsi','state'=>'description','required'=>'false','note'=>'','data'=>''],
            ['inputType'=>'TextInput','dataType'=>'text','alias'=>'Created','state'=>'created_at','required'=>'false','note'=>'Ini Otomatis','data'=>''],
            ['inputType'=>'TextInput','dataType'=>'text','alias'=>'Aktif','state'=>'is_active','required'=>'false','note'=>'','data'=>''],
        ];
        return $data;
    }

    function get_validator(){
        return [
            'room_name' => 'required'
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

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $req = [
            'id'=>null,
            'where_condition' => [
                "equals" => [
                    // ['a.parent','=','0'],
                //     // ['b.role_id','=',auth()->user()->role_id],
                    ['a.is_active','=','1'],
                ],
            ]
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
        $req = [
            'id'=>null
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
        ControllerHelper::ch_destroy($config);
        return to_route(self::$subRoute['table']);
        
    }
    
}
