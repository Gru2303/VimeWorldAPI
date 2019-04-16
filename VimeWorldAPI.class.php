<?php
/*
 * Public VimeWorld API - Libs
 *
 * @author vk.com/tdiez
 * @version 0.1
 * @site https://api.vime.world
 *
 */

class VimeWorldAPI {
	private $token;
	
	public function __construct($token = null) {
		$this->token = $token;
	}
	
	public function user($user = array(), $method = null) {
		if(isset($method)) {
			return $this->curl('https://api.vime.world/user/' . (is_array($user) ? implode(',', $user) : $user) . '/' . strtolower($method));
		}
		else {
			if(is_string($user[0])) return $this->curl('https://api.vime.world/user/name/' . (is_array($user) ? implode(',', $user) : $user));
			else return $this->curl('https://api.vime.world/user/' . (is_array($user) ? implode(',', $user) : $user));
		}
	}
	
	public function guild($type, $query) {
		switch(strtolower($type)) {
			case "get": return $this->curl('https://api.vime.world/guild/get?' . (http_build_query($query)));
			case "search": return $this->curl('https://api.vime.world/guild/search?query=' . $query);
			default: return [];
		}
	}
	
	public function leaderboard($game, $sort = null, $size = 100) {
		if(isset($game)) {
			if(!is_int($size) || $size < 1 || $size > 1000) $size = 100;
			
			if($sort) return $this->curl('https://api.vime.world/leaderboard/get/' . strtolower($game) . '/' . strtolower($sort) . '?size=' . $size);
			else return $this->curl('https://api.vime.world/leaderboard/get/' . $game . '?size=' . $size);
		}
		else return  $this->curl('https://api.vime.world/leaderboard/list');
	}
	
	public function online($method) {
		if(isset($method)) return $this->curl('https://api.vime.world/online/' . $method);
		else return $this->curl('https://api.vime.world/online');
	}
	
	public function misc($method = "games", $query = null) {
		if(strtolower($method) == "token") return $this->curl('https://api.vime.world/misc/token/' . $query);
		else return $this->curl('https://api.vime.world/misc/' . $method);
	}
	
	// @ return Возвращает ссылку на скин игрока
	public function skin($type, $username, $size = null) {
		switch(strtolower($type)) {
			case "helm": return "https://skin.vimeworld.ru/helm/" . $username . ($size ? ("/" . $size) : "") . ".png";
			case "head": return "https://skin.vimeworld.ru/head/" . $username . ($size ? ("/" . $size) : "") . ".png";
			case "body": return "https://skin.vimeworld.ru/body/" . $username . ($size ? ("/" . $size) : "") . ".png";
			case "back": return "https://skin.vimeworld.ru/back/" . $username . ($size ? ("/" . $size) : "") . ".png";
			case "raw": return "https://skin.vimeworld.ru/raw/skin/" . $username . ".png";
			default: throw new Error("Invalid type cape");
		}
	}
	
	// @ return Возвращает ссылку на плащ игрока
	public function cape($type, $username, $size = null) {
		switch(strtolower($type)) {
			case "cape": return "https://skin.vimeworld.ru/cape/" . $username . ".png";
			case "raw": return "https://skin.vimeworld.ru/raw/cape/" . $username . ".png";
			default: throw new Error("Invalid type cape");
		}
	}
	
	public function getAuthToken() {
		return $this->token;
	}	
	
	private function curl($url) {
		$curl = curl_init($url);
		curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 5);
		curl_setopt($curl, CURLOPT_TIMEOUT, 5);
		if($this->token) {
			curl_setopt($curl, CURLOPT_HTTPHEADER, [
				'Access-Token: '.$this->token,
			]);
		}
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_USERAGENT, "VimeWorldAPI-Libs (github.com/LoganFrench/VimeWorldAPI)");
		$response = curl_exec($curl);
		curl_close($curl);
		try {
			return json_decode($response, true);
		} catch(Exception $e) {
			return [];
		}
	}
}