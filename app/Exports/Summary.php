<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Collection;
use App\Models\InvestorProperty;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
class Summary implements FromCollection, WithHeadings, WithStyles
{
    /**
     * @return \Illuminate\Support\Collection
     */
    protected $data;
    public function __construct(Collection $data)
    {
        $this->data = $data;
    }
    public function collection()
    {

        return $this->data->map(function ($item) {
            $userprop = InvestorProperty::join(
                'properties',
                'properties.property_id',
                'investor_properties.property_id',
            )
                ->where('investor_properties.user_id', $item->user_id)
                ->select('properties.name')
                ->get();

            $propcount = $userprop->count();
            $prop = [];
            foreach ($userprop as $userp) {
                $prop[] = $userp->name;
            }
            $stringprop = implode(',', $prop);

            return [
                'Name' => $item->name,
                'Email' => $item->email,
                'Mailing Address' => $item->mailing_address,
                'Phone No.' => $item->mobile,
                'Tag' => $item->tags,
                'Invested Properties' => $stringprop,
                'Total Properties' => $propcount,
            ];
        });
    }

    public function headings(): array
    {
        return ['Name', 'Email', 'Mailing Address', 'Phone No', 'Tag', 'Invested Properties', 'Total Properties'];
    }
     public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
