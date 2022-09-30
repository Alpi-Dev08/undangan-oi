<?php

    namespace Database\Seeders\Master;

    use App\Models\Master\Work;
    use Illuminate\Database\Console\Seeds\WithoutModelEvents;
    use Illuminate\Database\Seeder;

    class WorksSeeder extends Seeder
    {
        /**
         * Run the database seeds.
         *
         * @return void
         */
        public function run()
        {
            $data = $this->data();

            foreach ($data as $value) {
                Work::create([
                    'name' => $value['name'],
                ]);
            }
        }

        function data()
        {
            return [
                ['name' => 'Belum/ Tidak Bekerja'],
                ['name' => 'Mengurus Rumah Tangga'],
                ['name' => 'Pelajar/ Mahasiswa'],
                ['name' => 'Pensiunan'],
                ['name' => 'Pewagai Negeri Sipil'],
                ['name' => 'Tentara Nasional Indonesia'],
                ['name' => 'Kepolisisan RI'],
                ['name' => 'Perdagangan'],
                ['name' => 'Petani/ Pekebun'],
                ['name' => 'Peternak'],
                ['name' => 'Nelayan/ Perikanan'],
                ['name' => 'Industri'],
                ['name' => 'Konstruksi'],
                ['name' => 'Transportasi'],
                ['name' => 'Karyawan Swasta'],
                ['name' => 'Karyawan BUMN'],
                ['name' => 'Karyawan BUMD'],
                ['name' => 'Karyawan Honorer'],
                ['name' => 'Buruh Harian Lepas'],
                ['name' => 'Buruh Tani/ Perkebunan'],
                ['name' => 'Buruh Nelayan/ Perikanan'],
                ['name' => 'Buruh Peternakan'],
                ['name' => 'Pembantu Rumah Tangga'],
                ['name' => 'Tukang Cukur'],
                ['name' => 'Tukang Listrik'],
                ['name' => 'Tukang Batu'],
                ['name' => 'Tukang Kayu'],
                ['name' => 'Tukang Sol Sepatu'],
                ['name' => 'Tukang Las/ Pandai Besi'],
                ['name' => 'Tukang Jahit'],
                ['name' => 'Tukang Gigi'],
                ['name' => 'Penata Rias'],
                ['name' => 'Penata Busana'],
                ['name' => 'Penata Rambut'],
                ['name' => 'Mekanik'],
                ['name' => 'Seniman'],
                ['name' => 'Tabib'],
                ['name' => 'Paraji'],
                ['name' => 'Perancang Busana'],
                ['name' => 'Penterjemah'],
                ['name' => 'Imam Masjid'],
                ['name' => 'Pendeta'],
                ['name' => 'Pastor'],
                ['name' => 'Wartawan'],
                ['name' => 'Ustadz/ Mubaligh'],
                ['name' => 'Juru Masak'],
                ['name' => 'Promotor Acara'],
                ['name' => 'Anggota DPR-RI'],
                ['name' => 'Anggota DPD'],
                ['name' => 'Anggota BPK'],
                ['name' => 'Presiden'],
                ['name' => 'Wakil Presiden'],
                ['name' => 'Anggota Mahkamah Konstitusi'],
                ['name' => 'Anggota Kabinet/ Kementerian'],
                ['name' => 'Duta Besar'],
                ['name' => 'Gubernur'],
                ['name' => 'Wakil Gubernur'],
                ['name' => 'Bupati'],
                ['name' => 'Wakil Bupati'],
                ['name' => 'Walikota'],
                ['name' => 'Wakil Walikota'],
                ['name' => 'Anggota DPRD Provinsi'],
                ['name' => 'Anggota DPRD Kabupaten/ Kota'],
                ['name' => 'Dosen'],
                ['name' => 'Guru'],
                ['name' => 'Pilot'],
                ['name' => 'Pengacara'],
                ['name' => 'Notaris'],
                ['name' => 'Arsitek'],
                ['name' => 'Akuntan'],
                ['name' => 'Konsultan'],
                ['name' => 'Dokter'],
                ['name' => 'Bidan'],
                ['name' => 'Perawat'],
                ['name' => 'Apoteker'],
                ['name' => 'Psikiater/ Psikolog'],
                ['name' => 'Penyiar Televisi'],
                ['name' => 'Penyiar Radio'],
                ['name' => 'Pelaut'],
                ['name' => 'Peneliti'],
                ['name' => 'Sopir'],
                ['name' => 'Pialang'],
                ['name' => 'Paranormal'],
                ['name' => 'Pedagang'],
                ['name' => 'Perangkat Desa'],
                ['name' => 'Kepala Desa'],
                ['name' => 'Biarawati'],
                ['name' => 'Wiraswasta']
            ];
        }
    }
