<?php

class LigPuanTablosu {

	private static $cacheTime = 3600; /* 1 saat */

	private static $site = 'http://sporistatistik.hurriyet.com.tr/default.aspx?listtip=1&sportID=1&ligID=';

	public static function get($lig = 'süperlig')
	{
		$filename = ($lig == 'süperlig') ? '.superlig.cache' : '.1lig.cache';
		if (!is_file($filename) || time() - @filemtime($filename) > self::$cacheTime)
		{
			self::$site .= ($lig == 'süperlig') ? '0' : '1';
			$super_lig = ($lig == 'süperlig');

			$file = @fopen($filename, "w");
			if (!$file) return false;

			$data = self::render(self::parse(self::getSiteData()), $super_lig);
			if (!$data) return false;

			fwrite($file, $data);
			fclose($file);
		}

		print @file_get_contents($filename);
		return true;
	}

	private static function getSiteData()
	{
		$r = '';
		if (!function_exists('curl_init')) return $r;

		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, self::$site);
		curl_setopt($curl, CURLOPT_REFERER, "");
		curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/47.0.2526.111 Safari/537.36");
		curl_setopt($curl, CURLOPT_HEADER, 0);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 0);

		$r = curl_exec($curl);
		curl_close($curl);

		return preg_replace('/\s{2,}/m', '', $r);
	}

	private static function parse($data)
	{
		$pattern = '/<div class="PuanDurumuBaslik .*"><span.*>(?<sira>[0-9]+).?<\/span> (?<takim>[A-Za-z0-9çğıöşüÇĞİÖŞÜ\-\. ]+)<\/div>.*<div class="PuanDurumuPuan .*">(?<O>\d+)<\/div>.*<div class="PuanDurumuPuan .*">(?<G>\d+)<\/div>.*<div class="PuanDurumuPuan .*">(?<B>\d+)<\/div>.*<div class="PuanDurumuPuan .*">(?<M>\d+)<\/div>.*<div class="PuanDurumuPuan .*">(?<A>\d+)<\/div>.*<div class="PuanDurumuPuan .*">(?<Y>\d+)<\/div>.*<div class="PuanDurumuPuan.*".*>(?<P>\d+)<\/div>/U';
		if (!@preg_match_all($pattern, $data, $parseData, PREG_SET_ORDER)) return false;

		$keys = ['sira', 'takim', 'O', 'G', 'B', 'M', 'A', 'Y', 'P'];
		foreach ($parseData as $order => $teams)
			foreach ($teams as $key => $team)
			{
				if (!in_array($key, $keys) || $key == '0') unset($parseData[$order][$key]);
			}

		return $parseData;
	}

	private static function render($data, $super_lig = true)
	{
		$r = '';
		if ($data && is_array($data))
		{
			$r = '
<table class="table puanlar">
	<tr>
		<th></th>
		<th></th>
		<th class="text-center">O</th>
		<th class="text-center">G</th>
		<th class="text-center">B</th>
		<th class="text-center">M</th>
		<th class="text-center">AV</th>
		<th class="text-right">P</th>
	</tr>';
			$i = 0;
			foreach ($data as $value)
			{
				$i++;
				switch ($i)
				{
					case 1:
						$class = "success";
						$r .= ($super_lig) ? '<tr class="success"><td colspan="8" class="text-right">ŞAMPİYONLAR LİGİ</td></tr>' : '<tr class="success"><td colspan="8" class="text-right">ÜST LİG</td></tr>';
						break;
					case 2:
						$class = "success";
						break;
					case 3:
						$class = "info";
						$r .= ($super_lig) ? '<tr class="info"><td colspan="8" class="text-right">UEFA AVRUPA LİGİ</td></tr>' : '<tr class="info"><td colspan="8" class="text-right">YÜKSELME PLAY OFF</td></tr>';
						break;
					case 4:
						$class = "info";
						break;
					case 5:
						$class = ($super_lig) ? "active" : "info";
						break;
					case 6:
						$class = ($super_lig) ? "active" : "info";
						break;
					case 16:
						$class = "danger";
						$r .= '<tr class="danger"><td colspan="8" class="text-right">ALT LİG</td></tr>';
						break;
					case 17:
						$class = "danger";
						break;
					case 18:
						$class = "danger";
						break;
					default:
						$class = "active";
				}
				$r .= sprintf('
	<tr class="%s">
		<td>%s</td>
		<th>%s</th>
		<td class="text-center">%s</td>
		<td class="text-center">%s</td>
		<td class="text-center">%s</td>
		<td class="text-center">%s</td>
		<td class="text-center">%s</td>
		<th class="text-right">%s</th>
	</tr>', $class, $i, $value['takim'], $value['O'], $value['G'], $value['B'], $value['M'], $value['A'] - $value['Y'], $value['P']);
			}
			$r .= '</table>';
			$r .= '<p class="text-muted">O: Oynadığı, G: Galibiyet, B: Beraberlik, M: Mağlubiyet</p>';
		}

		return $r;
	}
}
