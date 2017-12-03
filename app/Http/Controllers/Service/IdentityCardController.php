<?php

namespace App\Http\Controllers\Service;

use App\Http\Controllers\BaseController;
use Douyasi\IdentityCard\ID;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use LightSwoole\Framework\Request;

class IdentityCardController extends BaseController
{
    public function index()
    {
        $pid = Request::input('pid', '42032319930606629x');
        if ($pid) {
            $ID = new ID();
            $identity_card = $pid;
            $passed = $ID->validateIDCard($pid);
            $area = $ID->getArea($pid);
            $gender = $ID->getGender($pid);
            $birthday = $ID->getBirth($pid);
            $age = $ID->getAge($pid);
            $constellation = $ID->getConstellation($pid);
            return response_json([
                'status' => 1,
                'result' => compact('passed', 'identity_card', 'area', 'gender', 'birthday', 'age', 'constellation'),
            ]);
        } else {
            return response_json([
                'status' => 0,
                'result' => 'invaild identity-card number'
            ]);
        }
    }
}