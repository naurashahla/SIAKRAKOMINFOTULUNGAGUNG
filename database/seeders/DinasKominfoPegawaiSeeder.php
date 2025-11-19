<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use App\Models\Pegawai;

class DinasKominfoPegawaiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear existing data first - handle foreign key constraints
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        // Truncate the new pivot table if it exists; fallback to old name
        if (Schema::hasTable('event_user_recipients')) {
            DB::table('event_user_recipients')->truncate();
        } elseif (Schema::hasTable('event_recipients')) {
            DB::table('event_recipients')->truncate();
        }
        if (Schema::hasTable('pegawai')) {
            DB::table('pegawai')->truncate();
        } else {
            echo "Table 'pegawai' not found; skipping pegawai seed.\n";
        }
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        
        $pegawaiData = [
            [
                'nama' => 'Drs. SUPARNI, MM',
                'email' => 'suparni082@gmail.com',
                'bidang' => 'PIMPINAN',
                'jabatan' => 'KEPALA DINAS KOMUNIKASI DAN INFORMATIKA'
            ],
            [
                'nama' => 'HARI WINARNO, SPt. Msi',
                'email' => 'damen.group@gmail.com',
                'bidang' => 'PIMPINAN',
                'jabatan' => 'SEKRETARIS'
            ],
            [
                'nama' => 'ARDY KURNIAWAN, SE, MM',
                'email' => 'ardy7790@gmail.com',
                'bidang' => 'KOMUNIKASI DAN INFORMASI',
                'jabatan' => 'KEPALA BIDANG KOMUNIKASI DAN INFORMASI'
            ],
            [
                'nama' => 'HARYONO, S.Sos, M.A.P',
                'email' => 'iharyono663@gmail.com',
                'bidang' => 'STATISTIK PERSANDIAN',
                'jabatan' => 'KEPALA BIDANG STATISTIK PERSANDIAN'
            ],
            [
                'nama' => 'IWAN SEDIONO, SAP.',
                'email' => 'iwansediono@gmail.com',
                'bidang' => 'APLIKASI INFORMATIKA',
                'jabatan' => 'KEPALA BIDANG APLIKASI INFORMATIKA'
            ],
            [
                'nama' => 'RR SRI JOENIASTOETI, SE',
                'email' => 'joeni71.usp@gmail.com',
                'bidang' => 'SEKRETARIAT',
                'jabatan' => 'KEPALA SUB BAGIAN KEUANGAN'
            ],
            [
                'nama' => 'DYAH LUCKY PUSPITA DEWI, SH',
                'email' => 'lucky01dyah@gmail.com',
                'bidang' => 'STATISTIK PERSANDIAN',
                'jabatan' => 'KEPALA SEKSI DATA DAN STATISTIK'
            ],
            [
                'nama' => 'LEONARDO HERWANDA PUTRA, S.STP',
                'email' => 'leonardoherwanda93@gmail.com',
                'bidang' => 'SEKRETARIAT',
                'jabatan' => 'KEPALA SUB BAGIAN UMUM DAN KEPEGAWAIAN'
            ],
            [
                'nama' => 'TOTOK CHRISTANTO, SE, M.Si',
                'email' => 'denmastotoksejati@gmail.com',
                'bidang' => 'STATISTIK PERSANDIAN',
                'jabatan' => 'SANDIMAN AHLI MUDA'
            ],
            [
                'nama' => 'CAHYA LUCKITA NURMAWAN, ST. MM',
                'email' => 'cahya910@gmail.com',
                'bidang' => 'SEKRETARIAT',
                'jabatan' => 'PERENCANA AHLI MUDA'
            ],
            [
                'nama' => 'PURWADI, SE.,MM.',
                'email' => 'purwadi.se0371@gmail.com',
                'bidang' => 'STATISTIK PERSANDIAN',
                'jabatan' => 'SANDIMAN AHLI MUDA'
            ],
            [
                'nama' => 'TATAG HERTHA PRIAWAN SUHARSO, SE',
                'email' => 'tatag_herthaps@yahoo.com',
                'bidang' => 'KOMUNIKASI DAN INFORMASI',
                'jabatan' => 'PRANATA HUBUNGAN MASYARAKAT AHLI MUDA'
            ],
            [
                'nama' => 'ARIF HARI PURNOMO, ST.,MM',
                'email' => 'arifhp008@gmail.com',
                'bidang' => 'APLIKASI INFORMATIKA',
                'jabatan' => 'PRANATA KOMPUTER AHLI MUDA'
            ],
            [
                'nama' => 'ANDHI PRIONO, S.Si',
                'email' => 'andhi.priono@gmail.com',
                'bidang' => 'APLIKASI INFORMATIKA',
                'jabatan' => 'PRANATA KOMPUTER AHLI MUDA'
            ],
            [
                'nama' => 'AHMAD MUZAKI, ST',
                'email' => 'ahmadmuzaki@gmail.com',
                'bidang' => 'APLIKASI INFORMATIKA',
                'jabatan' => 'PRANATA KOMPUTER AHLI MUDA'
            ],
            [
                'nama' => 'DYAH MARTIANA HADIYANTI, S.Si',
                'email' => 'dyahmh@yahoo.com',
                'bidang' => 'STATISTIK PERSANDIAN',
                'jabatan' => 'STATISTISI AHLI MUDA'
            ],
            [
                'nama' => 'FREDI PRAJA NUGRAHA, SE',
                'email' => 'syachraja.redino@gmail.com',
                'bidang' => 'KOMUNIKASI DAN INFORMASI',
                'jabatan' => 'PRANATA HUBUNGAN MASYARAKAT AHLI MUDA'
            ],
            [
                'nama' => 'FREDDY SATRIO UTOMO, S.P.',
                'email' => 'freddysatrioutomo@gmail.com',
                'bidang' => 'STATISTIK PERSANDIAN',
                'jabatan' => 'ANALIS PERSANDIAN'
            ],
            [
                'nama' => 'DEVI SUCIANI KM',
                'email' => 'devisuciani0@gmail.com',
                'bidang' => 'SEKRETARIAT',
                'jabatan' => 'PENGELOLA BARANG MILIK NEGARA'
            ],
            [
                'nama' => 'RONNY YUWONO, S.Sos',
                'email' => 'ronnyyuwono@gmail.com',
                'bidang' => 'KOMUNIKASI DAN INFORMASI',
                'jabatan' => 'PENYUSUN BAHAN INFORMASI DAN PUBLIKASI'
            ],
            [
                'nama' => 'DIDIK SOLIKIN, S.E.',
                'email' => 'didiksolikin@gmail.com',
                'bidang' => 'KOMUNIKASI DAN INFORMASI',
                'jabatan' => 'ANALIS KONTEN MEDIA SOSIAL'
            ],
            [
                'nama' => 'PUJI ISTIK',
                'email' => 'istikpuji78@gmail.com',
                'bidang' => 'SEKRETARIAT',
                'jabatan' => 'BENDAHARA'
            ],
            [
                'nama' => 'FISTA PRAYUDHA SAKTIARI, A.Md',
                'email' => 'fista.ps84@gmail.com',
                'bidang' => 'SEKRETARIAT',
                'jabatan' => 'PENGELOLA KEUANGAN'
            ],
            [
                'nama' => 'RIZKA WAHYU ADITIYA SAPUTRA, S.Tr.T.',
                'email' => 'radiputra523@gmail.com',
                'bidang' => 'APLIKASI INFORMATIKA',
                'jabatan' => 'PRANATA KOMPUTER AHLI PERTAMA'
            ],
            [
                'nama' => 'DIMAS PRENKY DICKY IRAWAN, S.Kom',
                'email' => 'prenkydimas@gmail.com',
                'bidang' => 'APLIKASI INFORMATIKA',
                'jabatan' => 'PRANATA KOMPUTER AHLI PERTAMA'
            ],
            [
                'nama' => 'MUHAMMAD NURUSSHOBAH, S.Kom',
                'email' => 'nurusshobahmuhammad@gmail.com',
                'bidang' => 'STATISTIK PERSANDIAN',
                'jabatan' => 'PRANATA KOMPUTER AHLI PERTAMA'
            ],
            [
                'nama' => 'DIMAS AJI PRATAMA, S.Kom',
                'email' => 'd.ajipratama@gmail.com',
                'bidang' => 'STATISTIK PERSANDIAN',
                'jabatan' => 'PRANATA KOMPUTER AHLI PERTAMA'
            ],
            [
                'nama' => 'BALQIS LEMBAH MAHERSMI, S.Kom.',
                'email' => 'balqislembah@gmail.com',
                'bidang' => 'SEKRETARIAT',
                'jabatan' => 'PRANATA KOMPUTER AHLI PERTAMA'
            ],
            [
                'nama' => 'ACHMAD KHARIRI, S.A.P',
                'email' => 'khariri1999@gmail.com',
                'bidang' => 'SEKRETARIAT',
                'jabatan' => 'PERENCANA AHLI PERTAMA'
            ],
            [
                'nama' => 'MOHAMAD ANANG FANANI, S.Kom.',
                'email' => 'm4nt3p@gmail.com',
                'bidang' => 'APLIKASI INFORMATIKA',
                'jabatan' => 'PRANATA KOMPUTER AHLI PERTAMA'
            ],
            [
                'nama' => 'KUKUH EKA KUSUMA, S.Kom.',
                'email' => 'kukuhekakusuma@hotmail.com',
                'bidang' => 'KOMUNIKASI DAN INFORMASI',
                'jabatan' => 'PRANATA KOMPUTER AHLI PERTAMA'
            ],
            [
                'nama' => 'MOHAMMAD SODIK MUKROMIN',
                'email' => 'mohsodik1977@gmail.com',
                'bidang' => 'SEKRETARIAT',
                'jabatan' => 'PENGADMINISTRASI UMUM'
            ],
            [
                'nama' => 'ARIO SETYO ANGGORO, A.Md',
                'email' => 'ariosetyoanggoro@gmail.com',
                'bidang' => 'SEKRETARIAT',
                'jabatan' => 'PRANATA KOMPUTER TERAMPIL'
            ],
            [
                'nama' => 'MOH. SUKRON MAKMUN, A.Md',
                'email' => 'moh.surkronmakmun@gmail.com',
                'bidang' => 'APLIKASI INFORMATIKA',
                'jabatan' => 'PRANATA KOMPUTER TERAMPIL'
            ],
            [
                'nama' => 'TITIS DEVY HERDINTA LOSPA, A.Md.',
                'email' => 'titislospa2@gmail.com',
                'bidang' => 'STATISTIK PERSANDIAN',
                'jabatan' => 'PRANATA KOMPUTER TERAMPIL'
            ],
            [
                'nama' => 'LINTANG ADESY GUSTI, A.Md.',
                'email' => 'lintangadesygusti@gmail.com',
                'bidang' => 'STATISTIK PERSANDIAN',
                'jabatan' => 'STATISTISI TERAMPIL'
            ],
            [
                'nama' => 'AHMAD FUAD AFDAL, A.Md',
                'email' => 'ahmad.fuad.afdal@gmail.com',
                'bidang' => 'SEKRETARIAT',
                'jabatan' => 'PRANATA KOMPUTER TERAMPIL'
            ],
            [
                'nama' => 'SUBAGIYO',
                'email' => 'subagiyoabel@gmail.com',
                'bidang' => 'SEKRETARIAT',
                'jabatan' => 'PENGADMINISTRASI UMUM'
            ],
            [
                'nama' => 'MARJUKI',
                'email' => 'pakjuki73@gmail.com',
                'bidang' => 'SEKRETARIAT',
                'jabatan' => 'PENGADMINISTRASI UMUM'
            ],
            [
                'nama' => 'ANDRIYANI',
                'email' => 'andriyani190376@gmail.com',
                'bidang' => 'SEKRETARIAT',
                'jabatan' => 'PENGADMINISTRASI PERKANTORAN'
            ],
            [
                'nama' => 'ERMA ROHMAWATI',
                'email' => 'ermarohmawati37@gmail.com',
                'bidang' => 'APLIKASI INFORMATIKA',
                'jabatan' => 'PENGADMINISTRASI PERKANTORAN'
            ],
            [
                'nama' => 'NAURA SHAHLA MEISAMARVA',
                'email' => 'naurashahla11@gmail.com',
                'bidang' => 'MAGANG',
                'jabatan' => 'INTERNSHIP'
            ],
            [
                'nama' => 'CHARISMA VELENTINA',
                'email' => 'charismaav@gmail.com',
                'bidang' => 'MAGANG',
                'jabatan' => 'INTERNSHIP'
            ],
            [
                'nama' => 'JASMINE AZZAHRA',
                'email' => 'jasmineazzahra249@gmail.com',
                'bidang' => 'MAGANG',
                'jabatan' => 'INTERNSHIP'
            ]
        ];

        if (Schema::hasTable('pegawai')) {
            foreach ($pegawaiData as $pegawai) {
                Pegawai::create($pegawai);
            }
            echo "Successfully seeded " . count($pegawaiData) . " pegawai records.\n";
        } else {
            echo "Skipped inserting pegawai data because 'pegawai' table does not exist.\n";
        }
    }
}
