<?php

namespace App\Exports;

use App\Models\Klinik\SkriningExamination;
use App\Models\Klinik\SkriningExaminationLocation;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use Carbon\Carbon;

class SkriningExaminationsExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithEvents
{
    protected $locationId;
    protected $examinationDate;

    public function __construct($locationId = null, $examinationDate = null)
    {
        $this->locationId      = $locationId;
        $this->examinationDate = $examinationDate;
    }

    public function collection()
    {
        $q = SkriningExamination::with(['location','gender']);

        if ($this->locationId) {
            $q->where('location_id', $this->locationId);
        }

        if ($this->examinationDate) {
            $q->whereDate('examination_date', $this->examinationDate);
        }

        return $q->get();
    }

    public function headings(): array
    {
        return [
            'No',
            'Tanggal Pemeriksaan',
            'Nama',
            'NIK/No BPJS',
            'Tanggal Lahir',
            'Usia',
            'Alamat',
            'Jenis Kelamin',
            'Handphone',
            'TB',
            'BB',
            'Lingkar Perut',
            'TD',
            'Kolesterol',
            'Asam Urat',
            'GD',
            'GDP',
            'GDS',
            'GD2PP',
            'Desk',
        ];
    }

    public function map($row): array
    {
        static $no = 0;
        $no++;

        $hasilDecoded = json_decode($row->hasil, true) ?? [];
        $map = [];
        foreach ($hasilDecoded as $item) {
            if (!isset($item['ItemName'])) continue;

            $key = $this->normalizeKey($item['ItemName']);
            $val = isset($item['hasil']) && trim($item['hasil']) !== '' 
                ? (string) $item['hasil'] 
                : '-';
            $map[$key] = $val;
        }

        $TB          = $this->getByAliases($map, ['tb','tinggibadan']);
        $BB          = $this->getByAliases($map, ['bb','beratbadan']);
        $Lingkar     = $this->getByAliases($map, ['lingkarperut','lp']);
        $TD          = $this->getByAliases($map, ['td','tensi','tekanandarah']);
        $Kolesterol  = $this->getByAliases($map, ['kolesterol','kolesteroltotal','kolesterolt','cholesterol']);
        $AsamUrat    = $this->getByAliases($map, ['asamurat','uricacid']);
        $GD          = $this->getByAliases($map, ['gd','guladarah','golongandarah']);
        $GDP         = $this->getByAliases($map, ['gdp','guladarahpuasa','gdp_fasting']);
        $GDS         = $this->getByAliases($map, ['gds','guladarahsewaktu','randomglucose']);
        $GD2PP       = $this->getByAliases($map, ['gd2pp','guladarah2pp','gd_2pp','2pp','guladarah2jampp']);
        $Desk        = $row->deskripsi ?: '-';

        // NIK/No BPJS tampil sebagai string
        $nikBpjs = '-';
        if (!empty($row->card_type)) {
            $nikBpjs = $row->nik_bpjs ?: '-';
        }

        return [
            $no,
            $row->examination_date ? Carbon::parse($row->examination_date)->format('d F Y') : '-',
            trim(($row->first_name ?? '').' '.($row->last_name ?? '')) ?: '-',
            $nikBpjs,
            $row->date_of_birth ? Carbon::parse($row->date_of_birth)->format('d F Y') : '-',
            $row->age ?: '-',
            $row->address ?: '-',
            $row->gender->name ?? '-',
            $row->phone ?: '-',
            $TB,
            $BB,
            $Lingkar,
            $TD,
            $Kolesterol,
            $AsamUrat,
            $GD,
            $GDP,
            $GDS,
            $GD2PP,
            $Desk,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            3 => ['font' => ['bold' => true]], // header kolom bold
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                // Sisipkan 2 baris di atas untuk header lokasi
                $sheet->insertNewRowBefore(1, 2);

                // Merge kolom B..T untuk lokasi (tengah)
                $sheet->mergeCells('B1:T1');

                $locationName = $this->locationId
                    ? optional(SkriningExaminationLocation::find($this->locationId))->name
                    : 'SEMUA LOKASI';
                $sheet->setCellValue('B1', $locationName);

                // Style header lokasi
                $sheet->getStyle('B1')->getFont()->setBold(true)->setSize(12);
                $sheet->getStyle('B1')->getAlignment()
                    ->setHorizontal(Alignment::HORIZONTAL_CENTER)
                    ->setVertical(Alignment::VERTICAL_CENTER);

                // Auto-size kolom A..T
                foreach (range('A','T') as $col) {
                    $sheet->getColumnDimension($col)->setAutoSize(true);
                }

                $lastRow = $sheet->getHighestRow();

                // Format kolom D (NIK/No BPJS) sebagai TEXT sebelum isi data
                $sheet->getStyle('D4:D'.$lastRow)
                      ->getNumberFormat()
                      ->setFormatCode(NumberFormat::FORMAT_TEXT);

                // Border tabel A3..T$lastRow
                $sheet->getStyle('A3:T'.$lastRow)->getBorders()->getAllBorders()
                      ->setBorderStyle(Border::BORDER_THIN);

                // Header kolom (baris 3) bold
                $sheet->getStyle('A3:T3')->getFont()->setBold(true);

                // Bold kolom Nama (C) mulai baris 4
                for ($r = 4; $r <= $lastRow; $r++) {
                    $sheet->getStyle('C'.$r)->getFont()->setBold(true);
                }

                // Rata tengah No, Usia, hasil pemeriksaan + Desk
                $sheet->getStyle('A3:A'.$lastRow)->getAlignment()
                    ->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('F3:F'.$lastRow)->getAlignment()
                    ->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('J3:T'.$lastRow)->getAlignment()
                    ->setHorizontal(Alignment::HORIZONTAL_CENTER);

                // Set setiap nilai di kolom D sebagai string eksplisit
                for ($r = 4; $r <= $lastRow; $r++) {
                    $cell = $sheet->getCell('D'.$r);
                    $cell->setValueExplicit($cell->getValue(), DataType::TYPE_STRING);
                }
            },
        ];
    }

    private function normalizeKey(string $name): string
    {
        $n = strtolower($name);
        $n = preg_replace('/[^a-z0-9]+/', '', $n);

        $aliases = [
            'tinggibadan'        => 'tb',
            'beratbadan'         => 'bb',
            'lingkarperut'       => 'lingkarperut',
            'lp'                 => 'lingkarperut',
            'tekanandarah'       => 'td',
            'tensi'              => 'td',
            'kolesterol'         => 'kolesterol',
            'kolesteroltotal'    => 'kolesterol',
            'kolesterolt'        => 'kolesterol',
            'cholesterol'        => 'kolesterol',
            'asamurat'           => 'asamurat',
            'uricacid'           => 'asamurat',
            'guladarah'          => 'gd',
            'gd'                 => 'gd',
            'golongandarah'      => 'gd',
            'gdp'                => 'gdp',
            'guladarahpuasa'     => 'gdp',
            'gdp_fasting'        => 'gdp',
            'gds'                => 'gds',
            'guladarahsewaktu'   => 'gds',
            'randomglucose'      => 'gds',
            'gd2pp'              => 'gd2pp',
            'guladarah2pp'       => 'gd2pp',
            'gd_2pp'             => 'gd2pp',
            '2pp'                => 'gd2pp',
            'guladarah2jampp'    => 'gd2pp',
            'guladarah2jampostprandial' => 'gd2pp',
            'desk'               => 'desk',
        ];

        return $aliases[$n] ?? $n;
    }

    private function getByAliases(array $map, array $aliases): string
    {
        foreach ($aliases as $a) {
            if (isset($map[$a]) && trim($map[$a]) !== '') {
                return $map[$a];
            }
        }
        return '-';
    }
}
