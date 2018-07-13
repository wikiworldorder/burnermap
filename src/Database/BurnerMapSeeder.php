<?php 

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class BurnerMapSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return  void
     */
    public function run()
    {
        DB::table('TextSettings')->insert([
			'type'  => 'date01EarlyStart',
			'year'  => 2018,
			'value' => '2018-08-19'
		]);
		DB::table('TextSettings')->insert([
			'type'  => 'date02BurnStart',
			'year'  => 2018,
			'value' => '2018-08-26'
		]);
		DB::table('TextSettings')->insert([
			'type'  => 'date03BurningEnd',
			'year'  => 2018,
			'value' => '2018-09-03'
		]);
		DB::table('TextSettings')->insert([
			'type'  => 'date04LateLeave',
			'year'  => 2018,
			'value' => '2018-09-10'
		]);
		DB::table('TextSettings')->insert([
			'type'  => 'streetLet01Esplanade',
			'year'  => 2018,
			'value' => 'Esplanade'
		]);
		DB::table('TextSettings')->insert([
			'type'  => 'streetLet20A',
			'year'  => 2018,
			'value' => 'Algorithm'
		]);
		DB::table('TextSettings')->insert([
			'type'  => 'streetLet21B',
			'year'  => 2018,
			'value' => 'Bender'
		]);
		DB::table('TextSettings')->insert([
			'type'  => 'streetLet22C',
			'year'  => 2018,
			'value' => 'Cylon'
		]);
		DB::table('TextSettings')->insert([
			'type'  => 'streetLet23D',
			'year'  => 2018,
			'value' => 'Dewey'
		]);
		DB::table('TextSettings')->insert([
			'type'  => 'streetLet24E',
			'year'  => 2018,
			'value' => 'Elektro'
		]);
		DB::table('TextSettings')->insert([
			'type'  => 'streetLet25F',
			'year'  => 2018,
			'value' => 'Fribo'
		]);
		DB::table('TextSettings')->insert([
			'type'  => 'streetLet26G',
			'year'  => 2018,
			'value' => 'Gort'
		]);
		DB::table('TextSettings')->insert([
			'type'  => 'streetLet27H',
			'year'  => 2018,
			'value' => 'Hal'
		]);
		DB::table('TextSettings')->insert([
			'type'  => 'streetLet28I',
			'year'  => 2018,
			'value' => 'Iron Giant'
		]);
		DB::table('TextSettings')->insert([
			'type'  => 'streetLet29J',
			'year'  => 2018,
			'value' => 'Johnny 5'
		]);
		DB::table('TextSettings')->insert([
			'type'  => 'streetLet30K',
			'year'  => 2018,
			'value' => 'Kinoshita'
		]);
		DB::table('TextSettings')->insert([
			'type'  => 'streetLet31L',
			'year'  => 2018,
			'value' => 'Leon'
		]);
		DB::table('TextSettings')->insert([
			'type'  => 'streetLet32M',
			'year'  => 2018,
			'value' => 'M'
		]);
		DB::table('TextSettings')->insert([
			'type'  => 'streetLet33N',
			'year'  => 2018,
			'value' => 'N'
		]);
		DB::table('TextSettings')->insert([
			'type'  => 'streetLet40InnerCircle',
			'year'  => 2018,
			'value' => 'Center Camp Plaza'
		]);
		DB::table('TextSettings')->insert([
			'type'  => 'streetLet41RodsRoad',
			'year'  => 2018,
			'value' => 'Rods Road'
		]);
		DB::table('TextSettings')->insert([
			'type'  => 'streetLet42Portal',
			'year'  => 2018,
			'value' => 'Portal'
		]);
		DB::table('TextSettings')->insert([
			'type'  => 'streetLet43Plaza',
			'year'  => 2018,
			'value' => 'Plaza'
		]);
		DB::table('TextSettings')->insert([
			'type'  => 'streetLet44DeepPlaza',
			'year'  => 2018,
			'value' => 'Deep Plaza	'
		]);
		DB::table('TextSettings')->insert([
			'type'  => 'streetLet46WalkIn',
			'year'  => 2018,
			'value' => 'Walk-In Camping'
		]);
		DB::table('TextSettings')->insert([
			'type'  => 'streetLet47Landing',
			'year'  => 2018,
			'value' => 'Landing Strip'
		]);
		DB::table('TextSettings')->insert([
			'type'  => 'date01EarlyStart',
			'year'  => 2017,
			'value' => '2017-08-20'
		]);
		DB::table('TextSettings')->insert([
			'type'  => 'date02BurnStart',
			'year'  => 2017,
			'value' => '2017-08-27'
		]);
		DB::table('TextSettings')->insert([
			'type'  => 'date03BurningEnd',
			'year'  => 2017,
			'value' => '2017-09-04'
		]);
		DB::table('TextSettings')->insert([
			'type'  => 'date04LateLeave',
			'year'  => 2017,
			'value' => '2017-09-11'
		]);
		DB::table('TextSettings')->insert([
			'type'  => 'streetLet01Esplanade',
			'year'  => 2017,
			'value' => 'Esplanade'
		]);
		DB::table('TextSettings')->insert([
			'type'  => 'streetLet20A',
			'year'  => 2017,
			'value' => 'Awe'
		]);
		DB::table('TextSettings')->insert([
			'type'  => 'streetLet21B',
			'year'  => 2017,
			'value' => 'Breath'
		]);
		DB::table('TextSettings')->insert([
			'type'  => 'streetLet22C',
			'year'  => 2017,
			'value' => 'Ceremony'
		]);
		DB::table('TextSettings')->insert([
			'type'  => 'streetLet23D',
			'year'  => 2017,
			'value' => 'Dance'
		]);
		DB::table('TextSettings')->insert([
			'type'  => 'streetLet24E',
			'year'  => 2017,
			'value' => 'Eulogy'
		]);
		DB::table('TextSettings')->insert([
			'type'  => 'streetLet25F',
			'year'  => 2017,
			'value' => 'Fire'
		]);
		DB::table('TextSettings')->insert([
			'type'  => 'streetLet26G',
			'year'  => 2017,
			'value' => 'Genuflect'
		]);
		DB::table('TextSettings')->insert([
			'type'  => 'streetLet27H',
			'year'  => 2017,
			'value' => 'Hallowed'
		]);
		DB::table('TextSettings')->insert([
			'type'  => 'streetLet28I',
			'year'  => 2017,
			'value' => 'Inspirit'
		]);
		DB::table('TextSettings')->insert([
			'type'  => 'streetLet29J',
			'year'  => 2017,
			'value' => 'Juju'
		]);
		DB::table('TextSettings')->insert([
			'type'  => 'streetLet30K',
			'year'  => 2017,
			'value' => 'Kundalini'
		]);
		DB::table('TextSettings')->insert([
			'type'  => 'streetLet31L',
			'year'  => 2017,
			'value' => 'Lustrate'
		]);
		DB::table('TextSettings')->insert([
			'type'  => 'streetLet32M',
			'year'  => 2017,
			'value' => 'M'
		]);
		DB::table('TextSettings')->insert([
			'type'  => 'streetLet33N',
			'year'  => 2017,
			'value' => 'N'
		]);
		DB::table('TextSettings')->insert([
			'type'  => 'streetLet40InnerCircle',
			'year'  => 2017,
			'value' => 'Center Camp Plaza'
		]);
		DB::table('TextSettings')->insert([
			'type'  => 'streetLet41RodsRoad',
			'year'  => 2017,
			'value' => 'Rods Road'
		]);
		DB::table('TextSettings')->insert([
			'type'  => 'streetLet42Portal',
			'year'  => 2017,
			'value' => 'Portal'
		]);
		DB::table('TextSettings')->insert([
			'type'  => 'streetLet43Plaza',
			'year'  => 2017,
			'value' => 'Plaza'
		]);
		DB::table('TextSettings')->insert([
			'type'  => 'streetLet44DeepPlaza',
			'year'  => 2017,
			'value' => 'Deep Plaza'
		]);
		DB::table('TextSettings')->insert([
			'type'  => 'streetLet46WalkIn',
			'year'  => 2017,
			'value' => 'Walk-In Camping'
		]);
		DB::table('TextSettings')->insert([
			'type'  => 'streetLet47Landing',
			'year'  => 2017,
			'value' => 'Landing Strip'
		]);
		DB::table('TextSettings')->insert([
			'type'  => 'date01EarlyStart',
			'year'  => 2016,
			'value' => '2016-08-21'
		]);
		DB::table('TextSettings')->insert([
			'type'  => 'date02BurnStart',
			'year'  => 2016,
			'value' => '2016-08-28'
		]);
		DB::table('TextSettings')->insert([
			'type'  => 'date03BurningEnd',
			'year'  => 2016,
			'value' => '2016-09-05'
		]);
		DB::table('TextSettings')->insert([
			'type'  => 'date04LateLeave',
			'year'  => 2016,
			'value' => '2016-09-12'
		]);
		DB::table('TextSettings')->insert([
			'type'  => 'streetLet01Esplanade',
			'year'  => 2016,
			'value' => 'Esplanade'
		]);
		DB::table('TextSettings')->insert([
			'type'  => 'streetLet20A',
			'year'  => 2016,
			'value' => 'Arno'
		]);
		DB::table('TextSettings')->insert([
			'type'  => 'streetLet21B',
			'year'  => 2016,
			'value' => 'Botticelli'
		]);
		DB::table('TextSettings')->insert([
			'type'  => 'streetLet22C',
			'year'  => 2016,
			'value' => 'Cosimo'
		]);
		DB::table('TextSettings')->insert([
			'type'  => 'streetLet23D',
			'year'  => 2016,
			'value' => 'Donatello'
		]);
		DB::table('TextSettings')->insert([
			'type'  => 'streetLet24E',
			'year'  => 2016,
			'value' => 'Effigare'
		]);
		DB::table('TextSettings')->insert([
			'type'  => 'streetLet25F',
			'year'  => 2016,
			'value' => 'Florin'
		]);
		DB::table('TextSettings')->insert([
			'type'  => 'streetLet26G',
			'year'  => 2016,
			'value' => 'Guild'
		]);
		DB::table('TextSettings')->insert([
			'type'  => 'streetLet27H',
			'year'  => 2016,
			'value' => 'High Renaissance'
		]);
		DB::table('TextSettings')->insert([
			'type'  => 'streetLet28I',
			'year'  => 2016,
			'value' => 'Italic'
		]);
		DB::table('TextSettings')->insert([
			'type'  => 'streetLet29J',
			'year'  => 2016,
			'value' => 'Justice'
		]);
		DB::table('TextSettings')->insert([
			'type'  => 'streetLet30K',
			'year'  => 2016,
			'value' => 'Knowledge'
		]);
		DB::table('TextSettings')->insert([
			'type'  => 'streetLet31L',
			'year'  => 2016,
			'value' => 'Lorenzo'
		]);
		DB::table('TextSettings')->insert([
			'type'  => 'streetLet32M',
			'year'  => 2016,
			'value' => 'M'
		]);
		DB::table('TextSettings')->insert([
			'type'  => 'streetLet33N',
			'year'  => 2016,
			'value' => 'N'
		]);
		DB::table('TextSettings')->insert([
			'type'  => 'streetLet40InnerCircle',
			'year'  => 2016,
			'value' => 'Inner Circle'
		]);
		DB::table('TextSettings')->insert([
			'type'  => 'streetLet41RodsRoad',
			'year'  => 2016,
			'value' => 'Rods Road'
		]);
		DB::table('TextSettings')->insert([
			'type'  => 'streetLet42Portal',
			'year'  => 2016,
			'value' => 'Portal'
		]);
		DB::table('TextSettings')->insert([
			'type'  => 'streetLet43Plaza',
			'year'  => 2016,
			'value' => 'Plaza'
		]);
		DB::table('TextSettings')->insert([
			'type'  => 'streetLet44DeepPlaza',
			'year'  => 2016,
			'value' => 'Deep Plaza'
		]);
		DB::table('TextSettings')->insert([
			'type'  => 'streetLet46WalkIn',
			'year'  => 2016,
			'value' => 'Walk-In Camping'
		]);
		DB::table('TextSettings')->insert([
			'type'  => 'streetLet47Landing',
			'year'  => 2016,
			'value' => 'Landing Strip'
		]);
		DB::table('TextSettings')->insert([
			'type'  => 'date01EarlyStart',
			'year'  => 2015,
			'value' => '2015-08-23'
		]);
		DB::table('TextSettings')->insert([
			'type'  => 'date02BurnStart',
			'year'  => 2015,
			'value' => '2015-08-30'
		]);
		DB::table('TextSettings')->insert([
			'type'  => 'date03BurningEnd',
			'year'  => 2015,
			'value' => '2015-09-08'
		]);
		DB::table('TextSettings')->insert([
			'type'  => 'date04LateLeave',
			'year'  => 2015,
			'value' => '2015-09-16'
		]);
		DB::table('TextSettings')->insert([
			'type'  => 'streetLet01Esplanade',
			'year'  => 2015,
			'value' => 'Esplanade'
		]);
		DB::table('TextSettings')->insert([
			'type'  => 'streetLet20A',
			'year'  => 2015,
			'value' => 'Arcade'
		]);
		DB::table('TextSettings')->insert([
			'type'  => 'streetLet21B',
			'year'  => 2015,
			'value' => 'Ballyhoo'
		]);
		DB::table('TextSettings')->insert([
			'type'  => 'streetLet22C',
			'year'  => 2015,
			'value' => 'Carny'
		]);
		DB::table('TextSettings')->insert([
			'type'  => 'streetLet23D',
			'year'  => 2015,
			'value' => 'Donniker'
		]);
		DB::table('TextSettings')->insert([
			'type'  => 'streetLet24E',
			'year'  => 2015,
			'value' => 'Ersatz'
		]);
		DB::table('TextSettings')->insert([
			'type'  => 'streetLet25F',
			'year'  => 2015,
			'value' => 'Freak Show'
		]);
		DB::table('TextSettings')->insert([
			'type'  => 'streetLet26G',
			'year'  => 2015,
			'value' => 'Geek'
		]);
		DB::table('TextSettings')->insert([
			'type'  => 'streetLet27H',
			'year'  => 2015,
			'value' => 'Hanky Pank'
		]);
		DB::table('TextSettings')->insert([
			'type'  => 'streetLet28I',
			'year'  => 2015,
			'value' => 'Illusion'
		]);
		DB::table('TextSettings')->insert([
			'type'  => 'streetLet29J',
			'year'  => 2015,
			'value' => 'Jolly'
		]);
		DB::table('TextSettings')->insert([
			'type'  => 'streetLet30K',
			'year'  => 2015,
			'value' => 'Kook'
		]);
		DB::table('TextSettings')->insert([
			'type'  => 'streetLet31L',
			'year'  => 2015,
			'value' => 'Laffing Sal'
		]);
		DB::table('TextSettings')->insert([
			'type'  => 'streetLet32M',
			'year'  => 2015,
			'value' => 'M'
		]);
		DB::table('TextSettings')->insert([
			'type'  => 'streetLet33N',
			'year'  => 2015,
			'value' => 'N'
		]);
		DB::table('TextSettings')->insert([
			'type'  => 'streetLet40InnerCircle',
			'year'  => 2015,
			'value' => 'Inner Circle'
		]);
		DB::table('TextSettings')->insert([
			'type'  => 'streetLet41RodsRoad',
			'year'  => 2015,
			'value' => 'Rods Road'
		]);
		DB::table('TextSettings')->insert([
			'type'  => 'streetLet42Portal',
			'year'  => 2015,
			'value' => 'Portal'
		]);
		DB::table('TextSettings')->insert([
			'type'  => 'streetLet43Plaza',
			'year'  => 2015,
			'value' => 'Plaza'
		]);
		DB::table('TextSettings')->insert([
			'type'  => 'streetLet44DeepPlaza',
			'year'  => 2015,
			'value' => 'Deep Plaza'
		]);
		DB::table('TextSettings')->insert([
			'type'  => 'streetLet46WalkIn',
			'year'  => 2015,
			'value' => 'Walk-In Camping'
		]);
		DB::table('TextSettings')->insert([
			'type'  => 'streetLet47Landing',
			'year'  => 2015,
			'value' => 'Landing Strip'
		]);
		DB::table('TextSettings')->insert([
			'type'  => 'date01EarlyStart',
			'year'  => 2014,
			'value' => '2014-08-18'
		]);
		DB::table('TextSettings')->insert([
			'type'  => 'date02BurnStart',
			'year'  => 2014,
			'value' => '2014-08-25'
		]);
		DB::table('TextSettings')->insert([
			'type'  => 'date03BurningEnd',
			'year'  => 2014,
			'value' => '2014-09-01'
		]);
		DB::table('TextSettings')->insert([
			'type'  => 'date04LateLeave',
			'year'  => 2014,
			'value' => '2014-09-10'
		]);
		DB::table('TextSettings')->insert([
			'type'  => 'streetLet01Esplanade',
			'year'  => 2014,
			'value' => 'Esplanade'
		]);
		DB::table('TextSettings')->insert([
			'type'  => 'streetLet20A',
			'year'  => 2014,
			'value' => 'Antioch'
		]);
		DB::table('TextSettings')->insert([
			'type'  => 'streetLet21B',
			'year'  => 2014,
			'value' => 'Basra'
		]);
		DB::table('TextSettings')->insert([
			'type'  => 'streetLet22C',
			'year'  => 2014,
			'value' => 'Cinnamon'
		]);
		DB::table('TextSettings')->insert([
			'type'  => 'streetLet23D',
			'year'  => 2014,
			'value' => 'Darjeeling'
		]);
		DB::table('TextSettings')->insert([
			'type'  => 'streetLet24E',
			'year'  => 2014,
			'value' => 'Ephesus'
		]);
		DB::table('TextSettings')->insert([
			'type'  => 'streetLet25F',
			'year'  => 2014,
			'value' => 'Frankincense'
		]);
		DB::table('TextSettings')->insert([
			'type'  => 'streetLet26G',
			'year'  => 2014,
			'value' => 'Gold'
		]);
		DB::table('TextSettings')->insert([
			'type'  => 'streetLet27H',
			'year'  => 2014,
			'value' => 'Haifa'
		]);
		DB::table('TextSettings')->insert([
			'type'  => 'streetLet28I',
			'year'  => 2014,
			'value' => 'Isfahan'
		]);
		DB::table('TextSettings')->insert([
			'type'  => 'streetLet29J',
			'year'  => 2014,
			'value' => 'Jade'
		]);
		DB::table('TextSettings')->insert([
			'type'  => 'streetLet30K',
			'year'  => 2014,
			'value' => 'Kandahar'
		]);
		DB::table('TextSettings')->insert([
			'type'  => 'streetLet31L',
			'year'  => 2014,
			'value' => 'Lapis Lazuli'
		]);
		DB::table('TextSettings')->insert([
			'type'  => 'streetLet32M',
			'year'  => 2014,
			'value' => 'M'
		]);
		DB::table('TextSettings')->insert([
			'type'  => 'streetLet33N',
			'year'  => 2014,
			'value' => 'N'
		]);
		DB::table('TextSettings')->insert([
			'type'  => 'streetLet40InnerCircle',
			'year'  => 2014,
			'value' => 'Inner Circle'
		]);
		DB::table('TextSettings')->insert([
			'type'  => 'streetLet41RodsRoad',
			'year'  => 2014,
			'value' => 'Rods Road'
		]);
		DB::table('TextSettings')->insert([
			'type'  => 'streetLet42Portal',
			'year'  => 2014,
			'value' => 'Portal'
		]);
		DB::table('TextSettings')->insert([
			'type'  => 'streetLet43Plaza',
			'year'  => 2014,
			'value' => 'Plaza'
		]);
		DB::table('TextSettings')->insert([
			'type'  => 'streetLet44DeepPlaza',
			'year'  => 2014,
			'value' => 'Deep Plaza'
		]);
		DB::table('TextSettings')->insert([
			'type'  => 'streetLet46WalkIn',
			'year'  => 2014,
			'value' => 'Walk-In Camping'
		]);
		DB::table('TextSettings')->insert([
			'type'  => 'streetLet47Landing',
			'year'  => 2014,
			'value' => 'Landing Strip'
		]);
		DB::table('TextSettings')->insert([
			'type'  => 'date01EarlyStart',
			'year'  => 2013,
			'value' => '2013-08-19'
		]);
		DB::table('TextSettings')->insert([
			'type'  => 'date02BurnStart',
			'year'  => 2013,
			'value' => '2013-08-26'
		]);
		DB::table('TextSettings')->insert([
			'type'  => 'date03BurningEnd',
			'year'  => 2013,
			'value' => '2013-09-02'
		]);
		DB::table('TextSettings')->insert([
			'type'  => 'date04LateLeave',
			'year'  => 2013,
			'value' => '2013-09-11'
		]);
		DB::table('TextSettings')->insert([
			'type'  => 'streetLet01Esplanade',
			'year'  => 2013,
			'value' => 'Esplanade'
		]);
		DB::table('TextSettings')->insert([
			'type'  => 'streetLet20A',
			'year'  => 2013,
			'value' => 'Airstrip'
		]);
		DB::table('TextSettings')->insert([
			'type'  => 'streetLet21B',
			'year'  => 2013,
			'value' => 'Biggie Size'
		]);
		DB::table('TextSettings')->insert([
			'type'  => 'streetLet22C',
			'year'  => 2013,
			'value' => 'Consumer'
		]);
		DB::table('TextSettings')->insert([
			'type'  => 'streetLet23D',
			'year'  => 2013,
			'value' => 'Desiderata'
		]);
		DB::table('TextSettings')->insert([
			'type'  => 'streetLet24E',
			'year'  => 2013,
			'value' => 'Extraterrestrial'
		]);
		DB::table('TextSettings')->insert([
			'type'  => 'streetLet25F',
			'year'  => 2013,
			'value' => 'False Idol'
		]);
		DB::table('TextSettings')->insert([
			'type'  => 'streetLet26G',
			'year'  => 2013,
			'value' => 'GDP'
		]);
		DB::table('TextSettings')->insert([
			'type'  => 'streetLet27H',
			'year'  => 2013,
			'value' => 'Holy'
		]);
		DB::table('TextSettings')->insert([
			'type'  => 'streetLet28I',
			'year'  => 2013,
			'value' => 'Insterstellar'
		]);
		DB::table('TextSettings')->insert([
			'type'  => 'streetLet29J',
			'year'  => 2013,
			'value' => 'John Frum'
		]);
		DB::table('TextSettings')->insert([
			'type'  => 'streetLet30K',
			'year'  => 2013,
			'value' => 'Kowtow'
		]);
		DB::table('TextSettings')->insert([
			'type'  => 'streetLet31L',
			'year'  => 2013,
			'value' => 'Laissez-faire'
		]);
		DB::table('TextSettings')->insert([
			'type'  => 'streetLet32M',
			'year'  => 2013,
			'value' => 'Magic'
		]);
		DB::table('TextSettings')->insert([
			'type'  => 'streetLet33N',
			'year'  => 2013,
			'value' => 'N'
		]);
		DB::table('TextSettings')->insert([
			'type'  => 'streetLet40InnerCircle',
			'year'  => 2013,
			'value' => 'Inner Circle'
		]);
		DB::table('TextSettings')->insert([
			'type'  => 'streetLet41RodsRoad',
			'year'  => 2013,
			'value' => 'Rods Road'
		]);
		DB::table('TextSettings')->insert([
			'type'  => 'streetLet42Portal',
			'year'  => 2013,
			'value' => 'Portal'
		]);
		DB::table('TextSettings')->insert([
			'type'  => 'streetLet43Plaza',
			'year'  => 2013,
			'value' => 'Plaza'
		]);
		DB::table('TextSettings')->insert([
			'type'  => 'streetLet44DeepPlaza',
			'year'  => 2013,
			'value' => 'Deep Plaza'
		]);
		DB::table('TextSettings')->insert([
			'type'  => 'streetLet46WalkIn',
			'year'  => 2013,
			'value' => 'Walk-In Camping'
		]);
		DB::table('TextSettings')->insert([
			'type'  => 'streetLet47Landing',
			'year'  => 2013,
			'value' => 'Landing Strip'
		]);
		DB::table('TextSettings')->insert([
			'type'  => 'date01EarlyStart',
			'year'  => 2012,
			'value' => '2012-08-19'
		]);
		DB::table('TextSettings')->insert([
			'type'  => 'date02BurnStart',
			'year'  => 2012,
			'value' => '2012-08-26'
		]);
		DB::table('TextSettings')->insert([
			'type'  => 'date03BurningEnd',
			'year'  => 2012,
			'value' => '2012-09-02'
		]);
		DB::table('TextSettings')->insert([
			'type'  => 'date04LateLeave',
			'year'  => 2012,
			'value' => '2012-09-11'
		]);
		DB::table('TextSettings')->insert([
			'type'  => 'streetLet01Esplanade',
			'year'  => 2012,
			'value' => 'Esplanade'
		]);
		DB::table('TextSettings')->insert([
			'type'  => 'streetLet20A',
			'year'  => 2012,
			'value' => 'Alyssum'
		]);
		DB::table('TextSettings')->insert([
			'type'  => 'streetLet21B',
			'year'  => 2012,
			'value' => 'Begonia'
		]);
		DB::table('TextSettings')->insert([
			'type'  => 'streetLet22C',
			'year'  => 2012,
			'value' => 'Columbine'
		]);
		DB::table('TextSettings')->insert([
			'type'  => 'streetLet23D',
			'year'  => 2012,
			'value' => 'Dandelion'
		]);
		DB::table('TextSettings')->insert([
			'type'  => 'streetLet24E',
			'year'  => 2012,
			'value' => 'Edelweiss'
		]);
		DB::table('TextSettings')->insert([
			'type'  => 'streetLet25F',
			'year'  => 2012,
			'value' => 'Foxglove'
		]);
		DB::table('TextSettings')->insert([
			'type'  => 'streetLet26G',
			'year'  => 2012,
			'value' => 'Geranium'
		]);
		DB::table('TextSettings')->insert([
			'type'  => 'streetLet27H',
			'year'  => 2012,
			'value' => 'Hyacinth'
		]);
		DB::table('TextSettings')->insert([
			'type'  => 'streetLet28I',
			'year'  => 2012,
			'value' => 'Iris'
		]);
		DB::table('TextSettings')->insert([
			'type'  => 'streetLet29J',
			'year'  => 2012,
			'value' => 'Jasmine'
		]);
		DB::table('TextSettings')->insert([
			'type'  => 'streetLet30K',
			'year'  => 2012,
			'value' => 'Kingcup'
		]);
		DB::table('TextSettings')->insert([
			'type'  => 'streetLet31L',
			'year'  => 2012,
			'value' => 'Lilac'
		]);
		DB::table('TextSettings')->insert([
			'type'  => 'streetLet32M',
			'year'  => 2012,
			'value' => 'M'
		]);
		DB::table('TextSettings')->insert([
			'type'  => 'streetLet33N',
			'year'  => 2012,
			'value' => 'N'
		]);
		DB::table('TextSettings')->insert([
			'type'  => 'streetLet40InnerCircle',
			'year'  => 2012,
			'value' => 'Inner Circle'
		]);
		DB::table('TextSettings')->insert([
			'type'  => 'streetLet41RodsRoad',
			'year'  => 2012,
			'value' => 'Rods Road'
		]);
		DB::table('TextSettings')->insert([
			'type'  => 'streetLet42Portal',
			'year'  => 2012,
			'value' => 'Portal'
		]);
		DB::table('TextSettings')->insert([
			'type'  => 'streetLet43Plaza',
			'year'  => 2012,
			'value' => 'Plaza'
		]);
		DB::table('TextSettings')->insert([
			'type'  => 'streetLet44DeepPlaza',
			'year'  => 2012,
			'value' => 'Deep Plaza'
		]);
		DB::table('TextSettings')->insert([
			'type'  => 'streetLet46WalkIn',
			'year'  => 2012,
			'value' => 'Walk-In Camping'
		]);
		DB::table('TextSettings')->insert([
			'type'  => 'streetLet47Landing',
			'year'  => 2012,
			'value' => 'Landing Strip'
		]);
		DB::table('TextSettings')->insert([
			'type'  => 'date01EarlyStart',
			'year'  => 2011,
			'value' => '2011-08-19'
		]);
		DB::table('TextSettings')->insert([
			'type'  => 'date02BurnStart',
			'year'  => 2011,
			'value' => '2011-08-26'
		]);
		DB::table('TextSettings')->insert([
			'type'  => 'date03BurningEnd',
			'year'  => 2011,
			'value' => '2011-09-02'
		]);
		DB::table('TextSettings')->insert([
			'type'  => 'date04LateLeave',
			'year'  => 2011,
			'value' => '2011-09-11'
		]);
		DB::table('TextSettings')->insert([
			'type'  => 'streetLet01Esplanade',
			'year'  => 2011,
			'value' => 'Esplanade'
		]);
		DB::table('TextSettings')->insert([
			'type'  => 'streetLet20A',
			'year'  => 2011,
			'value' => 'Anniversary'
		]);
		DB::table('TextSettings')->insert([
			'type'  => 'streetLet21B',
			'year'  => 2011,
			'value' => 'Birthday'
		]);
		DB::table('TextSettings')->insert([
			'type'  => 'streetLet22C',
			'year'  => 2011,
			'value' => 'Coming Out'
		]);
		DB::table('TextSettings')->insert([
			'type'  => 'streetLet23D',
			'year'  => 2011,
			'value' => 'Divorse'
		]);
		DB::table('TextSettings')->insert([
			'type'  => 'streetLet24E',
			'year'  => 2011,
			'value' => 'Engagement'
		]);
		DB::table('TextSettings')->insert([
			'type'  => 'streetLet25F',
			'year'  => 2011,
			'value' => 'Funeral'
		]);
		DB::table('TextSettings')->insert([
			'type'  => 'streetLet26G',
			'year'  => 2011,
			'value' => 'Graduation'
		]);
		DB::table('TextSettings')->insert([
			'type'  => 'streetLet27H',
			'year'  => 2011,
			'value' => 'Hajj'
		]);
		DB::table('TextSettings')->insert([
			'type'  => 'streetLet28I',
			'year'  => 2011,
			'value' => 'Initiation'
		]);
		DB::table('TextSettings')->insert([
			'type'  => 'streetLet29J',
			'year'  => 2011,
			'value' => 'Journey'
		]);
		DB::table('TextSettings')->insert([
			'type'  => 'streetLet30K',
			'year'  => 2011,
			'value' => 'Kindergarten'
		]);
		DB::table('TextSettings')->insert([
			'type'  => 'streetLet31L',
			'year'  => 2011,
			'value' => 'Liminal'
		]);
		DB::table('TextSettings')->insert([
			'type'  => 'streetLet32M',
			'year'  => 2011,
			'value' => 'M'
		]);
		DB::table('TextSettings')->insert([
			'type'  => 'streetLet33N',
			'year'  => 2011,
			'value' => 'N'
		]);
		DB::table('TextSettings')->insert([
			'type'  => 'streetLet40InnerCircle',
			'year'  => 2011,
			'value' => 'Inner Circle'
		]);
		DB::table('TextSettings')->insert([
			'type'  => 'streetLet41RodsRoad',
			'year'  => 2011,
			'value' => 'Rods Road'
		]);
		DB::table('TextSettings')->insert([
			'type'  => 'streetLet42Portal',
			'year'  => 2011,
			'value' => 'Portal'
		]);
		DB::table('TextSettings')->insert([
			'type'  => 'streetLet43Plaza',
			'year'  => 2011,
			'value' => 'Plaza'
		]);
		DB::table('TextSettings')->insert([
			'type'  => 'streetLet44DeepPlaza',
			'year'  => 2011,
			'value' => 'Deep Plaza'
		]);
		DB::table('TextSettings')->insert([
			'type'  => 'streetLet46WalkIn',
			'year'  => 2011,
			'value' => 'Walk-In Camping'
		]);
		DB::table('TextSettings')->insert([
			'type'  => 'streetLet47Landing',
			'year'  => 2011,
			'value' => 'Landing Strip'
		]);
		DB::table('Totals')->insert([
			'type'  => 'avgCampSize',
			'value' => 0
		]);
		DB::table('Totals')->insert([
			'type'  => 'map-10a-x',
			'value' => 211
		]);
		DB::table('Totals')->insert([
			'type'  => 'map-10a-y',
			'value' => 116
		]);
		DB::table('Totals')->insert([
			'type'  => 'map-10b-x',
			'value' => 200
		]);
		DB::table('Totals')->insert([
			'type'  => 'map-10b-y',
			'value' => 109
		]);
		DB::table('Totals')->insert([
			'type'  => 'map-10c-x',
			'value' => 189
		]);
		DB::table('Totals')->insert([
			'type'  => 'map-10c-y',
			'value' => 102
		]);
		DB::table('Totals')->insert([
			'type'  => 'map-10d-x',
			'value' => 176
		]);
		DB::table('Totals')->insert([
			'type'  => 'map-10d-y',
			'value' => 94
		]);
		DB::table('Totals')->insert([
			'type'  => 'map-10e-x',
			'value' => 166
		]);
		DB::table('Totals')->insert([
			'type'  => 'map-10e-y',
			'value' => 89
		]);
		DB::table('Totals')->insert([
			'type'  => 'map-10esp-x',
			'value' => 232
		]);
		DB::table('Totals')->insert([
			'type'  => 'map-10esp-y',
			'value' => 126
		]);
		DB::table('Totals')->insert([
			'type'  => 'map-10f-x',
			'value' => 155
		]);
		DB::table('Totals')->insert([
			'type'  => 'map-10f-y',
			'value' => 82
		]);
		DB::table('Totals')->insert([
			'type'  => 'map-10g-x',
			'value' => 143
		]);
		DB::table('Totals')->insert([
			'type'  => 'map-10g-y',
			'value' => 76
		]);
		DB::table('Totals')->insert([
			'type'  => 'map-10h-x',
			'value' => 132
		]);
		DB::table('Totals')->insert([
			'type'  => 'map-10h-y',
			'value' => 70
		]);
		DB::table('Totals')->insert([
			'type'  => 'map-10i-x',
			'value' => 121
		]);
		DB::table('Totals')->insert([
			'type'  => 'map-10i-y',
			'value' => 63
		]);
		DB::table('Totals')->insert([
			'type'  => 'map-10j-x',
			'value' => 109
		]);
		DB::table('Totals')->insert([
			'type'  => 'map-10j-y',
			'value' => 56
		]);
		DB::table('Totals')->insert([
			'type'  => 'map-10k-x',
			'value' => 98
		]);
		DB::table('Totals')->insert([
			'type'  => 'map-10k-y',
			'value' => 49
		]);
		DB::table('Totals')->insert([
			'type'  => 'map-10l-x',
			'value' => 85
		]);
		DB::table('Totals')->insert([
			'type'  => 'map-10l-y',
			'value' => 43
		]);
		DB::table('Totals')->insert([
			'type'  => 'map-10m-x',
			'value' => 78
		]);
		DB::table('Totals')->insert([
			'type'  => 'map-10m-y',
			'value' => 41
		]);
		DB::table('Totals')->insert([
			'type'  => 'map-10n-x',
			'value' => 71
		]);
		DB::table('Totals')->insert([
			'type'  => 'map-10n-y',
			'value' => 38
		]);
		DB::table('Totals')->insert([
			'type'  => 'map-10w-x',
			'value' => 64
		]);
		DB::table('Totals')->insert([
			'type'  => 'map-10w-y',
			'value' => 35
		]);
		DB::table('Totals')->insert([
			'type'  => 'map-center-x',
			'value' => 349
		]);
		DB::table('Totals')->insert([
			'type'  => 'map-center-y',
			'value' => 194
		]);
		DB::table('Totals')->insert([
			'type'  => 'map-inner-12-x',
			'value' => 350
		]);
		DB::table('Totals')->insert([
			'type'  => 'map-inner-12-y',
			'value' => 335
		]);
		DB::table('Totals')->insert([
			'type'  => 'map-rod-12-x',
			'value' => 350
		]);
		DB::table('Totals')->insert([
			'type'  => 'map-rod-12-y',
			'value' => 310
		]);
		DB::table('Totals')->insert([
			'type'  => 'map-rod-center-x',
			'value' => 349
		]);
		DB::table('Totals')->insert([
			'type'  => 'map-rod-center-y',
			'value' => 354
		]);
		DB::table('Totals')->insert([
			'type'  => 'netCampId',
			'value' => 14
		]);
		DB::table('Totals')->insert([
			'type'  => 'ticketExtra',
			'value' => 0
		]);
		DB::table('Totals')->insert([
			'type'  => 'ticketNeeds',
			'value' => 0
		]);
		DB::table('Totals')->insert([
			'type'  => 'totActiveCamps',
			'value' => 0
		]);
		DB::table('Totals')->insert([
			'type'  => 'totCurrUsers',
			'value' => 0
		]);
		DB::table('Totals')->insert([
			'type'  => 'totUsers',
			'value' => 0
		]);
    }
}
