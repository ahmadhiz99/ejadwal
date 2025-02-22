<?php 
// <!-- MENU MAPPING -->
// <!-- Name Menu -->
// <!-- Main Model -->
// <!-- Mapping Form -->
// <!-- Mapping Table -->
// <!-- Mapping Rute -->
// <!-- Mapping SubRoute -->
// <!-- Validator -->

namespace App\Helpers;
use App\Helpers\TableHelper;
use App\Helpers\FormHelper;
use App\Helpers\ControllerHelper;
use Illuminate\Support\Facades\Auth;

class MapperHelper {

    public static function configController($params = null, $model){
        $config = [
            'model'=> $model,
        ];

        if($params != null){
            $config = array_merge($config, $params);
        }
        
        return $config;
    }

    public static function purgeConfig(){
        $configTemp = Self::configController();
        $config = [];
        $config = $configTemp;
    }

    public static function schedules($params = nul, $id_data = null){
        /**
         * DATAS CONFIG START
         */
        $title = 'Jadwal';
        $mainRoute = 'schedule';
        $mainBuilder = 'builder';
        $subRoute = [];
        $model = 'Schedule';
        $table_name = 'schedules';

        $subRoute = [
            'index' => $mainBuilder . '.index',
            'table' => $mainRoute . '.table',
            'show' => $mainRoute . '.show',
            'create' => $mainRoute . '.create',
            'store' => '/' . $mainRoute . '-store', /* /route-store  */
            'edit' => $mainRoute . '-edit',
            'update' => '/'.$mainRoute . '-update',
            'destroy' => $mainRoute . '-destroy'
        ];
        /**
         * DATAS CONFIG END
         */


        /**
         * TABLE CONFIG START
         */
        
        //  Query ke database
        $role = Auth()->user()->role_id;

        $where_condition = [ ];

        if($role == 3){
            $where_condition = [
                    "equals" => [
                        ['a.user_id','=',Auth()->user()->id],
                    ],
                ];
        }

        $table_req_query = [
            'table_master' => [
                'table_name' => $table_name,
                'alias' => 'a',
                'select'=>[
                    'a.*',
                    ['IF(a.status = 0,"Diajukan","Disetujui") as status','raw()']
                ]
            ],
            'join' => [
                'classes'=>[
                    'join_type'=>'leftJoin',
                    'alias'=> 'b',
                    'on'=>'a.class_id = b.id',
                    'select'=> [
                        ['b.class_name']
                    ],
                ],
                'rooms'=>[
                    'join_type'=>'leftJoin',
                    'alias'=> 'c',
                    'on'=>'a.room_id = c.id',
                    'select'=> [
                        ['c.room_name']
                    ],
                ],
                'subjects'=>[
                    'join_type'=>'leftJoin',
                    'alias'=> 'd',
                    'on'=>'a.subject_id = d.id',
                    'select'=> [
                        ['d.subject_name']
                    ],
                ],
                'users'=>[
                    'join_type'=>'leftJoin',
                    'alias'=> 'e',
                    'on'=>'a.user_id = e.id',
                    'select'=> [
                        ['e.name as user_name']
                    ],
                ],
                'hari'=>[
                    'join_type'=>'leftJoin',
                    'alias'=> 'f',
                    'on'=>'a.day = f.id',
                    'select'=> [
                        ['f.day_name as hari']
                    ],
                ],
            ],
            'where_condition' => $where_condition
        ];

        
        // Table header
        $tableReq = [
            'type' => 'generate', /* generate/manual */
            'column_show' => '',
            'column_block' => [
                'created_at','updated_at','class_id','room_id','subject_id','id','user_id','day'
            ],
        ];

        $feture = [];
        if($role == 1){
            $feture = [ 
                        // ['feature'=>'detail', 'alias'=> 'Detail', 'route'=>self::$subRoute['show'], 'icon'=>'bx-info-circle','disabled'=>'false','hide'=>'false'], 
                        ['feature'=>'edit', 'alias'=> 'Edit', 'route'=>$subRoute['edit'], 'icon'=>'bx-pencil','disabled'=>'false','hide'=>'false'], 
                        ['feature'=>'delete', 'alias'=> 'Hapus', 'route'=>$subRoute['destroy'], 'icon'=>'bx-trash','disabled'=>'false','hide'=>'false'], 
                        ['feature'=>'add', 'alias'=> 'Tambah', 'route'=>$subRoute['create'], 'icon'=>'','disabled'=>'false','hide'=>'false'], 
            ];
        }
        if($role == 2){
            $feture = [ 
                        ['feature'=>'edit', 'alias'=> 'Edit', 'route'=>$subRoute['edit'], 'icon'=>'bx-pencil','disabled'=>'false','hide'=>'false'], 
                        ['feature'=>'delete', 'alias'=> 'Hapus', 'route'=>$subRoute['destroy'], 'icon'=>'bx-trash','disabled'=>'false','hide'=>'false'], 
                        ['feature'=>'add', 'alias'=> 'Tambah', 'route'=>$subRoute['create'], 'icon'=>'','disabled'=>'false','hide'=>'false'], 
            ];
        }
        if($role == 3){
            $feture = [ 
                ['feature'=>'add', 'alias'=> 'Tambah', 'route'=>$subRoute['create'], 'icon'=>'','disabled'=>'false','hide'=>'false'], 
            ];
        }
        if($role == 4){
            $feture = [ 
                        ['feature'=>'edit', 'alias'=> 'Edit', 'route'=>$subRoute['edit'], 'icon'=>'bx-pencil','disabled'=>'false','hide'=>'false'], 
                        ['feature'=>'delete', 'alias'=> 'Hapus', 'route'=>$subRoute['destroy'], 'icon'=>'bx-trash','disabled'=>'false','hide'=>'false'], 
            ];
        }
       
        // Table value
        $dataTable = [
            'tableConfig' => [
                'idType'=>['alias'=>'No','type'=>'number'],/* number/alphabet */
                'columnMode'=>'manual',/* manual/auto */
                'columnCase'=>'camel',/* upper/lowercase/camel/pascal */
                'orderColumn' =>'id,asc', /* name column then asc or desc */
                'title' => $title, 
                'action' => [ 
                    'alias' => 'Aksi',
                    'feature' => $feture,
                ]
            ],
            'data'=> TableHelper::table_view($table_req_query, $tableReq)
        ];

        /**
         * TABLE CONFIG END
         */


        /**
         * DATA FORM START
        */

        $statusInput = '';
        if(in_array($role, [1,2,4]) ){
            $statusInput = [
                'inputType'=>'dropdown',
                'dataType'=>'text',
                'alias'=>'Status',
                'required'=>'true',
                'note'=>'Status',
                'state'=>'status',
                // 'data'=>FormHelper::dropdownInstantBool('status')            
                'data'=>FormHelper::dropdownInstantBool(null, null, null, 
                    [
                        ['id'=>1,'name'=>'Setujui'],
                        ['id'=>0,'name'=>'Request'],
                    ]
                )            
            ];
        }

        $lecturerInput = '';
        if(in_array($role, [1,2,4]) ){
            $lecturerInput = [
                'inputType'=>'dropdown',
                'dataType'=>'text',
                'alias'=>'Nama Dosen',
                'required'=>'true',
                'note'=>'Gunakan nama yang singkat namun informatif',
                'state'=>'user_id',
                'data'=>FormHelper::dropdownInstant('name','users')
            ];
        }

        $formConfig = [
            [
                'inputType'=>'time',
                'dataType'=>'time',
                'alias'=>'Start Time',
                'state'=>'start_time',
                'required'=>'true',
                'note'=>'Gunakan nama yang singkat namun informatif',
            ],
            [
                'inputType'=>'time',
                'dataType'=>'time',
                'alias'=>'End Time',
                'state'=>'end_time',
                'required'=>'true',
                'note'=>'Gunakan nama yang singkat namun informatif',
            ],
            [
                'inputType'=>'dropdown',
                'dataType'=>'number',
                'alias'=>'Hari',
                'state'=>'day',
                'required'=>'true',
                'note'=>'Gunakan nama yang singkat namun informatif',
                // 'data'=>$data_day
                'data'=> FormHelper::dropdownInstant('day_name','hari')
            ],
            [
                'inputType'=>'dropdown',
                'dataType'=>'number',
                'alias'=>'Matakuliah',
                'state'=>'subject_id',
                'required'=>'true',
                'note'=>'Gunakan nama yang singkat namun informatif',
                // 'data'=>$data_subject
                'data'=> FormHelper::dropdownInstant('subject_name','subjects')
            ],
            [
                'inputType'=>'dropdown',
                'dataType'=>'text',
                'alias'=>'Room',
                'state'=>'room_id',
                'required'=>'true',
                'note'=>'Gunakan nama yang singkat namun informatif',
                'data'=> FormHelper::dropdownInstant('room_name','rooms',['is_active',1])
            ],
            [
                'inputType'=>'dropdown',
                'dataType'=>'text',
                'alias'=>'Nama Kelas',
                'required'=>'true',
                'note'=>'Gunakan nama yang singkat namun informatif',
                'state'=>'class_id',
                'data'=>FormHelper::dropdownInstant('class_name','classes')
            ],
            $lecturerInput,
            $statusInput,
        ];

        // FORM ADD
        $dataFormAdd = [
            'formConfig' => [
                'title' => 'Tambah '.$title.' Baru', /*title page*/
                'route'=> $subRoute['store'], /*route backend*/
                'formInput' => $formConfig
            ],
        ];

        // FORM EDIT
        $dataFormEdit = [
            'data' => (ControllerHelper::ch_datas(['id'=>$id_data, 'table_single'=>'schedules'])),
            
            'dataForm'=>[
                'formConfig' => [
                'title' => 'Edit Data '.$title, /*title page*/
                'route'=> $subRoute['update'], /*route backend*/
                'method'=> 'post', /* post for create, put/patch for update */
                'formInput' => $formConfig,
               ],
            ]
        ];

        /**
         * DATA FORM END
         */

        switch ($params) {
            case 'title':
                return $title;
                break;
            case 'mainRoute':
                return $mainRoute;
                break;
            case 'mainBuilder':
                return $mainBuilder;
                break;
            case 'subRoute':
                return $subRoute;
                break;
            case 'model':
                return $model;
                break;
            case 'table_req_query':
                return $table_req_query;
                break;
            case 'dataTable':
                return $dataTable;
                break;
            case 'dataTable':
                return $dataTable;
                break;
            case 'form_req_query':
                return $form_req_query;
                break;
            case 'dataFormAdd':
                return $dataFormAdd;
                break;
            case 'dataFormEdit':
                return $dataFormEdit;
                break;
            
            default:
                return 'no action found';
                break;
        }
        
        return($req);
        
    }

