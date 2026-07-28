<?php

namespace App\Imports;

use App\Models\Member;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class MembersImport implements ToCollection, WithHeadingRow
{
    public int $imported = 0;

    /** @var array<int, array{row: int, errors: array<int, string>}> */
    public array $failures = [];

    public function collection(Collection $rows): void
    {
        foreach ($rows as $index => $row) {
            $rowNumber = $index + 2; // +1 for 0-index, +1 for heading row

            $data = [
                'name' => trim((string) ($row['nama'] ?? $row['name'] ?? '')),
                'email' => trim((string) ($row['email'] ?? '')),
                'password' => trim((string) ($row['password'] ?? '')) ?: null,
                'nim' => $this->nullableString($row['nim'] ?? null),
                'age' => $this->nullableInt($row['umur'] ?? $row['age'] ?? null),
                'jurusan' => $this->nullableString($row['jurusan'] ?? null),
                'fakultas' => $this->nullableString($row['fakultas'] ?? null),
                'universitas' => $this->nullableString($row['universitas'] ?? null),
                'jabatan' => $this->nullableString($row['jabatan'] ?? null),
                'phone' => $this->nullableString($row['no_hp'] ?? $row['phone'] ?? null),
                'bio' => $this->nullableString($row['bio'] ?? null),
                'instagram' => $this->nullableString($row['instagram'] ?? null),
                'hobi' => $this->nullableString($row['hobi'] ?? null),
            ];

            // Skip fully empty rows
            if ($data['name'] === '' && $data['email'] === '') {
                continue;
            }

            $validator = Validator::make($data, [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'email', 'max:255', 'unique:users,email'],
                'nim' => ['nullable', 'string', 'max:50'],
                'age' => ['nullable', 'integer', 'min:15', 'max:100'],
                'jurusan' => ['nullable', 'string', 'max:255'],
                'fakultas' => ['nullable', 'string', 'max:255'],
                'universitas' => ['nullable', 'string', 'max:255'],
                'jabatan' => ['nullable', 'string', 'max:255'],
                'phone' => ['nullable', 'string', 'max:50'],
                'bio' => ['nullable', 'string'],
                'instagram' => ['nullable', 'string', 'max:255'],
                'hobi' => ['nullable', 'string', 'max:255'],
            ]);

            if ($validator->fails()) {
                $this->failures[] = [
                    'row' => $rowNumber,
                    'errors' => $validator->errors()->all(),
                ];

                continue;
            }

            try {
                DB::transaction(function () use ($data) {
                    $user = User::create([
                        'name' => $data['name'],
                        'email' => $data['email'],
                        'password' => Hash::make($data['password'] ?? 'password'),
                        'role' => 'member',
                    ]);

                    Member::create([
                        'user_id' => $user->id,
                        'nim' => $data['nim'],
                        'age' => $data['age'],
                        'jurusan' => $data['jurusan'],
                        'fakultas' => $data['fakultas'],
                        'universitas' => $data['universitas'],
                        'jabatan' => $data['jabatan'],
                        'phone' => $data['phone'],
                        'bio' => $data['bio'],
                        'instagram' => $data['instagram'],
                        'hobi' => $data['hobi'],
                    ]);
                });

                $this->imported++;
            } catch (\Throwable $e) {
                $this->failures[] = [
                    'row' => $rowNumber,
                    'errors' => [$e->getMessage()],
                ];
            }
        }
    }

    private function nullableString($value): ?string
    {
        $value = trim((string) ($value ?? ''));

        return $value === '' ? null : $value;
    }

    private function nullableInt($value): ?int
    {
        $value = trim((string) ($value ?? ''));

        return $value === '' ? null : (int) $value;
    }
}
