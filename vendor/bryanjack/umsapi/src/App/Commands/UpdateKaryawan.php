<?php

namespace Bryanjack\Umsapi\App\Commands;

use Bryanjack\Dash\Models\Menu;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use DateTime;
use DateTimeZone;

class UpdateKaryawan extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hris:sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update Data Karyawan dari HRIS';

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
     *
     * @return mixed
     */
    public function handle()
    {

        $url = "http://hris.paninbanksyariah.co.id/api/web/cia/karyawan_aktif.php";

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $response = curl_exec($ch);
        $data_karyawan = json_decode($response);

        $tz_object = new DateTimeZone('Asia/Jakarta');
        $datetime = new DateTime();
        $datetime->setTimezone($tz_object);
        $cur_date = $datetime->format('Y-n-j H:i:s');

        $app_id = '1';
        $app_id_cia = '4';
        $i = 1;

        $items = count($data_karyawan->data);
        $progressbar = $this->output->createProgressBar($items);
        $progressbar->setFormat("\t%message%\n <question>%current%/%max% [%bar%] %percent:3s%%</question>");
        $progressbar->setMessage("<info>Syncing...</info>");
        $progressbar->start();

        foreach ($data_karyawan->data as $data) {
            $nik = $data->nik;
            $nama = ucwords(strtolower($data->EMPLOYEE_NAME));
            $nama = str_replace("'", '`', $nama);
            $position = strtoupper($data->POSITION);
            $structure = $data->STRUCTURE;
            $branch = $data->BRANCH;
            $email = strtolower($data->email);
            if (strpos($email, '@paninbanksyariah.co.id') !== FALSE) {
                $get_username = explode('@', $email);
                $email = $get_username[0] . "@pdsb.co.id";
            }
            // $default_level = "R202002645897";
            $password = sha1("Sy@r1ah");
            $created_at = $cur_date;
            $updated_at = $cur_date;
            $foruser = explode(" ", strtolower($nama));
            if (count($foruser) > 1) {
                $username = $foruser[0] . "." . $foruser[1];
            } else {
                $username = $foruser[0];
            }
            $username = str_replace(",", "", $username);
            if (empty($email)) {
                $email = $username . ".temp@pdsb.co.id";
            }
            $status = '0';
            // $unit = $data['cabang'];
            $created_user  = 'SYSTEM';
            $updated_user = 'SYSTEM';
            $flag_update = '1';

            if (strpos($structure, 'KC') !== FALSE && strpos($branch, 'KANTOR PUSAT') === FALSE) {
                $find_kd_cabang = DB::table('branch_hris')->where('Name', '=', $branch)->first();
            } else if ($position == 'STRUCTURED TRADE & FINANCING PROGRAM ADVISOR') {
                $find_kd_cabang = DB::table('branch_hris')->where('Name', '=', 'DEPARTEMEN STRUCTURE TRADE & FINANCING PROGRAM ADVISOR')->first();
            } else {
                $find_kd_cabang = DB::table('branch_hris')->where('Name', '=', $structure)->first();
            }

            if (count((array) $find_kd_cabang) > 0) {
                $kd_cabang = $find_kd_cabang->Branch;
            } else {
                $kd_cabang = "NULL";
            }

            $level = "";

            if ($position == 'COMMISSIONER' || $position == 'AUDIT & RISK OVERSIGHT COMMITTEE' || $position == 'AUDIT COMMITTEE') {
                $level = "R202002743741";
            } else if ($position == 'PRESIDENT DIRECTOR') {
                $level = "R202002546456";
            } else if ($position == 'DIRECTOR') {
                $level = "R202002216938";
            } else if ($position == 'COMPLIANCE DIRECTOR') {
                $level = "R202002654644";
            } else if ($position == 'BUSINESS DIRECTOR') {
                $level = "R202112639815";
            } else if ((strpos($position, 'HEAD OF') !== FALSE) && $position != 'HEAD OF FINANCE AND STRATEGIC PLANNING') {
                $level = "R202002453453";
            } else if ($position == 'HEAD OF FINANCE AND STRATEGIC PLANNING') {
                $level = "R202002254061";
            } else if (strpos($position, ' HEAD') !== FALSE && $position != 'PAYROLL & HR OPERATIONS HEAD' && $position != 'FINANCIAL CONTROL HEAD' && $position != 'DEVELOPMENT & SOLUTION HEAD' && $position != 'ACCOUNTING & TAX HEAD') {
                $level = "R202002547453";
            } else if ($position == 'PAYROLL & HR OPERATIONS HEAD') {
                $level = "R202002745643";
            } else if ($position == 'FINANCIAL CONTROL HEAD') {
                $level = "R202002250348";
            } else if ($position == 'DEVELOPMENT & SOLUTION HEAD') {
                $level = "3";
            } else if ($position == 'ACCOUNTING & TAX HEAD') {
                $level = "R202002756544";
            } else if ($position == 'HR OPERATIONS & TAX OFFICER') {
                $level = "R202002964782";
            } else if (strpos($position, ' OFFICER') !== FALSE && $position != 'DATA WAREHOUSE & REPORTING OFFICER' && $position != 'BENEFIT & PAYMENT OFFICER' && $position != 'IT QUALITY ASSURANCE OFFICER' && $position != 'RELATIONSHIP OFFICER COORDINATOR' && $position != 'DATABASE ADMINISTRATOR OFFICER' && $position != 'NETWORK ADMINISTRATOR OFFICER' && $position != 'INFORMATION SECURITY OFFICER' && $position != 'IT HELPDESK OFFICER') {
                $level = "R202002645897";
            } else if ($position == 'DATA WAREHOUSE & REPORTING OFFICER') {
                $level = "R202002345452";
            } else if ($position == 'BENEFIT & PAYMENT OFFICER') {
                $level = "R202002512906";
            } else if ($position == 'TAX MANAGER') {
                $level = "R202002498503";
            } else if ($position == 'IT QUALITY ASSURANCE OFFICER' || $position == 'RELATIONSHIP OFFICER COORDINATOR') {
                $level = "R202002872051";
            } else if ($position == 'DATABASE ADMINISTRATOR OFFICER' || $position == 'NETWORK ADMINISTRATOR OFFICER') {
                $level = "R202004573086";
            } else if ($position == 'INFORMATION SECURITY OFFICER') {
                $level = "R202007729158";
            } else if ($position == 'RELATIONSHIP MANAGER SME') {
                $level = "R202002645897";
            } else if (strpos($position, ' MANAGER') !== FALSE && $position != 'BRANCH MANAGER' && $position != 'FUNDING BUSINESS MANAGER' && $position != 'COST MANAGEMENT & CONTROL MANAGER') {
                $level = "R202002872051";
            } else if ($position == 'BRANCH MANAGER') {
                $level = "R202002547453";
            } else if ($position == 'FUNDING BUSINESS MANAGER') {
                $level = "R202004364912";
            } else if ($position == 'COST MANAGEMENT & CONTROL MANAGER') {
                $level = "R202103743068";
            } else if (strpos($position, ' COORDINATOR') !== FALSE && $position != 'TAX COORDINATOR') {
                $level = "R202002345452";
            } else if ($position == 'TAX COORDINATOR') {
                $level = "R202002498503";
            } else if (strpos($position, ' SUPERVISOR') !== FALSE) {
                $level = "R202002345452";
            } else if ($position == 'ADVISOR' || $position == 'STRUCTURED TRADE & FINANCING PROGRAM ADVISOR' || $position == 'TALENT ACQUISITION ' || $position == 'TEAM LEADER ALLIANCES FINANCING') {
                $level = "R202002547453";
            } else if (strpos($position, ' STAFF') !== FALSE) {
                $level = "R202002645897";
            } else if (strpos($position, 'MONITORING') !== FALSE) {
                $level = "R202004364912";
            } else if ($position == 'BACK OFFICE') {
                $level = "R202002645897";
            } else if ($position == 'RETAIL FUNDING BUSINESS') {
                $level = "R202012653972";
            } else if ($position == 'FINANCIAL INSTITUTION & CORRESPONDENT BANKING' || $position == 'GENERAL ASSESSMENT & GCG ' || $position == 'TEAM LEADER WHOLESALE FINANCING') {
                $level = "R202002872051";
            } else if ($position == 'HR OPERATIONS & TAX') {
                $level = "R202002964782";
            } else if ($position == 'ORGANIZATION DEVELOPMENT & HR POLICY') {
                $level = "R202004364912";
            } else if ($position == 'EMPLOYEE RELATION & PERFORMANCE MANAGEMENT') {
                $level = "R202009974510";
            } else if ($position == 'RETAIL FUNDING BUSINESS') {
                $level = "R202002345452";
            } else if ($position == 'IT HELPDESK OFFICER') {
                $level = "R202004573086";
            } else {
                $level = "R202002645897";
            }

            $check_nik = DB::table('users')->where('NIK', '=', $nik)->get();

            if (count($check_nik) > 0) {
                $execute_update = DB::table('users')
                    ->where('NIK', '=', $nik)
                    ->update([
                        'email' => $email,
                        'unit' => $kd_cabang,
                        'created_user' => $created_user,
                        'updated_user' => $updated_user,
                        'jabatan' => $position
                    ]);
            } else {

                $check_username = DB::table('users')->where('username', '=', $username)->get();
                if (count($check_username) > 0) {
                    $username = $username . $i;
                }
                $check_email = DB::table('users')->where('email', '=', $email)->get();
                if (count($check_email) > 0) {
                    $email = $username . $i . "@pdsb.co.id";
                }

                $insert_user = DB::table('users')->insert(
                    [
                        'name' => $nama,
                        'email' => $email,
                        'password' => $password,
                        'created_at' => $created_at,
                        'username' => $username,
                        'status' => '0',
                        'unit' => $kd_cabang,
                        'created_user' => $created_user,
                        'updated_user' => $created_user,
                        'flag_update' => '1',
                        'NIK' => $nik,
                        'jabatan' => $position
                    ]
                );
            }
            $i++;

            usleep(500000);

            if ($i == ($items - 10)) {
                $progressbar->setMessage('<info>Syncing..sabarr..dikit lagi</info>');
            }
            $progressbar->advance();
        }
        $progressbar->setMessage('<info>Udah selesai? Ya ndak tau...</info>');

        $progressbar->finish();
    }
}
