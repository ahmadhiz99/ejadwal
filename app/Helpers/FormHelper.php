<?php
namespace App\Helpers;

class FormHelper {
    
    public static function purgeConfig(){
        $configTemp = Self::configController();
        $config = [];
        $config = $configTemp;
    }

     public static function configController($params = null){
        $config = [
            'model'=>'Schedule'
        ];

        if($params != null){
            $config = array_merge($config, $params);
        }
        
        return $config;
    }

    /**
     * Validator
     */
    function get_validator(){
        return [
            // 'menu_id' => 'required',
            'role_id' => 'required',
            'is_active' => 'required'
        ];
    }

    /**
     * Form View
     */
    public static function form_view($params = null) {
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
    
}

?>
