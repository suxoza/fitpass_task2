<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PasswordTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */

    public function test_first_case(){
        $password = $this->_testCases(1);
        // password should contain at least 2 capital letter and at least 1 lower letter
        $this->assertMatchesRegularExpression('/(?=(.*[a-z]){1})(?=(.*[A-Z]){2})/', $password, 'first password is incorrect');
    }

    public function test_second_case(){
        $password = $this->_testCases(2);
        // password should contain at least 2 capital letter 1 lower letter and at least 1 number between 2 and 5, includding 2 and 5
        $this->assertMatchesRegularExpression('/(?=(.*[a-z]){1})(?=(.*[A-Z]){2})(.*[2-5]{1})/', $password, 'second password is incorrect');
    }

    public function test_third_case(){
        $password = $this->_testCases(3);
        // password should contain at least 2 capital letter 1 lower letter and at least 1 number between 2 and 5, includding 2 and 5
        $this->assertMatchesRegularExpression('/^(?=.*[@$!%*#?&])/', $password, 'third password in incorrect');
    }


    private function _testCases(int $strlength = 1){
        $rand = rand(6, 15);
        $response = $this->get("/api/generate/$strlength/".$rand);
        $data = (object)$response->dump()->json();

        // check received password`s length and if response has all required fields
        $this->assertObjectHasAttribute('password', $data, 'missing password field in response');
        $this->assertObjectHasAttribute('length', $data, 'missing lenght field in response');
        $this->assertTrue($data->length == $rand && strlen($data->password) == $rand, 'password lenght is incorrect');
        return $data->password;
    }
}
