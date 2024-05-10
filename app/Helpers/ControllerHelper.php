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
            $db;
            $model_name = '\\App\\Models\\'.$config['model'];
            $model = new $model_name;

            if(isset($config['join']) && (!isset($config['id']) || $config['id']==null || $config['id']=='' )){
                $join = $config['join'];
                $table_master = $config['table_master'];

                $db =  DB::table($table_master['table_name'].' as '.$table_master['alias']);
                $db->select($table_master['select']);

                foreach($join as $table => $tableConfig){
                        $table_join = $table;
                        $join_type = $tableConfig['join_type'];
                        $alias = $table.' as '.$tableConfig['alias'];

                        $on = explode(" ",$tableConfig['on']);
                        $db->$join_type($alias,$on[0],$on[1],$on[2]);

                        $db->addselect($tableConfig['select']);
                        $result = $db->get();
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

            if(isset($config['where_condition'])){
                if(!isset($config['join'])){
                    $db = $model;
                }
                $condition = $config['where_condition'];
                foreach($condition as $key => $conds){
                     // Equals Condition
                    if($key == 'equals'){
                        $model = $db->where($conds);
                    }
                    // Where In Condition
                    if($key == 'in'){
                        $model = $db->wherein($conds['column'],$conds['value']);
                    }
                    // Where Not In Condition
                    if($key == 'not_in'){
                        $model = $db->whereNotIn($conds['column'],$conds['value']);
                    }
                    // Group By Condition
                    if($key == 'group_by'){
                        $model = $db->groupBy($conds['column']);
                    }
                    // Order By Condition
                    if($key == 'order_by'){
                        $model = $db->orderBy($conds['column'],$conds['value']);
                    }
                    // Paginate Condition
                    if($key == 'paginate'){
                        $model = $db->paginate($conds['value']);
                    }
                    // $data = $model->orderBy('name','ASC')->paginate(5);
                    $data = $model;
                }
                
               
                $status = true;
                $message = count($data).' Datas Found!';
                $statusCode = 200;
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
