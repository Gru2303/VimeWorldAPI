<?
	// ini_set("display_errors", 1);

	$start = microtime(true); 
	
	require('VimeWorldAPI.class.php');
	
	$api = new VimeWorldAPI();
	
	echo 'Статистика LoganFrench:<br>';
	$data = $api->user('LoganFrench');
	foreach($data[0] as $key => $value) {
		echo " - " . $key.": " . $value . "<br>";
	}
	
	echo '<br>ТОП-5 бедварс:<br>';
	$data = $api->leaderboard('bw', NULL, 5);
	foreach($data['records'] as $info) {
		echo " - " . $info['user']['username'] . "<br>";
	}
	
	echo '<br>Модеры онлайн:<br>';
	$data = $api->online('staff');
	foreach($data as $info) {
		echo " - " . $info['username'] . "<br>";
	}
	
	echo '<br>Гильдия 104:<br>';
	$data = $api->guild("get", [ "id" => 104]);
	foreach($data as $key => $value) {
		echo " - " . $key . ": " . $value . "<br>";
	}
	
	echo '<br>Гильдия Fantastic Five:<br>';
	$data = $api->guild("get", [ "name" => "Fantastic Five"]);
	foreach($data as $key => $value) {
		echo " - " . $key . ": " . $value . "<br>";
	}
	
	echo '<br>Гильдия с совпадением "VimeT":<br>';
	$data = $api->guild("search", "VimeT");
	foreach($data as $info) {
		echo " - " . $info['name'] . "<br>";
	}
	
	
	echo '<br><br>Время выполнения скрипта: '.substr((microtime(true) - $start), 0, 6);
	
?>