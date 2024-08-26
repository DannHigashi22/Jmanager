<?php
namespace App\Imports;

use App\Models\Audit;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\WithValidation;

class AuditImport implements ToCollection, WithHeadingRow, WithBatchInserts, WithChunkReading, WithValidation,SkipsEmptyRows ,ShouldQueue
{
    public function collection(Collection $rows){   
        //$audit=Audit::where('shopper','=',null)->get();
        foreach ($rows as $row){
            Audit::where('order',$row['nro_pedido'])->where('shopper','=',null)->update([
                'shopper'=> $row['shopper']
            ]);
        }
    }
    public function batchSize(): int
    {
        return 2000;
    }
    
    public function chunkSize(): int
    {
        return 2000;
    }

    public function rules(): array
    {
        return [
             '*.nro_pedido' => ['integer','required'],
             '*.shopper' => ['required'],
        ];
    }
}