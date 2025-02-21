<?php

class Fin_test extends TestCase
{
    public function setUp()
    {
        $this->obj = $this->newModel('User_model');
    }

    public function test_find_place()
    {
        $sum = 12;
        $uid = 8;
        $res = $this->obj->hasEnoughFunds($sum, $uid);
        $this->assertEquals(true, $res);

        $sum = 1200;
        $uid = 8;
        $res = $this->obj->hasEnoughFunds($sum, $uid);
        $this->assertEquals(false, $res);

        $sum = 12;
        $uid = 9;
        $res = $this->obj->hasEnoughFunds($sum, $uid);
        $this->assertEquals(false, $res);

        $sum = 156.95;
        $uid = 8;
        $res = $this->obj->hasEnoughFunds($sum, $uid);
        $this->assertEquals(true, $res);
    }
}