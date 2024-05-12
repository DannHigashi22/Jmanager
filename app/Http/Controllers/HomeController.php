<?php

namespace App\Http\Controllers;

use App\Models\Audit;
use App\Models\Error;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {   
        //date filter.
        $start= null;
        $end= null;
        $user=null;
        if (!empty($request->input('dateRange'))) {
            $date= explode(" - ",$request->input('dateRange'));
            $start=Carbon::createFromFormat('Y/m/d',$date[0])->startOfDay();
            $end=Carbon::createFromFormat('Y/m/d',empty($date[1])?$date[0]:$date[1])->endOfDay();   
        }
        if(Auth::user()->getRoleNames()[0] == 'Auditor'){
            $user=Auth::user()->id;
        }elseif($request->input('user') !== null){
            $user=User::select('id')->where('email',$request->input('user'))->first();
            $user=$user ? $user->id:'';
        }


        //data info cards
        $carbon=new Carbon();
        $auditsDay=Audit::when($request->input('dateRange') != null , function ($q) use ($start,$end){
            return $q->whereBetween('created_at',[$start,$end]);
        },function($q) use ($carbon){
            return $q->whereDay('created_at',($carbon->now()));
        })->count();
        //auditorias de hoy 
        $auditsMonth=Audit::whereMonth('created_at',($carbon->now()->format('m')))->count();//auditorias del mes
        $audits=Audit::all()->count();//Auditorias totales
        $users=User::all();//Usuarios totales

        //chart error count
        $chartErrors=Error::when($request->input('dateRange') != null | $request->input('type') != null | $user !== null , function ($q) use ($start,$end,$request, $user){
            return $q->WithCount([
                'audits'=> function ($query) use ($start,$end,$request,$user){
                    if ($user !== null) {
                        $query->where('user_id',$user);
                        //dd($query);
                    }
                    if ($start !== null) {
                        $query->whereBetween('audits.created_at',[$start,$end]);
                    }
                    if ($request->input('type') == 'Despacho' | $request->input('type') == 'Click auto') {
                        $query->where('type',$request->input('type'));
                    }else{$query=0;}

            }]);
        },function($q) use ($request){
            if (empty($request->input('dateRange')) && empty($request->input('type'))) {
                return $q->orderBy('id','DESC')->withCount('audits');
            }
        })->pluck('audits_count','type')->all();

        //chart audits by user
        $chartUsers=User::selectRaw("CONCAT(name,' ',surname) as names")
        ->when($request->input('dateRange') != null | $request->input('type') != null | $user !== null, function ($q) use ($start,$end,$request,$user){
            return $q->WithCount(['audits'=> function ($query) use ($start,$end,$request,$user){
                    if ($start !== null) {
                        $query->whereBetween('created_at',[$start,$end]);   
                    } 
                    if ($user !== null) {
                        $query->where('user_id',$user);
                    }
                    if ($request->input('type') == 'Despacho' | $request->input('type') == 'Click auto') {
                        $query->where('type',$request->input('type'));
                    }   
            }]);
        },function($q) use ($request){
            if (empty($request->input('dateRange')) && empty($request->input('type')) &&  empty($user)) {
                return $q->withCount('audits');
            }   
        })->pluck('audits_count','names')->all();

        //chart type
        $chartType=Audit::selectRaw("type ,COUNT('type') as sumType")->groupBy('type')
        ->when($user !== null , function ($q) use ($user){
            return $q->where('user_id',$user);
        })
        ->when($request->input('dateRange') != null , function ($q) use ($start,$end){
            return $q->whereBetween('created_at',[$start,$end]);
        })->when($request->input('type') == 'Despacho' | $request->input('type') == 'Click auto', function($q) use ($request){
            return $q->where('type','=',$request->input('type'));
        },function($q){
            return $q->orderBy('type');
        })->pluck('sumType','type')->all();

        //return ajax charts, for js
        if($request->ajax()){
            return response()->json([
                'chartErrors'=>$chartErrors,
                'chartUsers'=>$chartUsers,
                'chartType'=>$chartType]);
        }

        //Recientes
        $lastUsers=User::orderBy('created_at','desc')->limit(5)->get();
        $lastErrors=Error::orderBy('created_at','desc')->limit(5)->get();
        $lastAudits=Audit::orderBy('created_at','desc')->limit(5)->get();

        return view('home',compact('auditsDay','auditsMonth','audits','users','lastUsers','lastErrors','lastAudits'));
    }
}
