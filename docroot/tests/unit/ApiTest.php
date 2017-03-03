<?php




use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ApiTest extends TestCase
{


		public static $setupDatabase = true;

    public function setUp()
    {
        parent::setUp();
        if(self::$setupDatabase)
        {
            $this->setupDatabase();
        }
    }

    public function setupDatabase()
    {

    		$this->artisan('migrate:reset');
	      $this->artisan('migrate');
	      $this->seed('HolidaysSeeder');

        self::$setupDatabase = false;
    }


	  public function tearDown()
	  {


	  }


	   /**
     * Test if return json
     *
     * @return void
     */
	  public function  test_if_return_json()
	  {

	    $this->json('GET','/api/v1/holidays?country=GB&year=2016')->seeJson();
    }

    public function  test_json_structure()
	  {

	    $this->json('GET','/api/v1/holidays?country=GB&year=2016')->seeJson()
	    ->seeJsonStructure([
	    	'status',
        'holidays' => [
          '*' => [['name', 'country', 'date']]
        ]
      ]);
    }

	   /**
     * Test if the country parameter is required.
     *
     * @return void
     */
	  public function  test_if_thecountry_parameter_is_required()
	  {

	    $this->json('GET','/api/v1/holidays?country=GB')
	    ->assertResponseStatus(400);
    }

    /**
     *  Test if the year parameter is required.
     *
     * @return void
     */
	  public function  test_if_year_parameter_is_required()
	  {

	    $this->json('GET','/api/v1/holidays?country=GB')
	    ->assertResponseStatus(400);

    }


    /**
     * Test if the bank_holiday parameter is not mandatory.
     *
     * @return void
     */
	  public function  test_if_bank_holiday_parameter_is_not_mandatory()
	  {

	    $this->json('GET','/api/v1/holidays?country=GB&year=2016')
	    ->assertResponseStatus(200);

    }


		/**
     * Test if the bank_holiday parameter is not mandatory.
     *
     * @return void
     */
	  public function  test_month_parameter()
	  {

	    $this->json('GET','/api/v1/holidays?country=US&year=2017&month=03')
	    ->assertResponseStatus(200)
	    ->seeJson(['date' => "2017-03-01",'date' => "2017-03-08",'date' => "2017-03-17",]);

	    $output = json_decode($this->response->getContent(), true);
	    $this->assertArrayHasKey('holidays', $output);
	    $this->assertTrue(3 === count($output['holidays']));


    }

    public function  test_month_json_structure()
	  {

	    $this->json('GET','/api/v1/holidays?country=US&year=2017&month=03')->seeJson()
	    ->seeJsonStructure([
	    	'status',
        'holidays' => [['name', 'country', 'date']]
      ]);
    }

    		/**
     * Test if the day parameter is not mandatory.
     *
     * @return void
     */
	  public function  test_day_parameter() {
		  $this->json('GET','/api/v1/holidays?country=GB&year=2016&month=1&day=1')
		    ->assertResponseStatus(200)
		    ->seeJson(['name' => "New Year's Day"]);
		  $output = json_decode($this->response->getContent(), true);
	    $this->assertTrue(1 === count($output['holidays']));

	  }


		/**
     * Test if the previous parameter is not mandatory.
     *
     * @return void
     */
	  public function  test_previous_parameter() {
	   //  name 'Boxing Day (possibly in lieu)'

	    $this->json('GET','/api/v1/holidays?country=GB&year=2016&month=1&day=1&previous')
		    ->assertResponseStatus(200)
		    ->seeJson(['name' => "Boxing Day (possibly in lieu)"]);
		  $output = json_decode($this->response->getContent(), true);
	    $this->assertTrue(1 === count($output['holidays']));

		}

		/**
     * Test if the upcoming parameter is not mandatory.
     *
     * @return void
     */
	  public function  test_upcoming_parameter() {
	  	// name 'Valentine's Day'

	    $this->json('GET','/api/v1/holidays?country=GB&year=2016&month=2&next')
		    ->assertResponseStatus(200)
		    ->seeJson(['name' => "Valentine's Day"]);
		  $output = json_decode($this->response->getContent(), true);
	    $this->assertTrue(1 === count($output['holidays']));

		}


    /**
     * Test if the bank holiday parameter works
     *
     * @return void
     */
	  public function  test_bank_holiday_parameter()
	  {

	    $this->json('GET','/api/v1/holidays?country=GB&year=2016&bank_holiday')
	    ->assertResponseStatus(200)
	    ->seeJson(['date' => "2016-05-02",'date' => "2016-05-30",'date' => "2016-08-29",]);

	    $output = json_decode($this->response->getContent(), true);
	    $this->assertArrayHasKey('holidays', $output);
	    $this->assertTrue(3 === count($output['holidays']));

    }




}
