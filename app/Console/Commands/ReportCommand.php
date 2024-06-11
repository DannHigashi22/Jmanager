<?php

namespace App\Console\Commands;

use App\Mail\AuditReport;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
//report test
use App\Models\Audit;
use App\Models\Error;
use App\Models\User;
use Carbon\Carbon;

class ReportCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'Report:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Envio de reporte auditorias, final de dia ';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $start = Carbon::now()->startOfDay();
        $end = Carbon::now()->endOfDay();

        //data info cards
        $auditsDay = Audit::whereBetween('created_at', [$start, $end])->count();
        $auditsMonth = Audit::whereMonth('created_at', Carbon::now()->format('m'))->count(); //auditorias del mes

        //chart error count
        $chartErrors = Error::WithCount([
            'audits' => function ($query) use ($start, $end) {
                $query->whereBetween('audits.created_at', [$start, $end]);
            }
        ])->orderBy('id', 'DESC')->pluck('audits_count', 'type')->all();

        //chart audits by user
        $chartUsers = User::selectRaw("CONCAT(name,' ',surname) as names")->WithCount([
            'audits' => function ($query) use ($start, $end) {
                $query->whereBetween('created_at', [$start, $end]);
            }
        ])->pluck('audits_count', 'names')->all();

        //chart type
        $chartType = Audit::selectRaw("type ,COUNT('type') as sumType")->groupBy('type')->whereBetween('created_at', [$start, $end])->orderBy('type')->pluck('sumType', 'type')->all(); 

        Mail::to("dann.higashi@inacapmail.cl")->send(new AuditReport($chartErrors,$chartUsers,$chartType,$auditsMonth,$auditsDay));

        //usuarios a enviar correo
        $users=User::all();
        /*foreach ($users as $user)   {
            if($user->getRoleNames()[0] == 'Administrador' || $user->getRoleNames()[0] == 'Super Administrador'){
                Mail::to("$user->email")->send(new AuditReport($chartErrors,$chartUsers,$chartType,$auditsMonth,$auditsDay));
            }
        }*/
    }
}
