<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;
use App\Helpers\ControllerHelper;
use App\Helpers\MapperHelper;
use App\Helpers\TableHelper;

class SchedulesController extends Controller
{
    // function __construct(){
    //     $main_config = MapperHelper::get('SchedulesController');
    // }
    
    function purgeConfig(){
        $configTemp = Self::configController();
        $config = [];
        $config = $configTemp;
    }

     function configController($params = null){
        $config = [
            'model'=>'Schedule'
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
        // Get Mapping Tablw
        $req = MapperHelper::schedules('table_req_query');
        $req = MapperHelper::schedules('table_req_query');
        $config = Self::configController($req);
        $dataResult = ControllerHelper::ch_datas($config);

        $dataTable = MapperHelper::schedules('dataTable');
        $data = ['data'=>$dataResult,'dataTable'=>$dataTable];
        session()->put("SessTableData", $data);
        return redirect('/builder/table');

        /**
         * 
         */
        $req = MapperHelper::schedules();
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
        $dataForm = MapperHelper::schedules('dataFormAdd');

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
            'start_time' => 'required',
            'end_time' => 'required',
            'class_id' => 'required',
            'room_id' => 'required',
            'subject_id' => 'required',
            'day' => 'required',
            // 'user_id' => 'required'
            // 'status' => 'required',
        ]);
        
        $class = $request->class_id;
        $day = $request->day;
        $room = $request->room_id;
        $start_time = $request->start_time;
        $end_time = $request->end_time;
        // $request->status = 1;

        if(!$request->has('user_id') || $request->user_id == null){
            $request->merge(['user_id' => Auth()->user()->id]);
        }
        
        $req = [
            'id'=>null,
            'request'=> $request->all()
        ];
        
        if($start_time && $end_time){
            $dataScehdule = Schedule::where('class_id','=',$class)
                                    ->where('day','=', $day)
                                    ->where('room_id','=',$room)
                                    ->where('end_time','>',$start_time)
                                    ->where('start_time','<',$end_time)
                                    ->count();
        }

        if($validator->fails()){
            return back()->withErrors($validator)
            ->withInput();
        }else if($dataScehdule > 0){
            return back()->withErrors([
                'message' => 'Terdapat jadwal lain di jam ini. Silakan coba lagi!',
            ])->withInput();
        }
        else{
            $config = Self::configController($req);
            if(ControllerHelper::ch_insert($config)){
                return self::table();
            }
            return 'Failed';        
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
        $dataForm = MapperHelper::schedules('dataFormEdit',$id);

        session()->put("SessFormData", $dataForm);
        return redirect('/builder/table/edit');// Variable has to come from here
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            // 'start_time' => 'required',
            // 'end_time' => 'required',
            // 'class_id' => 'required',
            // 'room_id' => 'required',
            // 'subject_id' => 'required',
            // 'day' => 'required',
        ]);

        Self::purgeConfig();

        // $class = $request->class_id;
        // $day = $request->day;
        // $room = $request->room_id;
        // $start_time = $request->start_time;
        // $end_time = $request->end_time;
        // dd($request);

        $dataFromDb = Schedule::find($id);
        $db_class = $dataFromDb->class_id;
        $db_day = $dataFromDb->day;
        $db_room = $dataFromDb->room_id;
        $db_start_time = $dataFromDb->start_time;
        $db_end_time = $dataFromDb->end_time;

        if($request->has('class_id')){
            $class = $request->class_id;
        }else{
            $class = $db_class;
        }
        if($request->has('day')){
            $day = $request->day;
        }else{
            $day = $db_day;
        }
        if($request->has('room_id')){
            $room = $request->room_id;
        }else{
            $room = $db_room;
        }
        if($request->has('start_time')){
            $start_time = $request->start_time;
        }else{
            $start_time = $db_start_time;
        }
        if($request->has('end_time')){
            $end_time = $request->end_time;
        }else{
            $end_time = $db_end_time;
        }

        $req = [
            'id'=>$id,
            'request'=> $request->all()
        ];
         
        if($start_time && $end_time){
            $dataScehdule = Schedule::where('class_id','=',$class)
                                    ->where('day','=', $day)
                                    ->where('room_id','=',$room)
                                    ->where('end_time','>',$start_time)
                                    ->where('start_time','<',$end_time)
                                    ->count();
        }

        if($validator->fails()){
            return back()->withErrors($validator)
            ->withInput();
        }else if($dataScehdule > 0){
            return back()->withErrors([
                'message' => 'Terdapat jadwal lain di jam ini. Silakan coba lagi!',
            ])->withInput();
        }else{
            $config = Self::configController($req);
            if(ControllerHelper::ch_insert($config)){
                return self::table();
            }
            return 'Failed';        }
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
            return self::table();
        }
        return 'Failed';
    }
}
