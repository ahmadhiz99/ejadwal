<?php
namespace App\Helpers;
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
            if(!isset($config['id']) || $config['id']==null || $config['id']==''){
                $data = $model->all();
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
