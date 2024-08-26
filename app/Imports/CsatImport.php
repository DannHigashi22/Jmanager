<?php

namespace App\Imports;

use App\Models\ClientsCsat;
use Illuminate\Support\Collection;

use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\ToArray;
use Maatwebsite\Excel\Concerns\WithValidation;

class CsatImport implements ToArray, WithHeadingRow, WithBatchInserts, WithChunkReading, WithValidation,SkipsEmptyRows ,ShouldQueue
{
    /**
    * @param Collection $collection
    */
    public function array(array $array)
    {
        return $array;
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
            '*.cliente' => ['required','string'],
            '*.hora_inicio_entrega' => ['required'],
            '*.PRIME' => ['required'],
            '*.estado' => ['required','string'],
            '*.shopper' => ['required'],
        ];
    }
}
