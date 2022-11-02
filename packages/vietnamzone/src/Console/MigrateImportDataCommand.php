<?php

namespace Packages\Vietnamzone\Console;

use Carbon\Carbon;
use Exception;
use File;
use \Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Reader\Xls;

class MigrateImportDataCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'vietnamzone:migrate_import';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Vietnamzone Migrate Import Data';

    /**
     * @var array
     */
    private $provincesID = [];
    private $districtsID = [];

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle(): bool
    {
        try {
            $this->info("Begin migration vietnamzone.....");
            $base_name = config('Vietnamzone::config.data_base_path');
            $filename = config('Vietnamzone::config.data_filename');
            $path = $base_name . $filename;
            $time = time();

            if (File::exists(base_path($path))) {
                $this->info("Import data file $path");
            } else {
                $this->warn("File $filename does not exist.");
                $this->warn("Please export excel by following link https://danhmuchanhchinh.gso.gov.vn/");
                $this->warn("Please checked checkbox [Quận Huyện, Phường Xã]");
                $this->warn("Please move file excel from $base_name");
                return false;
            }

            $reader = new Xls();
            $spreadsheet = $reader->load(base_path($path));
            $worksheet = $spreadsheet->getActiveSheet();

            $headers = [];
            $rows = [];
            $index = 0;

            foreach ($worksheet->getRowIterator() as $row) {
                $cellIterator = $row->getCellIterator();
                $cellIterator->setIterateOnlyExistingCells(FALSE);
                $cells = [];

                if ($index == 0) {
                    foreach ($cellIterator as $key => $cell) {
                        $cells[$key] = trim($cell->getValue());
                    }
                    $headers = $this->mappingHeader($cells);

                } elseif (count($headers) >= 6) {
                    foreach ($cellIterator as $key => $cell) {
                        if (isset($headers[$key])) $cells[$headers[$key]] = trim($cell->getValue());
                    }
                    if ($cells) $rows[] = $cells;
                }
                $index++;
            }

            if ($rows) {
                $this->info("Importing: $filename (" . (time() - $time) . " seconds)");

                DB::beginTransaction();
                foreach ($rows as $row) {

                    if (empty($this->provincesID[$row['province_code']])) {
                        $this->insertProvinces($row);
                    }

                    if (empty($this->districtsID[$row['district_code']])) {
                        $this->insertDistricts($row);
                    }

                    if (empty($row['ward_name']) || empty($row['ward_code'])) continue;

                    $this->insertWards($row);
                }
                DB::commit();
                $this->info("Imported: $filename (" . (time() - $time) . " seconds)");

                $version = config('Vietnamzone::config.data_file_version_export');
                $this->info("Data was exported on $version");
                $this->info("You can update the latest data at the following link https://danhmuchanhchinh.gso.gov.vn/");
            }
            return true;

        } catch (Exception $exception) {
            DB::rollBack();
            $this->error("Import data error: {$exception->getMessage()}");
            return false;
        }
    }

    /**
     * @param $row
     */
    private function insertProvinces($row)
    {
        $id = DB::table(config('Vietnamzone::config.tables.provinces'))->insertGetId([
            config('Vietnamzone::config.columns.name') => $row['province_name'],
            config('Vietnamzone::config.columns.address_code') => $row['province_code'],
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
        $this->provincesID[$row['province_code']] = $id;
    }

    /**
     * @param $row
     */
    private function insertDistricts($row)
    {
        $id = DB::table(config('Vietnamzone::config.tables.districts'))->insertGetId([
            config('Vietnamzone::config.columns.province_id') => $this->provincesID[$row['province_code']],
            config('Vietnamzone::config.columns.name') => $row['district_name'],
            config('Vietnamzone::config.columns.address_code') => $row['district_code'],
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
        $this->districtsID[$row['district_code']] = $id;
    }

    /**
     * @param $row
     */
    private function insertWards($row)
    {
        DB::table(config('Vietnamzone::config.tables.wards'))->insert([
            config('Vietnamzone::config.columns.district_id') => $this->districtsID[$row['district_code']],
            config('Vietnamzone::config.columns.name') => $row['ward_name'],
            config('Vietnamzone::config.columns.address_code') => $row['ward_code'],
            config('Vietnamzone::config.columns.rank') => $row['ward_rank'] ?? null,
            config('Vietnamzone::config.columns.name_en') => $row['ward_name_en'] ?? null,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
    }


    /**
     * @param $cells
     * @return array
     */
    private function mappingHeader($cells): array
    {
        $mapping = [
            'Tỉnh Thành Phố' => 'province_name',
            'Mã TP' => 'province_code',
            'Quận Huyện' => 'district_name',
            'Mã QH' => 'district_code',
            'Phường Xã' => 'ward_name',
            'Mã PX' => 'ward_code',
            'Cấp' => 'ward_rank',
            'Tên Tiếng Anh' => 'ward_name_en',
        ];
        $headers = [];

        foreach ($cells as $column => $value) {
            if (isset($mapping[$value])) {
                $headers[$column] = $mapping[$value];
            }
        }

        return $headers;
    }
}
