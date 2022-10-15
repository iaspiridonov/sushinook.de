<?php

function guidv4()
{
	if(function_exists('com_create_guid') === true)
		return trim(com_create_guid(), '{}');

	$data = openssl_random_pseudo_bytes(16);
	$data[6] = chr(ord($data[6]) & 0x0f | 0x40); // set version to 0100
	$data[8] = chr(ord($data[8]) & 0x3f | 0x80); // set bits 6-7 to 10
	return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
}

$db = mysqli_connect("localhost", "wordpress", "bbd19dd1e8c075bdc85abb78ecbdb3caf97d567280218c12", "wordpress") or die("No connect");
mysqli_set_charset($db, "utf8");
//$db = mysqli_connect("localhost", "p-882_test", "gh670*Ya", "kostanay") or die("No connect");

$token = "CRLauZnNJDpgaACyAklH0Aq6eVTIizwYScV2Sccm";

$fp = fopen(__DIR__."/cron.log", "a+");
fwrite($fp, date("d.m.Y H:i:s")."\n");
fclose($fp);

function getCoords($city_id, $street, $building)
{
	global $token;

	$query = [
		'city_id' => $city_id,
		'street' => $street,
		'building' => $building,
	];
	if($curl = curl_init())
	{
		curl_setopt_array($curl, array(
		  CURLOPT_URL => 'https://api.sushinook.de/api/v1/integration/site/orders/get-coordinate-by-address',
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => '',
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 0,
		  CURLOPT_FOLLOWLOCATION => true,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => 'POST',
		  CURLOPT_HTTPHEADER => array(
			'Accept: application/json',
			'Content-Type: application/json',
			'x-token: '.$token,
		  ),
		  CURLOPT_POSTFIELDS => json_encode($query),
		));
		$return = json_decode(curl_exec($curl));
		curl_close($curl);

		return $return;
	}
	return false;
}

function getPoints($city_id, $latitude, $longitude)
{
	global $token;

	$query = [
		'city_id' => $city_id,
		'latitude' => $latitude,
		'longitude' => $longitude,
	];
	if($curl = curl_init())
	{
		curl_setopt_array($curl, array(
		  CURLOPT_URL => 'https://api.sushinook.de/api/v1/integration/site/orders/find-trade-point-by-point',
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => '',
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 0,
		  CURLOPT_FOLLOWLOCATION => true,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => 'POST',
		  CURLOPT_HTTPHEADER => array(
			'Accept: application/json',
			'Content-Type: application/json',
			'x-token: '.$token,
		  ),
		  CURLOPT_POSTFIELDS => json_encode($query),
		));
		$return = json_decode(curl_exec($curl));
		curl_close($curl);

		return $return;
	}
	return false;
}

$order_id = isset($_GET['order_id']) ? intval($_GET['order_id']) : 0;
if($order_id > 0)
	$result = mysqli_query($db, "SELECT * FROM wp_posts WHERE ID = '".$order_id."'");
else
	$result = mysqli_query($db, "SELECT * FROM wp_posts WHERE post_type = 'shop_order' AND TO_DAYS(post_date_gmt) = TO_DAYS(NOW()) ORDER BY ID DESC");