    public static function tx_menu($params = null){
        $title = 'TX Menu';
        $mainRoute = 'txmenu';
        $mainBuilder = 'builder';
        $subRoute = [];
        $model = 'Menurole';

        $subRoute = [
            'index' => $mainBuilder . '.index',
            'table' => $mainRoute . '.table',
            'show' => $mainRoute . '.show',
            'create' => $mainRoute . '.create',
            'store' => '/' . $mainRoute . '-store', /* /route-store  */
            'edit' => $mainRoute . '-edit',
            'update' => '/'.$mainRoute . '-update',
            'destroy' => $mainRoute . '-destroy'
        ];


        $table_req_query = [
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

        $tableReq = [
            'type' => 'generate', /* generate/manual */
            'column_show' => '',
            'column_block' => [
                'description','created_at','updated_at','program_study_id','role_id','menu_id','id'
            ],
        ];

        $dataTable = [
            'tableConfig' => [
                'idType'=>['alias'=>'No','type'=>'number'],/* number/alphabet */
                'columnMode'=>'manual',/* manual/auto */
                'columnCase'=>'camel',/* upper/lowercase/camel/pascal */
                'orderColumn' =>'id,asc', /* name column then asc or desc */
                'title' => $title, 
                'action' => [ 
                    'alias' => 'Aksi',
                    'feature' => [ /*feature = add,edit,delete */
                        // ['feature'=>'detail', 'alias'=> 'Detail', 'route'=>self::$subRoute['show'], 'icon'=>'bx-info-circle','disabled'=>'false','hide'=>'false'], 
                        ['feature'=>'edit', 'alias'=> 'Edit', 'route'=>$subRoute['edit'], 'icon'=>'bx-pencil','disabled'=>'false','hide'=>'false'], 
                        ['feature'=>'delete', 'alias'=> 'Hapus', 'route'=>$subRoute['destroy'], 'icon'=>'bx-trash','disabled'=>'false','hide'=>'false'], 
                        ['feature'=>'add', 'alias'=> 'Tambah', 'route'=>$subRoute['create'], 'icon'=>'','disabled'=>'false','hide'=>'false'], 
                    ]
                ]
            ],
            // 'data'=> self::table_view()
            'data'=> TableHelper::table_view($table_req_query, $tableReq)
        ];


          /**
         * DATA FORM START
        */
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

        $dataDropdown = ControllerHelper::ch_datas(Self::configController($req, $model));
        $data_menu = ['default'=>'0','id'=>'id','name'=>'name','data'=>$dataDropdown];

        // Self::purgeConfig();
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
        $config = Self::configController($req, $model);
        $dataDropdownSub = ControllerHelper::ch_datas($config);
        $data_menu_sub = ['default'=>'0','id'=>'id','name'=>'name','data'=>$dataDropdownSub];

        $req = [
            'id'=>null,
            'table_master' => [
                'table_name' => 'roles',
                'alias' => 'a',
                'select'=>'a.*',
            ],
        ];
        $config = Self::configController($req, $model);
        $dataDropdown = ControllerHelper::ch_datas($config);
        $data_role = ['default'=>'0','id'=>'id','name'=>'role_name','data'=>$dataDropdown];

        $dataDropdown =[
            ['id'=>'1','name'=>'active'],
            ['id'=>'0','name'=>'no active'],
        ];
        $data_active = ['default'=>'0','id'=>'id','name'=>'name','data'=>$dataDropdown];
    
        $form_config_data = [
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


        $dataForm = [
            'formConfig' => [
                'title' => 'Tambah '.$title.' Baru', /*title page*/
                'route'=> $subRoute['store'], /*route backend*/
                'formInput' => FormHelper::form_view(),
            ],
        ];

        /**
         * DATA FORM END
         */
        
        switch ($params) {
            case 'title':
                return $title;
                break;
            case 'mainRoute':
                return $mainRoute;
                break;
            case 'mainBuilder':
                return $mainBuilder;
                break;
            case 'subRoute':
                return $subRoute;
                break;
            case 'model':
                return $model;
                break;
            case 'table_req_query':
                return $table_req_query;
                break;
            case 'dataTable':
                return $dataTable;
                break;
            
            default:
                return 'no action found';
                break;
        }
        
        return($req);
        
    }   

    public static function rooms($params = nul, $id_data = null){
        /**
         * DATAS CONFIG START
         */
        $title = 'Ruangan';
        $mainRoute = 'room';
        $mainBuilder = 'builder';
        $subRoute = [];
        $model = 'Room';
        $master_table = 'rooms';

        $subRoute = [
           'index' => $mainBuilder . '.index',
            'table' => $mainRoute . '.table',
            'show' => $mainRoute . '.show',
            'create' => $mainRoute . '.create',
            'store' => '/' . $mainRoute . '-store', /* /route-store  */
            'edit' => $mainRoute . '-edit',
            'update' => '/'.$mainRoute . '-update',
            'destroy' => $mainRoute . '-destroy'
        ];
        /**
         * DATAS CONFIG END
         */


        /**
         * TABLE CONFIG START
         */
        
        //  Query ke database
        $table_req_query = [
            'table_master' => [
                'table_name' => $master_table,
                'alias' => 'a',
                'select'=>[
                    'a.*',
                    ['IF(a.is_active = 0,"Non Active","Active") as is_active','raw()']
                ]
            ],
        ];

        
        // Table header
        $tableReq = [
            'type' => 'generate', /* generate/manual */
            'column_show' => '',
            'column_block' => [
                'created_at','updated_at','id',
            ],
        ];

        // Table value
        $dataTable = [
            'tableConfig' => [
                'idType'=>['alias'=>'No','type'=>'number'],/* number/alphabet */
                'columnMode'=>'manual',/* manual/auto */
                'columnCase'=>'camel',/* upper/lowercase/camel/pascal */
                'orderColumn' =>'id,asc', /* name column then asc or desc */
                'title' => $title, 
                'action' => [ 
                    'alias' => 'Aksi',
                    'feature' => [ /*feature = add,edit,delete */
                        // ['feature'=>'detail', 'alias'=> 'Detail', 'route'=>self::$subRoute['show'], 'icon'=>'bx-info-circle','disabled'=>'false','hide'=>'false'], 
                        ['feature'=>'edit', 'alias'=> 'Edit', 'route'=>$subRoute['edit'], 'icon'=>'bx-pencil','disabled'=>'false','hide'=>'false'], 
                        ['feature'=>'delete', 'alias'=> 'Hapus', 'route'=>$subRoute['destroy'], 'icon'=>'bx-trash','disabled'=>'false','hide'=>'false'], 
                        ['feature'=>'add', 'alias'=> 'Tambah', 'route'=>$subRoute['create'], 'icon'=>'','disabled'=>'false','hide'=>'false'], 
                    ]
                ]
            ],
            // 'data'=> self::table_view()
            'data'=> TableHelper::table_view($table_req_query, $tableReq)
        ];

        /**
         * TABLE CONFIG END
         */


        /**
         * DATA FORM START
        */
        $formConfig = [
            [
                'inputType'=>'TextInput',
                'dataType'=>'text',
                'alias'=>'Room Name',
                'state'=>'room_name',
                'required'=>'true',
                'note'=>'Gunakan nama yang singkat namun informatif',
            ],
            [
                'inputType'=>'TextInput',
                'dataType'=>'text',
                'alias'=>'Description',
                'state'=>'description',
                'required'=>'true',
                'note'=>'Gunakan nama yang singkat namun informatif',
            ],
            [
                'inputType'=>'dropdown',
                'dataType'=>'text',
                'alias'=>'Aktif',
                'state'=>'is_active',
                'required'=>'true',
                'note'=>'Gunakan nama yang singkat namun informatif',
                'data'=>FormHelper::dropdownInstantBool('is_active')
            ],
        ];

        // FORM ADD
        $dataFormAdd = [
            'formConfig' => [
                'title' => 'Tambah '.$title.' Baru', /*title page*/
                'route'=> $subRoute['store'], /*route backend*/
                'formInput' => $formConfig
            ],
        ];

        // FORM EDIT
        $dataFormEdit = [
            'data' => (ControllerHelper::ch_datas(['id'=>$id_data, 'table_single'=> $master_table])),
            
            'dataForm'=>[
                'formConfig' => [
                'title' => 'Edit Data '.$title, /*title page*/
                'route'=> $subRoute['update'], /*route backend*/
                'method'=> 'post', /* post for create, put/patch for update */
                'formInput' => $formConfig,
               ],
            ]
        ];

        /**
         * DATA FORM END
         */

        switch ($params) {
            case 'title':
                return $title;
                break;
            case 'mainRoute':
                return $mainRoute;
                break;
            case 'mainBuilder':
                return $mainBuilder;
                break;
            case 'subRoute':
                return $subRoute;
                break;
            case 'model':
                return $model;
                break;
            case 'table_req_query':
                return $table_req_query;
                break;
            case 'dataTable':
                return $dataTable;
                break;
            case 'dataTable':
                return $dataTable;
                break;
            case 'form_req_query':
                return $form_req_query;
                break;
            case 'dataFormAdd':
                return $dataFormAdd;
                break;
            case 'dataFormEdit':
                return $dataFormEdit;
                break;
            
            default:
                return 'no action found';
                break;
        }
        
        return($req);
        
    }

    public static function mapperProgramstudiesController($params = nul, $id_data = null){
        /**
         * DATAS CONFIG START
         */
        $title = 'Programstudies';
        $mainRoute = 'programstudies';
        $mainBuilder = 'builder';
        $subRoute = [];
        $model = 'Programstudies';
        $master_table = 'program_studies';
        

        $subRoute = [
           'index' => $mainBuilder . '.index',
            'table' => $mainRoute . '.table',
            'show' => $mainRoute . '.show',
            'create' => $mainRoute . '.create',
            'store' => '/' . $mainRoute . '-store', /* /route-store  */
            'edit' => $mainRoute . '-edit',
            'update' => '/'.$mainRoute . '-update',
            'destroy' => $mainRoute . '-destroy'
        ];
        /**
         * DATAS CONFIG END
         */


        /**
         * TABLE CONFIG START
         */
        
        //  Query ke database
        $table_req_query = [
            'table_master' => [
                'table_name' => $master_table,
                'alias' => 'a',
                'select'=>[
                    'a.*',
                ]
            ],
        ];

        
        // Table header
        $tableReq = [
            'type' => 'generate', /* generate/manual */
            'column_show' => '',
            'column_block' => [
                'created_at','updated_at','id',
            ],
        ];

        // Table value
        $dataTable = [
            'tableConfig' => [
                'idType'=>['alias'=>'No','type'=>'number'],/* number/alphabet */
                'columnMode'=>'manual',/* manual/auto */
                'columnCase'=>'camel',/* upper/lowercase/camel/pascal */
                'orderColumn' =>'id,asc', /* name column then asc or desc */
                'title' => $title, 
                'action' => [ 
                    'alias' => 'Aksi',
                    'feature' => [ /*feature = add,edit,delete */
                        // ['feature'=>'detail', 'alias'=> 'Detail', 'route'=>self::$subRoute['show'], 'icon'=>'bx-info-circle','disabled'=>'false','hide'=>'false'], 
                        ['feature'=>'edit', 'alias'=> 'Edit', 'route'=>$subRoute['edit'], 'icon'=>'bx-pencil','disabled'=>'false','hide'=>'false'], 
                        ['feature'=>'delete', 'alias'=> 'Hapus', 'route'=>$subRoute['destroy'], 'icon'=>'bx-trash','disabled'=>'false','hide'=>'false'], 
                        ['feature'=>'add', 'alias'=> 'Tambah', 'route'=>$subRoute['create'], 'icon'=>'','disabled'=>'false','hide'=>'false'], 
                    ]
                ]
            ],
            // 'data'=> self::table_view()
            'data'=> TableHelper::table_view($table_req_query, $tableReq)
        ];

        /**
         * TABLE CONFIG END
         */


        /**
         * DATA FORM START
        */
        $formConfig = [
            [
                'inputType'=>'TextInput',
                'dataType'=>'text',
                'alias'=>'Prodi Name',
                'state'=>'prodi_name',
                'required'=>'true',
                'note'=>'Gunakan nama yang singkat namun informatif',
            ],
            [
                'inputType'=>'textarea',
                'dataType'=>'text',
                'alias'=>'Description',
                'state'=>'description',
                'required'=>'true',
                'note'=>'Gunakan nama yang singkat namun informatif',
            ],
            // [
            //     'inputType'=>'dropdown',
            //     'dataType'=>'text',
            //     'alias'=>'Aktif',
            //     'state'=>'is_active',
            //     'required'=>'true',
            //     'note'=>'Gunakan nama yang singkat namun informatif',
            //     'data'=>FormHelper::dropdownInstantBool('is_active')
            // ],
            // ['inputType'=>'TextInput','dataType'=>'text','alias'=>'Nama Program Studi','state'=>'prodi_name','required'=>'true','note'=>'Gunakan nama yang singkat namun informatif','data'=>''],
            // ['inputType'=>'textarea','dataType'=>'text','alias'=>'Deskripsi','state'=>'description','required'=>'false','note'=>'','data'=>''],
        ];

        // FORM ADD
        $dataFormAdd = [
            'formConfig' => [
                'title' => 'Tambah '.$title.' Baru', /*title page*/
                'route'=> $subRoute['store'], /*route backend*/
                'formInput' => $formConfig
            ],
        ];

        // FORM EDIT
        $dataFormEdit = [
            'data' => (ControllerHelper::ch_datas(['id'=>$id_data, 'table_single'=> $master_table])),
            
            'dataForm'=>[
                'formConfig' => [
                'title' => 'Edit Data '.$title, /*title page*/
                'route'=> $subRoute['update'], /*route backend*/
                'method'=> 'post', /* post for create, put/patch for update */
                'formInput' => $formConfig,
               ],
            ]
        ];

        /**
         * DATA FORM END
         */

        switch ($params) {
            case 'title':
                return $title;
                break;
            case 'mainRoute':
                return $mainRoute;
                break;
            case 'mainBuilder':
                return $mainBuilder;
                break;
            case 'subRoute':
                return $subRoute;
                break;
            case 'model':
                return $model;
                break;
            case 'table_req_query':
                return $table_req_query;
                break;
            case 'dataTable':
                return $dataTable;
                break;
            case 'dataTable':
                return $dataTable;
                break;
            case 'form_req_query':
                return $form_req_query;
                break;
            case 'dataFormAdd':
                return $dataFormAdd;
                break;
            case 'dataFormEdit':
                return $dataFormEdit;
                break;
            
            default:
                return 'no action found';
                break;
        }
        
        return($req);
        
    }

    public static function mapperLecturerController($params = nul, $id_data = null){
        /**
         * DATAS CONFIG START
         */
        $title = 'Dosen';
        $mainRoute = 'lecturer';
        $mainBuilder = 'builder';
        $subRoute = [];
        $model = 'User';
        $master_table = 'users';

        $subRoute = [
           'index' => $mainBuilder . '.index',
            'table' => $mainRoute . '.table',
            'show' => $mainRoute . '.show',
            'create' => $mainRoute . '.create',
            'store' => '/' . $mainRoute . '-store', /* /route-store  */
            'edit' => $mainRoute . '-edit',
            'update' => '/'.$mainRoute . '-update',
            'destroy' => $mainRoute . '-destroy'
        ];
        /**
         * DATAS CONFIG END
         */


        /**
         * TABLE CONFIG START
         */
        
        //  Query ke database
        $table_req_query = [
            'table_master' => [
                'table_name' => $master_table,
                'alias' => 'a',
                'select'=>[
                    'a.*',
                ]
            ],
            'join' => [
                'program_studies'=>[
                    'join_type'=>'leftJoin',
                    'alias'=> 'b',
                    'on'=>'a.program_study_id = b.id',
                    'select'=> [
                        ['b.prodi_name']
                    ],
                ],
            ],
            'where_condition'=>[
                'equals' => [
                    ['a.role_id','=','3'],
                    ['a.status','=','1'],
                ]
            ]
        ];

        // Table header
        $tableReq = [
            'type' => 'generate', /* generate/manual */
            'column_show' => '',
            'column_block' => [
                'created_at','updated_at','id','password','program_study_id','remember_token','prodi_name'
            ],
        ];

        // Table value
        $dataTable = [
            'tableConfig' => [
                'idType'=>['alias'=>'No','type'=>'number'],/* number/alphabet */
                'columnMode'=>'manual',/* manual/auto */
                'columnCase'=>'camel',/* upper/lowercase/camel/pascal */
                'orderColumn' =>'id,asc', /* name column then asc or desc */
                'title' => $title, 
                'action' => [ 
                    'alias' => 'Aksi',
                    'feature' => [ /*feature = add,edit,delete */
                        // ['feature'=>'detail', 'alias'=> 'Detail', 'route'=>self::$subRoute['show'], 'icon'=>'bx-info-circle','disabled'=>'false','hide'=>'false'], 
                        ['feature'=>'edit', 'alias'=> 'Edit', 'route'=>$subRoute['edit'], 'icon'=>'bx-pencil','disabled'=>'false','hide'=>'false'], 
                        ['feature'=>'delete', 'alias'=> 'Hapus', 'route'=>$subRoute['destroy'], 'icon'=>'bx-trash','disabled'=>'false','hide'=>'false'], 
                        ['feature'=>'add', 'alias'=> 'Tambah', 'route'=>$subRoute['create'], 'icon'=>'','disabled'=>'false','hide'=>'false'], 
                    ]
                ]
            ],
            // 'data'=> self::table_view()
            'data'=> TableHelper::table_view($table_req_query, $tableReq)
        ];

        /**
         * TABLE CONFIG END
         */


        /**
         * DATA FORM START
        */
        $formConfig = [
            // [
            //     'inputType'=>'TextInput',
            //     'dataType'=>'text',
            //     'alias'=>'Prodi Name',
            //     'state'=>'prodi_name',
            //     'required'=>'true',
            //     'note'=>'Gunakan nama yang singkat namun informatif',
            // ],
            // [
            //     'inputType'=>'textarea',
            //     'dataType'=>'text',
            //     'alias'=>'Description',
            //     'state'=>'description',
            //     'required'=>'true',
            //     'note'=>'Gunakan nama yang singkat namun informatif',
            // ],
            // [
            //     'inputType'=>'dropdown',
            //     'dataType'=>'text',
            //     'alias'=>'Aktif',
            //     'state'=>'is_active',
            //     'required'=>'true',
            //     'note'=>'Gunakan nama yang singkat namun informatif',
            //     'data'=>FormHelper::dropdownInstantBool('is_active')
            // ],
            // ['inputType'=>'TextInput','dataType'=>'text','alias'=>'Nama Program Studi','state'=>'prodi_name','required'=>'true','note'=>'Gunakan nama yang singkat namun informatif','data'=>''],
            // ['inputType'=>'textarea','dataType'=>'text','alias'=>'Deskripsi','state'=>'description','required'=>'false','note'=>'','data'=>''],

            ['inputType'=>'TextInput','dataType'=>'text','alias'=>'Nama User','state'=>'name','required'=>'true','note'=>'Gunakan nama yang singkat namun informatif','data'=>''],
            ['inputType'=>'TextInput','dataType'=>'text','alias'=>'Email','state'=>'email','required'=>'true','note'=>'','data'=>''],
            ['inputType'=>'TextInput','dataType'=>'text','alias'=>'Password','state'=>'password','required'=>'true','note'=>'','data'=>''],
            [
                'inputType'=>'dropdown',
                'dataType'=>'text',
                'alias'=>'Status',
                'state'=>'status',
                'required'=>'true',
                'note'=>'',
                'data'=>FormHelper::dropdownInstantBool('status')
            ],
            ['inputType'=>'TextInput','dataType'=>'text','alias'=>'NIS','state'=>'nis','required'=>'true','note'=>'','data'=>FormHelper::dropdownInstantBool('is_active')],
            ['inputType'=>'dropdown',
                'dataType'=>'text',
                'alias'=>'Role Id',
                'state'=>'role_id',
                'required'=>'true',
                'note'=>'',
                'data'=> FormHelper::dropdownInstant('role_name','roles')
            ],
            [
                'inputType'=>'dropdown',
                'dataType'=>'number',
                'alias'=>'Program Studi',
                'state'=>'program_study_id',
                'required'=>'true',
                'note'=>'Gunakan nama yang singkat namun informatif',
                'data'=> FormHelper::dropdownInstant('prodi_name','program_studies')
            ],
        ];

        // FORM ADD
        $dataFormAdd = [
            'formConfig' => [
                'title' => 'Tambah '.$title.' Baru', /*title page*/
                'route'=> $subRoute['store'], /*route backend*/
                'formInput' => $formConfig
            ],
        ];

        // FORM EDIT
        $dataFormEdit = [
            'data' => (ControllerHelper::ch_datas(['id'=>$id_data, 'table_single'=> $master_table])),
            
            'dataForm'=>[
                'formConfig' => [
                'title' => 'Edit Data '.$title, /*title page*/
                'route'=> $subRoute['update'], /*route backend*/
                'method'=> 'post', /* post for create, put/patch for update */
                'formInput' => $formConfig,
               ],
            ]
        ];

        /**
         * DATA FORM END
         */

        switch ($params) {
            case 'title':
                return $title;
                break;
            case 'mainRoute':
                return $mainRoute;
                break;
            case 'mainBuilder':
                return $mainBuilder;
                break;
            case 'subRoute':
                return $subRoute;
                break;
            case 'model':
                return $model;
                break;
            case 'table_req_query':
                return $table_req_query;
                break;
            case 'dataTable':
                return $dataTable;
                break;
            case 'dataTable':
                return $dataTable;
                break;
            case 'form_req_query':
                return $form_req_query;
                break;
            case 'dataFormAdd':
                return $dataFormAdd;
                break;
            case 'dataFormEdit':
                return $dataFormEdit;
                break;
            
            default:
                return 'no action found';
                break;
        }
        
        return($req);
        
    }

    public static function mapperSubjectsController($params = nul, $id_data = null){
        /**
         * DATAS CONFIG START
         */
        $title = 'Mata Kuliah';
        $mainRoute = 'subject';
        $mainBuilder = 'builder';
        $subRoute = [];
        $model = 'Subject';
        $master_table = 'subjects';
        

        $subRoute = [
           'index' => $mainBuilder . '.index',
            'table' => $mainRoute . '.table',
            'show' => $mainRoute . '.show',
            'create' => $mainRoute . '.create',
            'store' => '/' . $mainRoute . '-store', /* /route-store  */
            'edit' => $mainRoute . '-edit',
            'update' => '/'.$mainRoute . '-update',
            'destroy' => $mainRoute . '-destroy'
        ];
        /**
         * DATAS CONFIG END
         */


        /**
         * TABLE CONFIG START
         */
        
        //  Query ke database
        $table_req_query = [
            'table_master' => [
                'table_name' => $master_table,
                'alias' => 'a',
                'select'=>[
                    'a.*',
                ]
            ],
            'join' => [
                'program_studies'=>[
                    'join_type'=>'leftJoin',
                    'alias'=> 'b',
                    'on'=>'a.program_study_id = b.id',
                    'select'=> [
                        ['b.prodi_name']
                    ],
                ],
            ],
            // 'where_condition'=>[
            //     'equals' => [
            //         ['a.role_id','=','3'],
            //         ['a.status','=','1'],
            //     ]
            // ]
        ];

        // Table header
        $tableReq = [
            'type' => 'generate', /* generate/manual */
            'column_show' => '',
            'column_block' => [
                'created_at','updated_at','id','password','program_study_id','remember_token','prodi_name'
            ],
        ];

        // Table value
        $dataTable = [
            'tableConfig' => [
                'idType'=>['alias'=>'No','type'=>'number'],/* number/alphabet */
                'columnMode'=>'manual',/* manual/auto */
                'columnCase'=>'camel',/* upper/lowercase/camel/pascal */
                'orderColumn' =>'id,asc', /* name column then asc or desc */
                'title' => $title, 
                'action' => [ 
                    'alias' => 'Aksi',
                    'feature' => [ /*feature = add,edit,delete */
                        // ['feature'=>'detail', 'alias'=> 'Detail', 'route'=>self::$subRoute['show'], 'icon'=>'bx-info-circle','disabled'=>'false','hide'=>'false'], 
                        ['feature'=>'edit', 'alias'=> 'Edit', 'route'=>$subRoute['edit'], 'icon'=>'bx-pencil','disabled'=>'false','hide'=>'false'], 
                        ['feature'=>'delete', 'alias'=> 'Hapus', 'route'=>$subRoute['destroy'], 'icon'=>'bx-trash','disabled'=>'false','hide'=>'false'], 
                        ['feature'=>'add', 'alias'=> 'Tambah', 'route'=>$subRoute['create'], 'icon'=>'','disabled'=>'false','hide'=>'false'], 
                    ]
                ]
            ],
            // 'data'=> self::table_view()
            'data'=> TableHelper::table_view($table_req_query, $tableReq)
        ];

        /**
         * TABLE CONFIG END
         */


        /**
         * DATA FORM START
        */
        $formConfig = [
            ['inputType'=>'TextInput','dataType'=>'text','alias'=>'Nama Mata Kuliah','state'=>'subject_name','required'=>'true','note'=>'Gunakan nama yang singkat namun informatif','data'=>''],
            ['inputType'=>'TextInput','dataType'=>'text','alias'=>'Kode','state'=>'code','required'=>'true','note'=>'Gunakan nama yang singkat namun informatif','data'=>''],
            ['inputType'=>'TextInput','dataType'=>'number','alias'=>'SKS','state'=>'sks','required'=>'true','note'=>'Gunakan nama yang singkat namun informatif','data'=>''],
            ['inputType'=>'TextInput','dataType'=>'number','alias'=>'Semester','state'=>'semester','required'=>'true','note'=>'Gunakan nama yang singkat namun informatif','data'=>''],
            [
                'inputType'=>'dropdown',
                'dataType'=>'number',
                'alias'=>'Program Studi',
                'state'=>'program_study_id',
                'required'=>'true',
                'note'=>'Gunakan nama yang singkat namun informatif',
                'data'=> FormHelper::dropdownInstant('prodi_name','program_studies')
            ],
            
        ];

        // FORM ADD
        $dataFormAdd = [
            'formConfig' => [
                'title' => 'Tambah '.$title.' Baru', /*title page*/
                'route'=> $subRoute['store'], /*route backend*/
                'formInput' => $formConfig
            ],
        ];

        // FORM EDIT
        $dataFormEdit = [
            'data' => (ControllerHelper::ch_datas(['id'=>$id_data, 'table_single'=> $master_table])),
            
            'dataForm'=>[
                'formConfig' => [
                'title' => 'Edit Data '.$title, /*title page*/
                'route'=> $subRoute['update'], /*route backend*/
                'method'=> 'post', /* post for create, put/patch for update */
                'formInput' => $formConfig,
               ],
            ]
        ];

        /**
         * DATA FORM END
         */

        switch ($params) {
            case 'title':
                return $title;
                break;
            case 'mainRoute':
                return $mainRoute;
                break;
            case 'mainBuilder':
                return $mainBuilder;
                break;
            case 'subRoute':
                return $subRoute;
                break;
            case 'model':
                return $model;
                break;
            case 'table_req_query':
                return $table_req_query;
                break;
            case 'dataTable':
                return $dataTable;
                break;
            case 'dataTable':
                return $dataTable;
                break;
            case 'form_req_query':
                return $form_req_query;
                break;
            case 'dataFormAdd':
                return $dataFormAdd;
                break;
            case 'dataFormEdit':
                return $dataFormEdit;
                break;
            
            default:
                return 'no action found';
                break;
        }
        
        return($req);
        
    }

    public static function mapperDashboardController($params = nul, $id_data = null){
        /**
         * DATAS CONFIG START
         */
        $title = 'Jadwal Perkuliahan';
        $mainRoute = 'schedule';
        $mainBuilder = 'builder';
        $subRoute = [];
        $model = 'Schedule';
        $table_name = 'schedules';

        $subRoute = [
            'index' => $mainBuilder . '.index',
            'table' => $mainRoute . '.table',
            'show' => $mainRoute . '.show',
            'create' => $mainRoute . '.create',
            'store' => '/' . $mainRoute . '-store', /* /route-store  */
            'edit' => $mainRoute . '-edit',
            'update' => '/'.$mainRoute . '-update',
            'destroy' => $mainRoute . '-destroy'
        ];
        /**
         * DATAS CONFIG END
         */


        /**
         * TABLE CONFIG START
         */
        
        //  Query ke database
        $table_req_query = [
            'table_master' => [
                'table_name' => $table_name,
                'alias' => 'a',
                'select'=>[
                    'a.*',
                    'a.start_time as jam_mulai',
                    'a.end_time as jam_berakhir',
                    ['IF(a.status = 0,"Non Active","Active") as status','raw()']
                ]
            ],
            'join' => [
                'classes'=>[
                    'join_type'=>'leftJoin',
                    'alias'=> 'b',
                    'on'=>'a.class_id = b.id',
                    'select'=> [
                        ['b.class_name']
                    ],
                ],
                'rooms'=>[
                    'join_type'=>'leftJoin',
                    'alias'=> 'c',
                    'on'=>'a.room_id = c.id',
                    'select'=> [
                        ['c.room_name']
                    ],
                ],
                'subjects'=>[
                    'join_type'=>'leftJoin',
                    'alias'=> 'd',
                    'on'=>'a.subject_id = d.id',
                    'select'=> [
                        ['d.subject_name']
                    ],
                ],
                'users'=>[
                    'join_type'=>'leftJoin',
                    'alias'=> 'e',
                    'on'=>'a.user_id = e.id',
                    'select'=> [
                        ['e.name as dosen']
                    ],
                ],
                'hari'=>[
                    'join_type'=>'leftJoin',
                    'alias'=> 'f',
                    'on'=>'a.day = f.id',
                    'select'=> [
                        ['f.day_name as hari']
                    ],
                ],
            ],
            // 'where_condition' => [
            //     "equals" => [
            //         // ['f.day_english','=', date('l')],
            //         ['d.program_study_id','=', Auth()->user()->program_study_id],
            //     ],
            // ],
        ];

        if(Auth()->user()->role_id == 5){

            $table_req_query['where_condition'] = [
                "equals" => [
                    ['d.program_study_id','=', Auth()->user()->program_study_id],
                ],
            ];
        }

        // Table header
        $tableReq = [
            'type' => 'generate', /* generate/manual */
            'column_show' => '',
            'column_block' => [
                'start_time','end_time','created_at','updated_at','class_id','room_id','subject_id','id','user_id','day','status','id'
            ],
        ];

        // Table value
        $dataTable = [
            'tableConfig' => [
                // 'idType'=>['alias'=>'No','type'=>'number'],/* number/alphabet */
                'columnMode'=>'manual',/* manual/auto */
                'columnCase'=>'camel',/* upper/lowercase/camel/pascal */
                'orderColumn' =>'id,asc', /* name column then asc or desc */
                'title' => $title, 
                'action' => [ 
                    'alias' => '',
                    'feature' => [ /*feature = add,edit,delete */
                        // ['feature'=>'detail', 'alias'=> 'Detail', 'route'=>self::$subRoute['show'], 'icon'=>'bx-info-circle','disabled'=>'false','hide'=>'false'], 
                        // ['feature'=>'edit', 'alias'=> 'Edit', 'route'=>$subRoute['edit'], 'icon'=>'bx-pencil','disabled'=>'false','hide'=>'false'], 
                        // ['feature'=>'delete', 'alias'=> 'Hapus', 'route'=>$subRoute['destroy'], 'icon'=>'bx-trash','disabled'=>'false','hide'=>'false'], 
                        // ['feature'=>'add', 'alias'=> 'Tambah', 'route'=>$subRoute['create'], 'icon'=>'','disabled'=>'false','hide'=>'false'], 
                    ]
                ]
            ],
            // 'data'=> self::table_view()
            'data'=> TableHelper::table_view($table_req_query, $tableReq)
        ];

        /**
         * TABLE CONFIG END
         */


        $formConfig = [
            [
                'inputType'=>'time',
                'dataType'=>'time',
                'alias'=>'Start Time',
                'state'=>'start_time',
                'required'=>'true',
                'note'=>'Gunakan nama yang singkat namun informatif',
            ],
            [
                'inputType'=>'time',
                'dataType'=>'time',
                'alias'=>'End Time',
                'state'=>'end_time',
                'required'=>'true',
                'note'=>'Gunakan nama yang singkat namun informatif',
            ],
            [
                'inputType'=>'dropdown',
                'dataType'=>'number',
                'alias'=>'Hari',
                'state'=>'day',
                'required'=>'true',
                'note'=>'Gunakan nama yang singkat namun informatif',
                // 'data'=>$data_day
                'data'=> FormHelper::dropdownInstant('day_name','hari')
            ],
            [
                'inputType'=>'dropdown',
                'dataType'=>'number',
                'alias'=>'Matakuliah',
                'state'=>'subject_id',
                'required'=>'true',
                'note'=>'Gunakan nama yang singkat namun informatif',
                // 'data'=>$data_subject
                'data'=> FormHelper::dropdownInstant('subject_name','subjects')
            ],
            [
                'inputType'=>'dropdown',
                'dataType'=>'text',
                'alias'=>'Room',
                'state'=>'room_id',
                'required'=>'true',
                'note'=>'Gunakan nama yang singkat namun informatif',
                'data'=> FormHelper::dropdownInstant('room_name','rooms',['is_active',1])
            ],
            [
                'inputType'=>'dropdown',
                'dataType'=>'text',
                'alias'=>'Nama Kelas',
                'required'=>'true',
                'note'=>'Gunakan nama yang singkat namun informatif',
                'state'=>'class_id',
                'data'=>FormHelper::dropdownInstant('class_name','classes')
            ],
            [
                'inputType'=>'dropdown',
                'dataType'=>'text',
                'alias'=>'Nama User',
                'required'=>'true',
                'note'=>'Gunakan nama yang singkat namun informatif',
                'state'=>'user_id',
                'data'=>FormHelper::dropdownInstant('name','users')
            ],
        ];

        // FORM ADD
        $dataFormAdd = [
            'formConfig' => [
                'title' => 'Tambah '.$title.' Baru', /*title page*/
                'route'=> $subRoute['store'], /*route backend*/
                'formInput' => $formConfig
            ],
        ];

        // FORM EDIT
        $dataFormEdit = [
            'data' => (ControllerHelper::ch_datas(['id'=>$id_data, 'table_single'=>'schedules'])),
            
            'dataForm'=>[
                'formConfig' => [
                'title' => 'Edit Data '.$title, /*title page*/
                'route'=> $subRoute['update'], /*route backend*/
                'method'=> 'post', /* post for create, put/patch for update */
                'formInput' => $formConfig,
               ],
            ]
        ];

        /**
         * DATA FORM END
         */

        switch ($params) {
            case 'title':
                return $title;
                break;
            case 'mainRoute':
                return $mainRoute;
                break;
            case 'mainBuilder':
                return $mainBuilder;
                break;
            case 'subRoute':
                return $subRoute;
                break;
            case 'model':
                return $model;
                break;
            case 'table_req_query':
                return $table_req_query;
                break;
            case 'dataTable':
                return $dataTable;
                break;
            case 'dataTable':
                return $dataTable;
                break;
            case 'form_req_query':
                return $form_req_query;
                break;
            case 'dataFormAdd':
                return $dataFormAdd;
                break;
            case 'dataFormEdit':
                return $dataFormEdit;
                break;
            
            default:
                return 'no action found';
                break;
        }
        
        return($req);
        
    }
    
}

?>