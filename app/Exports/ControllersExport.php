<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class ControllersExport implements FromCollection, WithHeadings, WithColumnFormatting, ShouldAutoSize
{
    protected $type;

    public function __construct($type)
    {
        $this->type = $type;
    }

    public function headings(): array
    {
        return [
            'ردیف',
            'مشخصات دستگاه',
            'مشخصات مشترک',
            'آخرین حضور',
            'شماره سیم کارت',
            'آدرس مشترک',
            'مدیریت',
            'ناحیه',
            'پرونده'
        ];
    }

    public function columnFormats(): array
    {
        return [
            'B' => NumberFormat::FORMAT_NUMBER,
            'I' => NumberFormat::FORMAT_NUMBER,
        ];
    }

    public function collection()
    {
        DB::statement("SET @rownum=0;");
        return DB::table('gateways')
            ->select(DB::raw("
            @rownum:=@rownum+1 as rownum,
            electrical_meters.serial_number as SN,
            CONCAT(electrical_meters.customer_name,' ',electrical_meters.shenase_moshtarak) AS MOSHAKHASAT,
            electrical_meters.last_online AS LASTONLINE,
            gateways.sim_card_number AS SCN,
            electrical_meters.customer_address AS CU,
            gateways.modiriat AS GMD,
            cities.name AS CN,
            electrical_meters.parvande AS EMP
            "))
            ->join('cities', 'cities.id', '=', 'gateways.city_id')
            ->join('electrical_meters', 'electrical_meters.gateway_id', '=', 'gateways.id')
            ->where('gateways.gateway_type', $this->type)
            ->get();

    }
}
