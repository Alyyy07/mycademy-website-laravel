<?php

/**
 * Script to generate fake data Excel files for database seeding
 * This replaces sensitive university student data with anonymous fake data
 */

require __DIR__ . '/vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Faker\Factory as Faker;

$faker = Faker::create('id_ID'); // Indonesian locale

// ============================================
// 1. Generate Mahasiswa (Students) Data
// ============================================
echo "Generating student data...\n";

$spreadsheetMahasiswa = new Spreadsheet();
$sheetMahasiswa = $spreadsheetMahasiswa->getActiveSheet();

// Column headers (row 1 will be data, no headers in original)
$studentData = [];

// Generate 40 students
for ($i = 1; $i <= 40; $i++) {
    $firstName = $faker->firstName;
    $lastName = $faker->lastName;
    $npm = '2021' . str_pad($i, 6, '0', STR_PAD_LEFT); // Format: 2021000001
    $nik = $faker->numerify('################'); // 16 digit NIK
    $gender = $faker->randomElement(['L', 'P']);
    $motherName = $faker->name('female');
    $religion = $faker->randomElement(['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha']);
    $birthPlace = $faker->city;
    $birthDate = $faker->dateTimeBetween('-25 years', '-18 years')->format('d F Y');
    $address1 = $faker->streetAddress;
    $address2 = $faker->city . ', ' . $faker->state;
    $phone = $faker->numerify('08##########');
    $email = 'npm' . $npm . '@student.university.ac.id';
    $semester = $faker->numberBetween(1, 8);
    
    $studentData[] = [
        $npm,           // A: NPM
        $firstName,     // B: First Name
        $lastName,      // C: Last Name
        $nik,           // D: NIK
        $gender,        // E: Gender
        $motherName,    // F: Mother's Name
        $religion,      // G: Religion
        $birthPlace,    // H: Birth Place
        $birthDate,     // I: Birth Date
        $address1,      // J: Address Part 1
        $address2,      // K: Address Part 2
        $phone,         // L: Phone
        $email,         // M: Email
        '',             // N: Empty
        $semester,      // O: Semester
    ];
}

// Write data to sheet
$row = 1;
foreach ($studentData as $student) {
    $col = 'A';
    foreach ($student as $value) {
        $sheetMahasiswa->setCellValue($col . $row, $value);
        $col++;
    }
    $row++;
}

// Save student file
$writerMahasiswa = new Xlsx($spreadsheetMahasiswa);
$mahasiswaPath = __DIR__ . '/storage/app/public/seeder/seederMahasiswa.xlsx';
$writerMahasiswa->save($mahasiswaPath);
echo "✓ Student data saved to: $mahasiswaPath\n";

// ============================================
// 2. Generate Dosen (Lecturers) Data
// ============================================
echo "Generating lecturer data...\n";

$spreadsheetDosen = new Spreadsheet();
$sheetDosen = $spreadsheetDosen->getActiveSheet();

$lecturerNames = [
    'Budi Santoso, S.Kom., M.T.',
    'Siti Rahayu, S.T., M.Kom.',
    'Ahmad Hidayat, S.Kom., M.Sc.',
    'Dewi Lestari, S.Si., M.T.',
    'Eko Prasetyo, S.T., M.Eng.',
    'Fitri Handayani, S.Kom., M.Kom.',
    'Gunawan Wijaya, S.T., Ph.D.',
    'Hana Permata, S.Kom., M.T.',
    'Indra Kusuma, S.Si., M.Kom.',
    'Joko Susilo, S.T., M.Sc.',
    'Kartika Sari, S.Kom., M.T.',
    'Lukman Hakim, S.T., M.Kom.',
];

$row = 1;
foreach ($lecturerNames as $name) {
    $sheetDosen->setCellValue('A' . $row, $name);
    $row++;
}

// Save lecturer file
$writerDosen = new Xlsx($spreadsheetDosen);
$dosenPath = __DIR__ . '/storage/app/public/seeder/seederDosen.xlsx';
$writerDosen->save($dosenPath);
echo "✓ Lecturer data saved to: $dosenPath\n";

// ============================================
// 3. Generate Matakuliah (Courses) Data
// ============================================
echo "Generating course data...\n";

$spreadsheetMatakuliah = new Spreadsheet();
$sheetMatakuliah = $spreadsheetMatakuliah->getActiveSheet();

$courses = [
    ['', '', 'TIF101', 'Algoritma dan Pemrograman', '', '', '', '', '', 3],
    ['', '', 'TIF102', 'Struktur Data', '', '', '', '', '', 3],
    ['', '', 'TIF103', 'Basis Data', '', '', '', '', '', 3],
    ['', '', 'TIF104', 'Pemrograman Web', '', '', '', '', '', 3],
    ['', '', 'TIF105', 'Teknologi IoT', '', '', '', '', '', 3],
    ['', '', 'TIF106', 'Jaringan Komputer', '', '', '', '', '', 3],
    ['', '', 'TIF107', 'Sistem Operasi', '', '', '', '', '', 3],
    ['', '', 'TIF108', 'Rekayasa Perangkat Lunak', '', '', '', '', '', 3],
    ['', '', 'TIF109', 'Kecerdasan Buatan', '', '', '', '', '', 3],
    ['', '', 'TIF110', 'Keamanan Informasi', '', '', '', '', '', 3],
    ['', '', 'TIF111', 'Pemrograman Mobile', '', '', '', '', '', 3],
    ['', '', 'TIF112', 'Cloud Computing', '', '', '', '', '', 3],
    ['', '', 'TIF113', 'Data Mining', '', '', '', '', '', 3],
    ['', '', 'TIF114', 'Pemrograman Android', '', '', '', '', '', 3],
    ['', '', 'TIF115', 'Machine Learning', '', '', '', '', '', 3],
];

$row = 1;
foreach ($courses as $course) {
    $col = 'A';
    foreach ($course as $value) {
        $sheetMatakuliah->setCellValue($col . $row, $value);
        $col++;
    }
    $row++;
}

// Save course file
$writerMatakuliah = new Xlsx($spreadsheetMatakuliah);
$matakuliahPath = __DIR__ . '/storage/app/public/seeder/seederMatakuliah.xlsx';
$writerMatakuliah->save($matakuliahPath);
echo "✓ Course data saved to: $matakuliahPath\n";

echo "\n✅ All Excel files generated successfully!\n";
echo "\nNext steps:\n";
echo "1. Update seeders to use generic references\n";
echo "2. Run: php artisan migrate:fresh --seed\n";
echo "3. Test the application\n";
