<?php
namespace App\Helpers;
class TableHelper {

    public static function purgeConfig(){
        $configTemp = Self::configController();
        $config = [];
        $config = $configTemp;
    }

     public static function configController($params = null){
        $config = [
            'model'=>'Room'
        ];

        if($params != null){
            $config = array_merge($config, $params);
        }
        
        return $config;
    }

    /**
     * TABLE CONFIGS DATA
     */
    public static function table_view($req = null, $tableReq = null){
        Self::purgeConfig();

        // $config = Self::configController($req);
        $dataTable = (ControllerHelper::ch_datas($req));

        return self::generate_table_view($tableReq, $dataTable);
       
    }

    /**
     * MANUAL TABLE 
     */
     public static function table_view_manual() {
        $data = [
                    ['column' => 'room_name', 'alias' => 'Nama Ruangan', 'data' => '', 'className'=>''],
                    ['column' => 'description', 'alias' => 'Deskripsi', 'data' => '', 'className'=>''],
                    ['column' => 'created_at', 'alias' => 'Created At', 'data' => '', 'className'=>''],
                    ['column' => 'is_active', 'alias' => 'Aktive', 'data' => '', 'className'=>''],
                ];
        return $data;
    }

    /**
     * GENERATE TABLE
     */
    public static function generate_table_view($tableReq, $dataTable){
        if($tableReq['type'] == 'generate'){
            $data=[];
            $dataColumn=[];
            $dataForm = $dataTable[0];
            // dd($dataForm);
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

?>
