<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;
use App\Http\Controllers\RESTfulController;
use App\Actor;

class RestfulControllerTest extends TestCase
{

    public function testInstantiation()
    {
        $controller = new RESTfulController();
        $this->assertIsObject($controller);
    }

    public function testFilterOptions()
    {
        $controller = new RESTfulController();
        $model = new Actor();

        $options = $controller->getFilterOptions($model);

        $this->assertIsArray($options);

        $this->assertArrayHasKey('first_name', $options);
        $this->assertArrayHasKey('last_name', $options);
        $this->assertArrayHasKey('last_update', $options);

    }

    public function testValidateFilterQueryWithBadValues() 
    {
        $controller = new RESTfulController();
        $model = new Actor();
        $filterOptions = $controller->getFilterOptions($model);
        $badValues = [null, 0, 1, -1, ['a'], new stdClass, true, false, '', ' '];
        foreach ($filterOptions as $options) {
            foreach ($options as $opt) {
                $key = str_replace('=VALUE', '', $opt);
                foreach ($badValues as $value) {
                    $status = $controller->validateFilterQuery($model, $key, $value);
                    $this->assertFalse($status);
                }                
            }
        }
    }

    public function testValidateFilterQueryWithGoodValues() 
    {
        $controller = new RESTfulController();
        $model = new Actor();
        $filterOptions = $controller->getFilterOptions($model);
        $goodValues = ['0', '1', '-1', '1.543', '2020-01-01', 'abc', 'true', 'false'];
        foreach ($filterOptions as $options) {
            foreach ($options as $opt) {
                $key = str_replace('=VALUE', '', $opt);
                foreach ($goodValues as $value) {
                    $status = $controller->validateFilterQuery($model, $key, $value);
                    $this->assertTrue($status);
                }
            }
        }
    }


}
