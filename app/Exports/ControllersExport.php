<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ControllersExport implements FromCollection, WithHeadings, WithColumnFormatting, WithStyles, ShouldAutoSize
{
    protected $type;

    public function __construct($type)
    {
        $this->type = $type;
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]], // bold headings
        ];
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
        return DB::table('gateways')
            ->select(DB::raw("
            '',
            electrical_meters.serial_number,
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
            ->join('cities', 'cities.id', '=', 'gateways.city_id')
            ->join('electrical_meters', 'electrical_meters.gateway_id', '=', 'gateways.id')
            ->where('gateways.gateway_type', $this->type)
            ->get();
    }
}
