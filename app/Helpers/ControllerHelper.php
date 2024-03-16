<?php
namespace App\Helpers;
use Illuminate\Support\Facades\DB;

class ControllerHelper{

     /**
     * Function to get all data and spesific data.
     * F-GetAllDatas
     * F-GetDataById
     */
    public static function ch_datas($config){
        try {
            $model_name = '\\App\\Models\\'.$config['model'];
            $model = new $model_name;
            if(isset($config['join']) && (!isset($config['id']) || $config['id']==null || $config['id']=='' )){

                $join = $config['join'];
                $table_master = $config['table_master'];
                $select_master =     $table_master.".*";
                $select_joins = '';

                foreach($join as $join_type => $data){
                    $tables = $config['join'][$join_type];
                    $db =  DB::table($table_master);
                        $num_alias = 0;
                        $db->select($select_master);

                        foreach($tables as $table => $columns){
                            $num_alias++;
                            $column_join = $columns[0];
                            $column_master = $columns[1];
                            $column_join_select = $columns[2];
                            $table_join = $table.' as a'.$num_alias;
                            $column_relation_1 = 'a'.$num_alias.'.'.$column_join;
                            $column_relation_2 = $table_master.'.'.$column_master;
                            $select_join = 'a'.$num_alias.'.'.$column_join_select;
                            
                            $db->$join_type($table_join,$column_relation_1,'=',$column_relation_2 );
                            $select_joins .= ", '".$select_join."'";

                            $db->addselect($select_join);
                        }
                        $result = $db->paginate(5);
                    }
                $data = $result;
                $status = true;
                $message = count($result).' Datas Found!';
                $statusCode = 200;
            }else if(!isset($config['id']) || $config['id']==null || $config['id']==''){
                $data = $model->paginate(5);
                $status = true;
                $message = count($data).' Datas Found!';
                $statusCode = 200;
            }else if(isset($config['id']) && $config['id'] != null && $config['id'] != ''){
                $status = true;
                $data = $model->find($config['id']);
                $message = '1 Data Found!';
                $statusCode = 200;
            }else{
                $status = false;
                $message = 'Data Not Found!';
                $data = null;
                $statusCode = 404;
            }
        } catch (\Throwable $th) {
            $status = false;
            $message = 'Failed!';
            $statusCode = 500;
            $data = $th->getMessage();
        }

            return response()->json([
                'message' => $message,
                'status' => $status,
                'data'=> $data
            ],$statusCode);    
    }
     /**
     * Function to get all data and spesific data.
     * F-GetDatas For Selection Dropdown
     */
    public static function ch_datas_selection($config){
        $models=[];
        $data=array();
        try {
            if(isset($config['model_selection']) && $config['model_selection'] != null && $config['model_selection'] != ''){
                $model_selection = $config['model_selection'];
                foreach ($model_selection as $model_name => $model_select) {
                    $model_initiate = '\\App\\Models\\'.$model_name;
                    $model = new $model_initiate;
                    $model = $model->select($model_select)->get();
                    $data_select=[$model_name=>$model];
                    array_push($data,$data_select);
                }
                $status = true;
                $message = 'Datas Found!';
                $statusCode = 200;
            }else{
                $status = false;
                $message = 'Data Not Found!';
                $data = null;
                $statusCode = 404;
            }
        } catch (\Throwable $th) {
            $status = false;
            $message = 'Failed!';
            $statusCode = 500;
            $data = $th->getMessage();
        }

            return response()->json([
                'message' => $message,
                'status' => $status,
                'data'=> $data
            ],$statusCode);    
    }

     /**
     * Function to store and update request.
     * F-Store
     * F-Update
     */
    public static function ch_insert($config){
        try {
        
            $model_name = '\\App\\Models\\'.$config['model'];
            $model = new $model_name;
            
            if(!isset($config['id']) || $config['id']==null || $config['id']==''){
                $data = $model::create($config['request']);
                $message = 'Success Insert Data!';
            }else if(isset($config['id']) && $config['id'] != null && $config['id'] != ''){
                $find = $model->find($config['id']);
                $data = $find->update($config['request']);
                $message = 'Success Update Data!';
            }else{
                $data = false;
            }

            if($data){
                $status = true;
                $data = $config['request'];
                $statusCode = 200;
            }else{
                $status = false;
                $data = null;
                $statusCode = 500;
            }

        } catch (\Throwable $th) {
            $status = false;
            $message = 'Failed!';
            $statusCode = 500;
            $data = $th->getMessage();
        }

        return response()->json([
            'message' => $message,
            'status' => $status,
            'data'=> $data
        ],$statusCode);    
    }

     /**
     * Function to delete.
     * F-Destroy
     */
    public static function ch_destroy($config){
        $status = false;
        $data = null;
        $statusCode = 0;
        $message = '';

        try {
        
            $model_name = '\\App\\Models\\'.$config['model'];
            $model = new $model_name;
            if(isset($config['id']) || $config['id']!=null || $config['id']!=''){
                $find = $model->find($config['id']);
                if($find){
                        if(!isset($config['type']) || $config['type']==null || $config['type']==''){
                            // SOFT DELETE
                            $data = $find->delete();
                            $message = 'Success Delete Data!';
                        }else if(isset($config['type']) && $config['type'] != null && $config['type'] != ''){
                            // HARD DELETE
                            $data = $find->delete();
                            $message = 'Success Permanently Delete Data!';
                        }else{
                            $message = 'Param Failed!';
                            $data = false;
                        }
                    }else{
                        $message = 'Data Not Found!';
                        $data = false;
                    }
                }else if(!isset($config['id']) || $config['id']==null || $config['id']==''){
                    $message = 'No Params Found!';
                    $data = false;
                }else{
                    $message = 'Param Failed!';
                    $data = false;
                }

            if($data){
                $status = true;
                $data = $config['id'];
                $statusCode = 200;
            }else{
                $status = false;
                $data = null;
                $statusCode = 500;
                $message = 'Failed Delete Data!!';
            }

        } catch (\Throwable $th) {
            $status = false;
            $message = 'Failed!';
            $statusCode = 500;
            $data = $th->getMessage();
        }

        return response()->json([
            'message' => $message,
            'status' => $status,
            'data'=> $data
        ],$statusCode);    
    }
}
?>
