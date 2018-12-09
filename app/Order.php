<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $guarded = ['id'];

    public function bussinesstypetable(){
        $this->morphTo();
    }

    private function generateRandomOrderNumber(){
        $digits = 10;
        $ordernumber = "";
        $count = 0;
        while ( $count < $digits ) {
            $random_digit = mt_rand(0, 9);
            
            $ordernumber .= $random_digit;
            $count++;
        }

        return $ordernumber;
    }

    /**
     * Mapping all order data from prepaid and prodcomm
     *
     * @return array
     */
    public function getOrders($customerId){
        $allOrders = Order::where('custommer_id', $customerId)->orderBy('created_at', 'DESC')->get();
        $mappedData = array();
        $mappedData['data'] = array();

        foreach($allOrders as $order){
            $item = array();
            $item['order_number'] = $order->order_number;
            $item['custommer_id'] = $order->custommer_id;
            
            /* For prepaid ballance */
            if($order->bussinesstypetable_type == "App\Prepaid"){
                $prepaids = Prepaid::where("id", $order->bussinesstypetable_id)->firstOrFail();
                $totalValueInt = intval($prepaids->value);
                $totalValue = $totalValueInt + (5/100 * $totalValueInt);
                $item['description'] = "<b>".number_format($prepaids->value)."</b>"." For "."<b>".$prepaids->mobile_phone."</b>";
                $item['total'] = number_format($totalValue);
                $item['information'] = $prepaids->status;
            }
            
            /* for product commerce */
            if($order->bussinesstypetable_type == "App\Prodcomm"){
                $prodcomm = Prodcomm::where("id", $order->bussinesstypetable_id)->firstOrFail();
                $totalPriceInt = intval($prodcomm->price);
                $totalPrice = $totalPriceInt + 10000;
                $item['description'] = "<b>".$prodcomm->product."</b>"." that cost "."<b>".number_format($prodcomm->price)."</b>";
                $item['total'] = number_format($totalPrice);

                if($prodcomm->status == ""){
                    $item['information'] = "";
                }else if($prodcomm->status == "Success"){
                    $item['information'] = 'Shipping code : '.$prodcomm->shipping_code;
                }else {
                    $item['information'] = $prodcomm->status;
                }
            }

            /* generate button pay */
            if($item['information'] == ""){
                $item['information'] = "<a href='/payment/". $item['order_number']."'><button>Pay</button></a>" ;
            }

            array_push($mappedData['data'], $item);
        }
        
        return $mappedData;
    }

    public function createOrder($order, $businessTypeData){
        $response = [];

        $ordernumber = $this->generateRandomOrderNumber();
        $order['order_number'] = $ordernumber;
        
        Order::create($order);

        /* For prepaid balance or product commerce order confirmation */
        if($order['bussinesstypetable_type'] == "App\Prepaid"){
            $integerValue = intval($businessTypeData['value']);
            $numberFormatValue = number_format($businessTypeData['value']);
            $mobilePhone = $businessTypeData['mobile_phone'];

            $response['description'] = "Your Mobile Phone Number ".$mobilePhone." will be topped up for ".$numberFormatValue;
            $response['total'] = $integerValue + (5/100 * $integerValue);
            
        }else if($order['bussinesstypetable_type'] == "App\Prodcomm"){
            $integerPrice = intval($businessTypeData['price']);
            $numberFormatPrice = number_format($businessTypeData['price']);
            $product = $businessTypeData['product'];
            $address = $businessTypeData['shipping_address'];

            $response['description'] = $product." that cost ".$numberFormatPrice." will be shipped to ".$address." after you pay";
            $response['total'] = $integerPrice + 10000;
        }

        $response['ordernumber'] = $ordernumber;

        return $response;
    }

    public function updateOrder($ordernumber){
        $Order = Order::where("order_number", $ordernumber)->firstOrFail();
        if($Order->bussinesstypetable_type == "App\Prepaid"){
            $prepaid = Prepaid::where(["id" => $Order->bussinesstypetable_id])->whereNotIn('status', ['Success'])->update(['status' => 'Success']);
        }else if($Order->bussinesstypetable_type == "App\Prodcomm"){
            $shippingcode = str_random(8);
            $shippingcode = strtoupper($shippingcode);
            $prodcomm = Prodcomm::where("id", $Order->bussinesstypetable_id)->whereNotIn('status', ['Success'])->update(['status' => 'Success', 'shipping_code' => $shippingcode]);
        }
    }
}
