<?php
/**
 * Created by PhpStorm.
 * User: Ulukut
 * Date: 26.12.2016
 * Time: 15:35
 *
 * @author Volkan Ulukut <arthan@gmail.com>
 */

namespace Ludwig\Tests\Models;

use Ludwig\Models\Challenger;
use Ludwig\Models\SQLiteDataSource;
use Ludwig\Tests\DbCase;

class ChallengerTest extends DbCase
{
    public function testQueryRandomChallenger()
    {
        $sutClass = new Challenger(new SQLiteDataSource());
        for ($i = 1; $i <= 10; $i++) {
            $challenger = $sutClass->queryRandomChallenger($i);
            $this->assertInstanceOf(Challenger::class, $challenger);
            $result = $challenger->toArray();
            $this->assertSame($i, $result['experience_rewards']);
        }
    }

    public function testGetterSetter()
    {
        $expected = [
            'id' => 1,
            'name' => 'test',
            'favorite_attribute' => 'Algorithms',
            'attribute_point' => 10,
            'experience_rewards' => 2
        ];
        $sutClass = new Challenger(new SQLiteDataSource());
        $sutClass->arrayToProperties($expected);
        $this->assertSame($expected, $sutClass->toArray());
    }
}
