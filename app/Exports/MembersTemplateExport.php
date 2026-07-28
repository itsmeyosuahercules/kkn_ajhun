<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class MembersTemplateExport implements FromArray, WithHeadings, WithStyles
{
    public function array(): array
    {
        return [
            [
                'Ahmad Fauzi',
                'ahmad.fauzi@contoh.com',
                'password123',
                '2100001',
                '21',
                'Koordinator Desa',
                'Teknik Informatika',
                'Teknik',
                'Universitas Contoh',
                '081234567890',
                '@ahmadfauzi',
                'Fotografi, Badminton',
                'Mahasiswa aktif jurusan TI.',
            ],
        ];
    }

    public function headings(): array
    {
        return [
            'nama', 'email', 'password', 'nim', 'umur', 'jabatan',
            'jurusan', 'fakultas', 'universitas', 'no_hp', 'instagram', 'hobi', 'bio',
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
