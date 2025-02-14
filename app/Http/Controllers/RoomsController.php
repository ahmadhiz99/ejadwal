<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;
use App\Helpers\ControllerHelper;
use App\Helpers\MapperHelper;
use App\Helpers\TableHelper;

class RoomsController extends Controller
{
    
    function purgeConfig(){
        $configTemp = Self::configController();
        $config = [];
        $config = $configTemp;
    }

     function configController($params = null){
        $config = [
            'model'=> MapperHelper::rooms('model')
        ];

        if($params != null){
            $config = array_merge($config, $params);
        }
        
        return $config;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $req = [
            'id'=>null
        ];

        $config = Self::configController($req);

        return ControllerHelper::ch_datas($config);
    }

    public function table(){
        // Get Mapping Tabl
        $req = MapperHelper::rooms('table_req_query');
        $config = Self::configController($req);
        $dataResult = ControllerHelper::ch_datas($config);

        $dataTable = MapperHelper::rooms('dataTable');
        $data = ['data'=>$dataResult,'dataTable'=>$dataTable];
        session()->put("SessTableData", $data);
        return redirect('/builder/table');

        /**
         * 
         */
        $req = MapperHelper::rooms();
        $data = GeneratePages::_initial($MAIN_PAGE)
                ->table(manual,$TABLE_CONFIG);

        session()->put("SessTableData", $data);
        return redirect('/builder/table');
        
     }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // CALL FORM
        $dataForm = MapperHelper::rooms('dataFormAdd');

        $data = ['dataForm'=>$dataForm];
        session()->put("SessFormData", $data);
        return redirect('/builder/table/add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
    //    GET VALIDATOR FROM FORM HELPER
        $validator = Validator::make($request->all(), [
            'room_name' => 'required',
            'is_active' => 'required',
            'description' => 'required',
        ]);

        $req = [
            'id'=>null,
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
    public function edit(Request $request, $id)
    {
        $dataForm = MapperHelper::rooms('dataFormEdit',$id);

        session()->put("SessFormData", $dataForm);
        return redirect('/builder/table/edit');// Variable has to come from here
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            // 'start_date' => 'required',
            // 'end_date' => 'required',
            // 'status' => 'required',
            // 'class_id' => 'required',
            // 'room_id' => 'required',
            // 'subject_id' => 'required',
            // 'user_id' => 'required'
        ]);
        Self::purgeConfig();

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
