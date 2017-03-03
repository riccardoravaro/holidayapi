<?php


use Illuminate\Database\Seeder;
use App\holidays;

class HolidaysSeeder extends Seeder {

    private $directory = 'database/data/';

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $directory = $this->directory;
        DB::table('holidays')->delete();
        $allfiles = File::allFiles($directory);
        foreach( $allfiles as $file) {
            $country = File::name($file);
            $json = File::get($file);
            $data = json_decode($json);

            foreach ($data as $obj) {
              $bank_holiday = trim($country) == 'GB' && (! strrpos($obj->name, "Bank Holiday") === FALSE) ? TRUE : FALSE;
              holidays::create(array(
                'name' => $obj->name,
                'rule' => $obj->rule,
                'country' => $country,
                'bank_holiday' => $bank_holiday
              ));
            }
        }
    }

}

?>
