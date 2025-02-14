<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;
use App\Helpers\ControllerHelper;


class RolesController extends Controller
{
    public static $title = 'Role';
    public static $mainRoute = 'role';
    public static $mainBuilder = 'builder';
    public static $subRoute = [];
    public static $model = 'Role';
    
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

    function table_view(){
        
        Self::purgeConfig();
        $tableReq = [
            'type' => 'generate', /* generate/manual */
            'column_show' => '',
            'column_block' => [
                'created_at','updated_at','id'
            ],
        ];

        $req = [
            'id'=>null,
            // 'table_master' => [
            //     'table_name' => 'subjects',
            //     'alias' => 'a',
            //     'select'=>'a.*',
            // ],
            // 'join' => [
            //     'program_studies'=>[
            //         'join_type'=>'leftJoin',
            //         'alias'=> 'b',
            //         'on'=>'a.program_study_id = b.id',
            //         'select'=> [['b.prodi_name'],['b.description'],['b.created_at as created_at_prodi']
            //     ],
            // ],
        // ],
            // 'where_condition' => [
            //     'equals' => [
            //         ['parent','=','0']
            //     ]
            // ]
        ];
        
        $config = Self::configController($req);
        $dataTable = (ControllerHelper::ch_datas($config));
        
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

    function form_view() {
        Self::purgeConfig();
        $req = [
            'id'=>null,
            // 'table_master' => [
            //     'table_name' => 'program_studies',
            //     'alias' => 'a',
            //     'select'=>'a.*',
            // ],
        ];
        $config = Self::configController($req);
        $dataDropdown = ControllerHelper::ch_datas($config);
        // $dataDropdown =[
        //     ['id'=>'1','name'=>'active'],
        //     ['id'=>'0','name'=>'no active'],
        // ];
        $dataProgramStudy = ['default'=>'0','id'=>'id','name'=>'prodi_name','data'=>$dataDropdown];
    
        $data = [
            ['inputType'=>'TextInput','dataType'=>'text','alias'=>'Nama Role','state'=>'role_name','required'=>'true','note'=>'Gunakan nama yang singkat namun informatif','data'=>''],
            ['inputType'=>'TextInput','dataType'=>'number','alias'=>'Level','state'=>'level','required'=>'true','note'=>'Gunakan nama yang singkat namun informatif','data'=>''],
            ['inputType'=>'textarea','dataType'=>'number','alias'=>'Deskripsi','state'=>'description','required'=>'true','note'=>'Gunakan nama yang singkat namun informatif','data'=>''],
            // ['inputType'=>'dropdown','dataType'=>'text','alias'=>'Program Studi Id','state'=>'name','required'=>'true','note'=>'Gunakan nama yang singkat namun informatif','data'=>$dataProgramStudy],
        ];
        return $data;
    }

    function get_validator(){
        return [
            'role_name' => 'required',
            'level' => 'required',
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
            'id'=>null,
            // 'table_master' => [
            //     'table_name'=>'subjects',
            //     'alias'=>'a',
            //     'select'=> 'a.*',
            // ],
            // 'join'=>[
            //     'program_studies'=>[
            //         'join_type' => 'leftJoin',
            //         'alias'=>'b',
            //         'on'=>'a.program_study_id = b.id',
            //         'select' => [['b.prodi_name'],['b.description'],['b.id as id_prodi'],['b.created_at as created_at_prodi']]
            //     ]
            // ]
        ];

        $config = Self::configController($req);
        $data = ControllerHelper::ch_datas($config);
        // dd($data);
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
        $validator = Validator::make($request->all(), [
            'role_name' => 'required',
            'level' => 'required',
        ]);

        $req = [
            'id'=>null,
            'request'=> $request->all(),
        ];

        if($validator->fails()){
            return back()->withErrors($validator)
            ->withInput();
        }else{
            $config = Self::configController($req);
            if(ControllerHelper::ch_insert($config)){
                session()->flash("dataResponse", 
                 [
                    'code' => 200,
                    'message' => 'Store Success!',
                    'status' => 'true',
                    'data'=> [$validator->messages()]
                ]
            );
                return self::table();
            }
            return session()->flash("dataResponse", 
            [
                'code' => 400,
                'message' => 'Store Failed!',
                'status' => 'false',
                'data'=> [$validator->messages()]
            ]);
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
        $validator = Validator::make($request->all(), [
            // 'role_name' => 'required',
            // 'level' => 'required',
        ]);

        $req = [
            'id'=>$id,
            'request'=> $request->all()
        ];

        if($validator->fails()){
            return back()->withErrors($validator)
            ->withInput();
        }else{
            $config = Self::configController($req);
            if(ControllerHelper::ch_insert($config)){
                session()->flash("dataResponse", 
                    [
                        'code' => 200,
                        'message' => 'Update Success!',
                        'status' => 'true',
                        'data'=> [$validator->messages()]
                    ]
                );
                return self::table();
            }
            return session()->flash("dataResponse", 
            [
                'code' => 400,
                'message' => 'Update Failed!',
                'status' => 'false',
                'data'=> [$validator->messages()]
            ]);
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
        if(ControllerHelper::ch_destroy($config)){
            session()->flash("dataResponse", 
                    [
                        'code' => 200,
                        'message' => 'Delete Success!',
                        'status' => 'true',
                        'data'=> []
                    ]
                );
            return self::table();
        }
        return session()->flash("dataResponse", 
                [
                    'code' => 400,
                    'message' => 'Delete Failed!',
                    'status' => 'true',
                    'data'=> []
                ]
            );
        
    }
}
