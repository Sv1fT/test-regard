<?php

namespace App\Http\Controllers;

use App\Models\Manager;
use App\Models\Order;
use App\Test;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function test()
    {
        $managers = Manager::all();


        $this->print("######## ЗАДАЧА 1 ##########");
        $this->task1();
        $this->print("######## ЗАДАЧА 2 ##########");
        $this->task2();
        $this->print("######## ЗАДАЧА 3 ##########");
        $this->task3();
    }

    private function task1(){
        $a = new Test("a");
        $b = new Test("b");
        $c = new Test("c");
        $a->next = $b;
        $b->next = $c;
        $c->next = null;

        $this->print("До");
        $this->print($a);

        $ob1 = $this->reverse($a);
        $this->print("После");
        $this->print($ob1);

    }

    private function task2()
    {
        $orders = Order::with('manager')->take(50)->get();

        foreach ($orders as $order) {
            echo '<br>';
            echo 'order_id = '.$order->id.' '.$order->manager->fullname;
        }
    }

    private function task3()
    {
        // первые входные данные
        $boxes = [1, 2, 1, 5, 1, 3, 5, 2, 5, 5];
        $weight = 6;
        $maxCount = $this->getResult($boxes,$weight);
        echo '<br>максимальное количество рейсов = '.$maxCount;

        // вторые входные данные
        $boxes = [2,4,3,6,1];
        $weight = 5;
        $maxCount = $this->getResult($boxes,$weight);
        echo '<br>максимальное количество рейсов = '.$maxCount;
    }

    private function reverse($a)
    {
        $temp = clone($a);
        $lastObj = null;
        while($temp){
            $nextObj = $temp->next ;
            $temp->next = $lastObj;
            $lastObj = $temp;
            $temp = $nextObj;
        }
        return $lastObj;
    }

    public function getResult(array $boxes, int $weight): int
    {

        $arResult = [
            "normal",
            "not_normal"
        ];
        foreach ($boxes as $i => &$box1Weight){
            foreach ($boxes as $j => &$box2Weight){
                /*
                 * 1 - исключаем суммирование самого на себя $i != $j
                 * 2 - сумма должна быть = $weight
                 */
                if( $i != $j  && ($box1Weight + $box2Weight)  == $weight ){
                    $arResult["normal"][]  = "[{$i}] {$box1Weight} +  [{$j}] {$box2Weight} = {$weight}";
                    unset($boxes[$i]);
                    unset($boxes[$j]);
                    break;
                }
            }
        }
        /*
         * Не удовлетвовряющие условию элементы массива
         */
        $arResult['not_normal'] = $boxes;
        // $this->l($arResult);
        return count($arResult['normal']);
    }

    private function print($value){
        echo '<pre>';
        print_r($value);
        echo '</pre>';
    }
}
