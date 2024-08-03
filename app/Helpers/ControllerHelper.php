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

            DB::enableQueryLog();
            $db;
            $model_name;
            $Model;

            // JIKA MENGGUNAKAN MODEL MAKA AKAN MENGGUNAKAN FUNGSI ORM MODEL
            if(isset($config['model'])){
                $model_name = '\\App\\Models\\'.$config['model'];
                $model = new $model_name;
            }

            // JIKA MENGGUNAKAN TABLE MAKA AKAN NATIVE DARI TABLE
            if(isset($config['table_master'])){ // USING TABLE MASTER
                $table_master = $config['table_master'];
                if(isset($table_master['table_name']) && isset($table_master['alias'])){
                    $db =  DB::table($table_master['table_name'].' as '.$table_master['alias']);
                }else{
                    $db =  DB::table($table_master);
                }
                if(is_array($table_master['select'])){     // USING SELECT
                    foreach($table_master['select'] as $val){
                        if($val[1] == 'raw()'){
                            $db->addSelect(DB::raw($val[0]));
                        }else{
                            $db->addselect($val);
                        }
                    }
                }else{
                    $db->select($table_master['select']);
                }
                $model = $db;
            }

            if(isset($config['join']) ){ // USING JOIN
                $join = $config['join'];
                
                if(isset($join)){
                    $table_master = $config['table_master'];
                    $db =  DB::table($table_master['table_name'].' as '.$table_master['alias']);
                    // $db->select($table_master['select']);
                    if(is_array($table_master['select'])){     // USING SELECT
                        foreach($table_master['select'] as $val){
                            if($val[1] == 'raw()'){
                                $db->addSelect(DB::raw($val[0]));
                            }else{
                                $db->addselect($val);
                            }
                        }
                    }else{
                        $db->select($table_master['select']);
                    }
                }
                       
                    foreach($join as $table => $tableConfig){
                            $table_join = $table;
                            $join_type = $tableConfig['join_type'];
                            $alias = $table.' as '.$tableConfig['alias'];

                            $on = explode(" ",$tableConfig['on']);
                            $db->$join_type($alias,$on[0],$on[1],$on[2]);

                            if(is_array($tableConfig['select'])){
                                foreach($tableConfig['select'] as $val){
                                    $db->addselect($val);
                                }
                            }else{
                                $db->addselect($val);
                            }
                            $model = $db;
                    }
                }

         
            if(isset($config['where_condition'])){
                if(!isset($config['join'])){
                    $db = $model;
                }


                $condition = $config['where_condition'];
                // dd($condition);
                foreach($condition as $key => $conds){
                    // Equals Condition
                    if($key == 'equals'){
                        foreach($conds as $item){
                            $model = $db->where($item[0],$item[1],$item[2]);
                        }
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
                }
            }

           
            if(isset($config['paginate'])){
                $model = $model->paginate($config['paginate']);
            }else{
            
               if(isset($config['table_single'])){
                $db  =  DB::table($config['table_single']);
                if(isset($config['id'])){
                     $model = $db->find($config['id']);
                }else{
                    $model = json_decode($db->get());
                }
               }else{
                
                if(isset($config['id']) && $config['id'] != null && $config['id'] != ''){
                    if(isset($config['table_master'])){
                        $model = $db->where($config['id']);
                    }else if(isset($config['model'])){
                        $model = $model->find($config['id']);
                    }else{
                        $model = $model->find($config['id']);
                    }

                }else{
                    $model = json_decode($model->get());
                }
              }
                
            }
            
            $data = $model;
            // dd(DB::getQueryLog());

        } catch (\Throwable $th) {
            // $status = false;
            // $message = 'Failed!';
            // $statusCode = 500;
            $data = $th->getMessage();
        }

        return $data;
        
            // return response()->json([
            //     'message' => $message,
            //     'status' => $status,
            //     'data'=> $data
            // ],$statusCode);    
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

        return $data;
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
            
            
            if(isset($config['reference_table']) && $config['reference_table']!=null && $config['reference_table']!=''){
                $tables = $config['reference_table'];
                $data_reference;
                $idx= 0;
                foreach($tables as $key => $value){
                    $model = DB::table($key);

                    if(!isset($config['id']) || $config['id']==null || $config['id']==''){
                        if($idx == 0){
                            $idx = $model->insertGetId($value[1]);
                        }else{
                            $data_merge = array_merge($value[1],[ $value[0] =>$idx]);
                            // dd($data_merge);
                            $data = $model->insert($data_merge);
                        }
                        $message = 'Success Insert Data!';
                    }else if(isset($config['id']) && $config['id'] != null && $config['id'] != ''){
                        $find = $model->where('id',$config['id']);
                        $data = $find->update($value[1]);
                        // $idx = $data[$value[0]];
                        $message = 'Success Update Data!';
                    }else{
                        $data = false;
                    }
                }
            }else if(isset($config['multiple_table']) && $config['multiple_table']!=null && $config['multiple_table']!=''){
                $tables = $config['multiple_table'];
                $data_reference;
                $idx= 0;
                foreach($tables as $key => $value){
                    $model = DB::table($key);
                    if(!isset($config['id']) || $config['id']==null || $config['id']==''){
                        $idx = $model->insert($value);
                        $data = $idx;
                        $message = 'Success Insert Data!';
                    }else if(isset($config['id']) && $config['id'] != null && $config['id'] != ''){
                        $find = $model->find($config['id']);
                        $data = $find->update($value);
                        $message = 'Success Update Data!';
                    }else{
                        $data = false;
                    }
                }
            }else{
                
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
            }

            if($data){
                $status = true;
                $data = 'Successfully';
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
