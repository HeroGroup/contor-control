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
            'آمپر مصرفی کولر',
            'تعداد فاز کولر'
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
        return DB::table('cooling_devices')
            ->select(DB::raw("
            '',
            cooling_devices.serial_number,
            CONCAT(electrical_meters.customer_name,' ',electrical_meters.shenase_moshtarak),
            '',
            '',
            electrical_meters.customer_address,
            '',
            cities.name,
            electrical_meters.parvande,
            '',
            '',
            ''
            "))
            ->join('gateways', 'gateways.id', '=', 'cooling_devices.gateway_id')
            ->join('cities', 'cities.id', '=', 'gateways.city_id')
            ->join('electrical_meters', 'electrical_meters.gateway_id', '=', 'gateways.id')
            ->get();
    }
}