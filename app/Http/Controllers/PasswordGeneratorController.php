<?php

namespace App\Http\Controllers;

use App\Http\Requests\GeneratorRequest;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;


class PasswordGeneratorController extends Controller
{

    const M = 3;
    const MIN_LENGTH = 6;
    const MAX_LENGTH = 50;

    public function Index(GeneratorRequest $request){

        try{
            $this->faker = \Faker\Factory::create();
            $strlength = (int)$request->passwordStrlength;
            $length = (int)$request->passwordLength;

            if($length < self::MIN_LENGTH || $length > self::MAX_LENGTH)
                throw new \Exception(sprintf('password length should be between %s and %s', self::MIN_LENGTH, self::MAX_LENGTH));

            if(!in_array($strlength, [1, 2, 3]))
                throw new \Exception(sprintf('password strlength should be between %s and %s', 1, 3));

            $methodName = ['first', 'second', 'third'][$strlength - 1];

            $this->numLength = 0;

            $password = $this->{$methodName}($length);


            return response()->json([
                'strlength' => $strlength,
                'length' => $length,
                'password' => $password,
                'methodName' => $methodName,
            ]);

        }catch(Throwable $ex){
            return response()->json([
                'error' => $ex->getMessage()
            ]);
        }
    }

    /**
     * first case
     *
     * @var int $length
     *
     * @return string
    */
    private function first(int $length){
        $first_passsword = $this->_bothLetters();
        $rand = rand(self::M, $length);
        $second_password = substr($this->_bothLetters($rand, $length - $rand), self::M);
        return join("", collect(str_split(sprintf('%s%s', $first_passsword, $second_password)))->shuffle()->all());
    }

    /**
     * second case
     *
     * @var int $length
     *
     * @return string
    */
    private function second(int $length){
        $first_passsword = $this->_bothLetters();
        $nums = substr(join("", collect(range(2, 5))->shuffle()->all()), rand(1, 3));
        $rand = rand(self::M, $length);
        $second_password = substr($this->_bothLetters($rand, $length - $rand), self::M + strlen($nums));
        return join("", collect(str_split(sprintf('%s%s%s', $first_passsword, $second_password, $nums)))->shuffle()->all());
    }


    /**
     * third case
     *
     * @var int $length
     *
     * @return string
    */
    private function third(int $length){
        $special_chars = '!$%&(){}[]=';
        $first_passsword = substr($special_chars, 1, rand(1, (int)round($length / 2)));
        $arr = range('a', 'z');
        shuffle($arr);
        $second_password = substr(join("", $arr), 0, $length - strlen($first_passsword));
        return join("", collect(str_split(sprintf('%s%s', $first_passsword, $second_password)))->shuffle()->all());
    }


    /**
     * helper method, used in first and second cases
     *
     * @var int $captalLenght
     * @var int $lowerLenght
     *
     * @return string
     */
    private function _bothLetters(int $capitalLength = 2, int $lowerLength = 1){
        $capital = $capitalLength?strtoupper($this->faker->lexify(join(preg_replace('/[0-9]+/', '?', range(1, $capitalLength))))):''  ;
        $lower = $lowerLength?$this->faker->lexify(join(preg_replace('/[0-9]+/', '?', range(1, $lowerLength)))):'';
        return join("", collect([...str_split($capital), ...str_split($lower)])->shuffle()->all());
    }

}
