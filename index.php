<?php 

	//urls
	$region_url = "http://integration.cdek.ru/v1/location/regions/json";
	$city_url = "http://integration.cdek.ru/v1/location/cities/json";

	$ch = curl_init();

	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

	curl_setopt($ch, CURLOPT_URL, $region_url.'?'.http_build_query($options));

	$regions = json_decode(curl_exec($ch), true);


	$fd = fopen("cities.txt", 'w');
	foreach ($regions as $region) {
		curl_setopt($ch, CURLOPT_URL, $city_url.'?regionCode='.$region['regionCode']);
		$cities = json_decode(curl_exec($ch), true);
		foreach ($cities as $city) {
			fwrite($fd, $city['region'].'; '.$city['cityCode'].'; '.$city['cityName']."\n");
		}
	}
	fclose($fd);

	curl_close($ch);
