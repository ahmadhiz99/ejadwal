<?php
namespace App\Helpers;

    class DBHelper {
        public function request_helper ($params = null){
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
        }
    }
?>