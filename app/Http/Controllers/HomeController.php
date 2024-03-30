<?php

namespace App\Http\Controllers;

use App\Models\Audit;
use App\Models\Error;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

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
        $carbon=new Carbon();
        $auditsToday=Audit::whereDate('created_at',$carbon->now()->format('Y-m-d'))->count();//auditorias de hoy 
        $auditsMonth=Audit::whereMonth('created_at',($carbon->now()->format('m')))->count();//auditorias del mes
        $audits=Audit::all()->count();//Auditorias totales
        $users=User::all()->count();//Usuarios totales

        //Recientes
        $lastUsers=User::orderBy('created_at','desc')->limit(4)->get();
        $lastErrors=Error::orderBy('created_at','desc')->limit(4)->get();
        $lastAudits=Audit::orderBy('created_at','desc')->limit(4)->get();

        //charts
        if($request->ajax()){
            $chartErrors=Error::orderBy('id','desc')->withCount('audits')->pluck('audits_count','type')->all();
            $chartUsers=User::selectRaw("CONCAT(name,' ',surname) as names")->WithCount('audits')->pluck('audits_count','names')->all();
            $chartType=Audit::selectRaw("type ,COUNT('type') as sumType")->groupBy('type')->orderBy('type')->pluck('sumType','type')->all();
            return response()->json([
                'chartErrors'=>$chartErrors,
                'chartUsers'=>$chartUsers,
                'chartType'=>$chartType],200);
        }
        
        return view('home',compact('auditsToday','auditsMonth','audits','users','lastUsers','lastErrors','lastAudits'));
    }
}