//$result = mysqli_query($db, "SELECT * FROM wp_posts WHERE ID = '102230'");
while($post = $result->fetch_object())
{
	$checkSended = null;
	$checkSendedNull = null;
	if($order_id <= 0)
	{
		$checkSended = mysqli_query($db, "SELECT * FROM cron_log WHERE post_id = '".$post->ID."' AND success = '1'");
		$checkSendedNull = mysqli_query($db, "SELECT * FROM cron_log WHERE post_id = '".$post->ID."' AND success = '0'");
	}
	if(($order_id == 154001) || ((is_null($checkSended) && is_null($checkSendedNull)) || (($checkSended->num_rows == 0) && ($checkSendedNull->num_rows < 6))))
	{
		
		$metaSql = mysqli_query($db, "SELECT * FROM wp_postmeta WHERE post_id = '".$post->ID."'");
		$meta = [];
		while($row = $metaSql->fetch_object())
			$meta[$row->meta_key] = $row->meta_value;

		$itemsSql = mysqli_query($db, "SELECT * FROM wp_woocommerce_order_items WHERE order_id = '".$post->ID."'");
		$items = [];
		$shipping_type = "";
		while($row = $itemsSql->fetch_object())
		{
			$metaSql = mysqli_query($db, "SELECT * FROM wp_woocommerce_order_itemmeta WHERE order_item_id = '".$row->order_item_id."'");
			$metaItem = [];
			while($row2 = $metaSql->fetch_object())
				$metaItem[$row2->meta_key] = $row2->meta_value;
			$row->meta = $metaItem;
			$product_id = isset($metaItem['_variation_id']) ? $metaItem['_variation_id'] : null;
			$product_id = isset($metaItem['_product_id']) ? $metaItem['_product_id'] : $product_id;
			$metaProductSql = mysqli_query($db, "SELECT * FROM wp_postmeta WHERE post_id = '".$product_id."'");
			$metaProduct = [];
			while($rowProduct = $metaProductSql->fetch_object())
				$metaProduct[$rowProduct->meta_key] = $rowProduct->meta_value;
			$row->metaProduct = $metaProduct;
			$items[] = $row;
			if($row->order_item_type == 'shipping')
				$shipping_type = $row->order_item_name;
		}

		/*echo "<pre>";
		print_r($items);
		echo "</pre>";
		echo $post->ID."<br>";
		echo "<pre>";
		print_r($post);
		echo "</pre>";
		echo "<pre>";
		print_r($meta);
		echo "</pre>";
		exit();*/

		$coords = getCoords(1, $meta['_shipping_address_1'], strval($meta['_billing_new_fild14']));
		$headers = [
			'Content-Type' => 'application/json',
			'Accept' => 'application/json',
			'x-token' => $token,
		];
		$nomenclatures = [];
		foreach($items as $item)
		{
			if($item->order_item_type == 'line_item')
			{
				if(isset($item->metaProduct['_product_variation_ids_crm']) && isset($item->metaProduct['_souse_variation_ids_crm']))
				{
					$nomenclatures[] = [
						'id' => $item->metaProduct['_product_variation_ids_crm'],//$item->metaProduct['_product_id_crm'],
						'amount' => 1000*$item->meta['_qty'],
						'category_id' => 10,
						'title' => strip_tags($item->order_item_name),
						'promotional' => false,
					];
					$nomenclatures[] = [
						'id' => $item->metaProduct['_souse_variation_ids_crm'],
						'amount' => 1000*$item->meta['_qty'],
						'category_id' => 10,
						'title' => strip_tags($item->order_item_name),
						'promotional' => false,
					];
				} else {
					$nomenclatures[] = [
						'id' => isset($item->metaProduct['_product_variation_ids_crm']) ? $item->metaProduct['_product_variation_ids_crm'] : $item->metaProduct['_product_id_crm'],
						'amount' => 1000*$item->meta['_qty'],
						'category_id' => 10,
						'title' => strip_tags($item->order_item_name),
						'promotional' => false,
					];
				}
			}
		}
		$is_delivery_cost = false;
		if((($meta['_order_total'] - $meta['_cart_discount']) < 4000) && ($shipping_type == 'Доставка Костанай (бесплатно от 4000 ₸)'))
		{
			$is_delivery_cost = true;
			$nomenclatures[] = [
				'id' => 132,
				'amount' => 1000,
				'category_id' => 8,
				'title' => 'Платная доставка Костанай',
				'promotional' => false,
			];
		} elseif($shipping_type == 'Самовывоз с Хакимжановой, 29 (ожидание в течение 30 минут)') {
			$nomenclatures[] = [
				'id' => 136,
				'amount' => 1000,
				'category_id' => 8,
				'title' => 'Самовывоз Хакимжановой 29 (Костанай)',
				'promotional' => false,
			];	
		} elseif($shipping_type == 'Самовывоз с Алтынсарина, 51 (ожидание в течение 30 минут)') {
			$nomenclatures[] = [
				'id' => 134,
				'amount' => 1000,
				'category_id' => 8,
				'title' => 'Самовывоз Алтынсарина 51 (Костанай)',
				'promotional' => false,
			];	
		} elseif(($meta['_order_total'] >= 4000) && ($shipping_type == 'Доставка Костанай (бесплатно от 4000 ₸)')) {
			$nomenclatures[] = [
				'id' => 130,
				'amount' => 1000,
				'category_id' => 8,
				'title' => 'Бесплатная доставка Костанай',
				'promotional' => false,
			];
		}
		/*	if(($meta['_order_total'] < 3500) && ($meta['_order_shipping'] > 0))
			{
				$is_delivery_cost = true;
				$nomenclatures[] = [
					'id' => 132,
					'amount' => 1000,
					'category_id' => 8,
					'title' => 'Платная доставка Костанай',
					'promotional' => false,
				];
			} elseif($meta['_shipping_address_1'] == 'Хакимжанова') {
				$nomenclatures[] = [
					'id' => 136,
					'amount' => 1000,
					'category_id' => 8,
					'title' => 'Самовывоз Хакимжановой 29 (Костанай)',
					'promotional' => false,
				];	
			} elseif($meta['_shipping_address_1'] == 'Алтынсарина') {
				$nomenclatures[] = [
					'id' => 134,
					'amount' => 1000,
					'category_id' => 8,
					'title' => 'Самовывоз Алтынсарина 51 (Костанай)',
					'promotional' => false,
				];	
			} elseif(($meta['_order_total'] >= 3500) && ($meta['_order_shipping'] == 0)) {
				$nomenclatures[] = [
					'id' => 130,
					'amount' => 1000,
					'category_id' => 8,
					'title' => 'Бесплатная доставка Костанай',
					'promotional' => false,
				];
			}
		}*/
		$md5 = md5($post->ID);
		$uuid = substr($md5, 0, 8)."-".substr($md5, 9, 4)."-".substr($md5, 14, 4)."-".substr($md5, 19, 12);
		$uuid = guidv4();
		$payment_id = $meta['_payment_method_title'] == 'Яндекс.Касса (VISA/MasterCard, QIWI, ЯндексДеньги)' ? 4 : 1;
		$payment_id = $meta['_payment_method_title'] == 'Банковская карта' ? 3 : $payment_id;
		$payment_id = $meta['_payment_method_title'] == 'Kaspi QR' ? 5 : $payment_id;
		$query = [
			'date' => date("Y-m-d H:i", strtotime($post->post_date)),
			'comment' => $post->post_excerpt,
			'uuid' => $uuid,
			/*'discount_id' => 'consequatur',
			'certificate_id' => 'corrupti',
			'sales_channel_id' => 'soluta',
			'price_margin_id' => 'aspernatur',
			'client_id' => 'qui',
			'table_number' => 'accusantium',
			'order_tags' => [
				'natus',
			],*/
			'is_fiscal' => $payment_id == 4 ? false : true,
			'payments' => [
				[
					'id' => $payment_id,
					'sum' => ($meta['_order_total'] - $meta['_cart_discount'] + $meta['_order_shipping'])*100,
					'payment_type' => $meta['_payment_method_title'],
				],
			],
			'order_tags' => [],
			'details' => [
				'city_id' => 1,
				'phone' => $meta['_billing_phone'],
				'client_name' => $meta['_billing_new_fild13'],
				'street' => $meta['_shipping_address_1'],
				'building' => $meta['_billing_new_fild12'],
				'entrance' => $meta['_billing_new_fild14'],
				'floor' => $meta['_billing_new_fild15'],
				'room' => $meta['_billing_new_fild11'],
				'coordinates' => [
					'latitude' => isset($coords->data) && isset($coords->data->address) && isset($coords->data->address->coordinates) ? $coords->data->address->coordinates->latitude : 0,
					'longitude' => isset($coords->data) && isset($coords->data->address) && isset($coords->data->address->coordinates) ? $coords->data->address->coordinates->longitude : 0,
				],
			],
			'nomenclatures' => $nomenclatures,
		];
		if($meta['_cart_discount'] > 0){
			$query['payments'][] = [
				'id' => 6,
				'sum' => $meta['_cart_discount']*100,
				'payment_type' => 'bonuses',
			];
		}
		//$url = 'https://prosushi-api.qsolution.kz/api/v1/integration/site/orders/add-order';
		$url = 'https://api.prosushi.kz/api/v1/integration/site/orders/add-order';
		/*echo $url."<br>";
		echo "<pre>";
		print_r($headers);
		echo "</pre>";
		echo "<pre>";
		print_r($query);
		echo "</pre>";
		exit();*/
		$out = null;
		$success = 0;
		if($curl = curl_init())
		{
			curl_setopt_array($curl, array(
			  CURLOPT_URL => $url,
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_ENCODING => '',
			  CURLOPT_MAXREDIRS => 10,
			  CURLOPT_TIMEOUT => 0,
			  CURLOPT_FOLLOWLOCATION => true,
			  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			  CURLOPT_CUSTOMREQUEST => 'POST',
			  CURLOPT_HTTPHEADER => array(
				'Accept: application/json',
				'Content-Type: application/json',
				'x-token: '.$token,
			  ),
			  CURLOPT_POSTFIELDS => json_encode($query),
			));
			$out = json_decode(curl_exec($curl));
			/*echo "<br>result<br>";
			echo "<pre>";
			print_r($out);
			echo "</pre>";
			echo "<pre>";
			print_r(curl_getinfo($curl));
			echo "</pre>";*/
			if(isset($out->success) && ($out->success == 1))
				$success = 1;
			curl_close($curl);
		}
		mysqli_query($db, "INSERT INTO cron_log(`post_id`, `url`, `headers`, `body`, `response`, `success`, `created_at`) VALUES('".$post->ID."', '$url', '".json_encode($headers, JSON_UNESCAPED_UNICODE)."', '".json_encode($query, JSON_UNESCAPED_UNICODE)."', '".json_encode($out, JSON_UNESCAPED_UNICODE)."', '$success', NOW())");
	}
}
