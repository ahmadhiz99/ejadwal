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
        $table_req_query = [
            'table_master' => [
                'table_name' => $table_name,
                'alias' => 'a',
                'select'=>[
                    'a.*',
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
            ],
        ];

        
        // Table header
        $tableReq = [
            'type' => 'generate', /* generate/manual */
            'column_show' => '',
            'column_block' => [
                'created_at','updated_at','class_id','room_id','subject_id','id'
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

        // $MAIN_PAGE = [
        //     // ROUTES
        //     ['ROUTES']       => $mainRoute,
        //     ['SUB_ROUTES']   => $subRoute,
        //     ['MODEL']        => $model,
        //     ['FORM']         => [
        //                             'GENERATE'  => ['auto',null], 
        //                             'DROPDOWN'  => ['auto',null],
        //                             'CHECKBOX'  => ['auto',null],
        //                         ],
        //     ['TABLE'] => [
        //         'GENERATE'  => ['auto',null],
        //         'HEADER'    => ['auto',null], /* auto || hybrid || manual */
        //         'VALUE'     => ['auto',null],
        //     ],
        //     ['FEATURE'] => [
        //         'ADD' => ['auto',null],
        //         'EDIT' => ['auto',null],
        //         'DETAIL' => ['auto',null],
        //         'DELETE' => ['auto',null],
        //     ]
        // ];

        // $TABLE_CONFIG = [
        //     'GENERATE_DROPDOWN' => [
                
        //     ],
        //     'GENERATE_',

        // ];

        // $FORM_CONFIG = [

        // ];

        // GeneratePages::_initial($MAIN_PAGE)
        //         ->table(manual,$TABLE_CONFIG)
                
        // GeneratePages::_initial($MAIN_PAGE)
        //         ->form(manual,$FORM_CONFIG)

        // DBHelper::get_generate('schedules')
        
        // DBHelper::getDropdown('schedules')
        //     ->key('id')
        //     ->select(['id','name'])
        //     ->where()
        //     ->get();

        // DBHelper::get_table('schedules')
        //     ->key('id')
        //     ->select(['id','name'])
        //     ->where()
        //     ->get();

        $formConfig = [
            [
                'inputType'=>'date',
                'dataType'=>'date',
                'alias'=>'Start Date',
                'state'=>'start_date',
                'required'=>'true',
                'note'=>'Gunakan nama yang singkat namun informatif',
            ],
            [
                'inputType'=>'date',
                'dataType'=>'date',
                'alias'=>'End Date',
                'state'=>'end_date',
                'required'=>'true',
                'note'=>'Gunakan nama yang singkat namun informatif',
            ],
            [
                'inputType'=>'dropdown',
                'dataType'=>'number',
                'alias'=>'subject Name',
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

    
    /**
     * tx_menu()
     * Transaction Menu
     */
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

}

?>