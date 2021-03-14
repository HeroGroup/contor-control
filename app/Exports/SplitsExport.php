<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class SplitsExport implements FromCollection, WithHeadings, WithColumnFormatting, ShouldAutoSize
{
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
            'پرونده',
            'مشخصات کولر',
            'تعداد فاز کولر',
            'آمپر مصرفی کولر'
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
        return DB::table('cooling_devices')
            ->join('gateways', 'gateways.id', '=', 'cooling_devices.gateway_id')
            ->join('cities', 'cities.id', '=', 'gateways.city_id')
            ->join('electrical_meters', 'electrical_meters.gateway_id', '=', 'gateways.id')
            ->leftJoin('cooling_device_types', 'cooling_device_types.id', '=', 'cooling_devices.remote_manufacturer')
            ->select(DB::raw("
            @rownum:=@rownum+1 as rownum,
            cooling_devices.serial_number,
            CONCAT(electrical_meters.customer_name,' ',electrical_meters.shenase_moshtarak) AS MOSHAKHASAT_MOSHTARAK,
            cooling_devices.last_online,
            gateways.sim_card_number,
            electrical_meters.customer_address,
            gateways.modiriat,
            cities.name,
            electrical_meters.parvande,
            CONCAT(cooling_device_types.manufacturer, ' - ', cooling_device_types.model),
            cooling_device_types.number_of_phases,
            ''
            "))
            ->get();
    }
}
