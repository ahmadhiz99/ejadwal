<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;
use App\Helpers\ControllerHelper;


class SubjectsController extends Controller
{
     function configController($params = null){
        $config = [
            'model'=>'Subject'
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

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return response()->json([
            'message' => 'true',
            'data'=> []
        ],200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
       
        // $data = $request->all();
        // $role = new Role;

        $validator = Validator::make($request->all(), [
            'code' => 'required',
            'subject_name' => 'required',
            'sks' => 'required',
            'semester' => 'required',
            'program_study_id' => 'required'
        ]);

        $req = [
            'id'=>null,
            'request'=> $request->all()
        ];

        if($validator->fails()){
            return response()->json([
                'message' => 'Store Role Failed!',
                'status' => 'false',
                'data'=> [$validator->messages()]
            ],400);
        }else{
            $config = Self::configController($req);
            return ControllerHelper::ch_insert($config);
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
    public function edit(Request $request)
    {
        //
        $role = Role::find($request);

        try {
          
            if(count($role)>0){
                // return Inertia::render('Profile/Edit');
                return response()->json([
                    'message' => 'Data Exist!',
                    'status' => 'true',
                    'data'=> [$role]
                ],200);
            }else{
                return response()->json([
                    'message' => 'Data Empty!',
                    'status' => 'true',
                    'data'=> [$role]
                ],200);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Failed',
                'status' => 'false',
                'data'=> $th->getMessage()
            ],500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required',
            'subject_name' => 'required',
            'sks' => 'required',
            'semester' => 'required',
            'program_study_id' => 'required'
        ]);

        $req = [
            'id'=>$id,
            'request'=> $request->all()
        ];

        if($validator->fails()){
            return response()->json([
                'message' => 'Store Role Failed!',
                'status' => 'false',
                'data'=> [$validator->messages()]
            ],400);
        }else{
            $config = Self::configController($req);
            return ControllerHelper::ch_insert($config);
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
        return ControllerHelper::ch_destroy($config);
    }
}
