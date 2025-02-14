<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\helpers\ControllerHelper;
use App\Models\Menu;
use App\Models\Sys_Content;
use Inertia\Inertia;
use Illuminate\Support\Facades\Validator;

class Sys_ContentController extends Controller
{
    public static $title = 'Konten';
    public static $mainRoute = 'content';
    public static $mainBuilder = 'builder';
    public static $subRoute = [];
    public static $model = 'Sys_Content';
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

    function get_validator(){
        return [
            'name' => 'required',
            'value' => 'required',
        ];
    }

    function table_view($params = null){
        Self::purgeConfig();

        $req = [
            'id'=>null,
        ];

        if($params == 'get_req'){
            return $req;
        }

        $tableReq = [
            'type' => 'generate', /* generate/manual */
            'column_show' => '',
            'column_block' => [
                'created_at','updated_at','program_study_id','role_id','menu_id','id'
            ],
        ];

        $config = Self::configController($req);
        $dataTable = (ControllerHelper::ch_datas($config));

        return self::generate_table_view($tableReq, $dataTable);
    }

    function form_view($params = null) {
        Self::purgeConfig();
       
        $dataDropdown =[
            ['id'=>'1','name'=>'active'],
            ['id'=>'0','name'=>'no active'],
        ];
        $data_active = ['default'=>'0','id'=>'id','name'=>'name','data'=>$dataDropdown];
    
        $data = [
            ['inputType'=>'TextInput','dataType'=>'text','alias'=>'Nama Konten','state'=>'name','required'=>'true','note'=>'Gunakan nama yang singkat namun informatif','data'=>''],
            ['inputType'=>'TextInput','dataType'=>'text','alias'=>'Isi Konten','state'=>'value','required'=>'true','note'=>'','data'=>''],
            ['inputType'=>'dropdown','dataType'=>'text','alias'=>'Active','state'=>'is_active','required'=>'true','note'=>'','data'=>$data_active],
            ['inputType'=>'textarea','dataType'=>'text','alias'=>'Deskripsi','state'=>'description','required'=>'false','note'=>'','data'=>''],        
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
        ];

        $config = Self::configController($req);
        $data = ControllerHelper::ch_datas($config);
        
        return $data;
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
                        ['column' => 'name', 'alias' => 'Nama', 'data' => '', 'className'=>''],
                        ['column' => 'value', 'alias' => 'Isi Konten', 'data' => '', 'className'=>''],
                        ['column' => 'description', 'alias' => 'Deskripsi', 'data' => '', 'className'=>''],
                        ['column' => 'is_active', 'alias' => 'Active', 'data' => '', 'className'=>''],
                    ];
            return $data;
        }
    }
}