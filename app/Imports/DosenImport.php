<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToCollection;

class DosenImport implements ToCollection
{
    /**
     * @param Collection $collection
     */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            if (empty($row[0]) || trim($row[0]) === '') {
                continue;
            }
            
            // Generate deterministic email
            $nameParts = explode(',', $row[0]);
            $cleanName = strtolower(str_replace(' ', '', $nameParts[0]));
            $email = $cleanName . '@dosen.com';

            $dosen = User::create([
                'name' => ucwords(strtolower($row[0])),
                'email' => $email,
                'email_verified_at' => now(),
                'password' => '12345',
                'remember_token' => Str::random(10),
            ]);

            $dosen->assignRole('dosen');
        }
    }
}
