<?php

namespace Kysela;

class Helpers extends \Nette\Object
{

		
	/**
	* Úprava číselné hodnoty na český formát měny,
	* včetně zaokrouhlením na celé koruny nahoru xx xxx xxx Kč
	* @param int $value
	* @return string
	*/
	public static function currencyCzech($value)
	{
		if(!is_numeric($value)){
			return "----\xc2\xa0Kč";
		}
		return str_replace(" ", "\xc2\xa0", number_format( ceil( $value ), 0, "", " ")) . "\xc2\xa0Kč";
	}

	
	/**
	 * Výpočet věku z datumu narození YYYY-nn-dd
	 * @param date $date
	 * @return int 
	 */
	public static function calculateAge($date)
	{
		return floor((time() - strtotime($date)) / (60*60*24*365));
	}			

	
	public static function buildLink($url) 
	{
		return \Nette\Utils\Html::el('a')->href($url)->target('_blank')->class('target-blank')->setText($url);
	}
	
	
	/**
	 * Vrátí název země podle iso kódu
	 * @param string $nationality | dvoumístný iso kód národa
	 * @return string 
	 */
	public static function nationality($nationality) 
	{
		$nations = \KyselaPetr\Tools::getNationalities();
		return $nations[$nationality];
	}

	
	/**
	* Truncates text.
	*
	* Cuts a string to the length of $length and replaces the last characters
	* with the ending if the text is longer than length.
	*
	* @param string  $text String to truncate.
	* @param integer $length Length of returned string, including ellipsis.
	* @param string  $ending Ending to be appended to the trimmed string.
	* @param boolean $exact If false, $text will not be cut mid-word
	* @param boolean $considerHtml If true, HTML tags would be handled correctly
	* @return string Trimmed string.
	*/
	public static function truncateHTML($text, $length = 150, $ending = '...', $exact = true, $considerHtml = TRUE)
	{
		
		if ($considerHtml) {
            // if the plain text is shorter than the maximum length, return the whole text
            if (strlen(preg_replace('/<.*?>/', '', $text)) <= $length) {
                return $text;
            }
           
            // splits all html-tags to scanable lines
            preg_match_all('/(<.+?>)?([^<>]*)/s', $text, $lines, PREG_SET_ORDER);
   
            $total_length = strlen($ending);
            $open_tags = array();
            $truncate = '';
           
            foreach ($lines as $line_matchings) {
                // if there is any html-tag in this line, handle it and add it (uncounted) to the output
                if (!empty($line_matchings[1])) {
                    // if it's an "empty element" with or without xhtml-conform closing slash (f.e. <br/>)
                    if (preg_match('/^<(\s*.+?\/\s*|\s*(img|br|input|hr|area|base|basefont|col|frame|isindex|link|meta|param)(\s.+?)?)>$/is', $line_matchings[1])) {
                        // do nothing
                    // if tag is a closing tag (f.e. </b>)
                    } else if (preg_match('/^<\s*\/([^\s]+?)\s*>$/s', $line_matchings[1], $tag_matchings)) {
                        // delete tag from $open_tags list
                        $pos = array_search($tag_matchings[1], $open_tags);
                        if ($pos !== false) {
                            unset($open_tags[$pos]);
                        }
                    // if tag is an opening tag (f.e. <b>)
                    } else if (preg_match('/^<\s*([^\s>!]+).*?>$/s', $line_matchings[1], $tag_matchings)) {
                        // add tag to the beginning of $open_tags list
                        array_unshift($open_tags, strtolower($tag_matchings[1]));
                    }
                    // add html-tag to $truncate'd text
                    $truncate .= $line_matchings[1];
                }
               
                // calculate the length of the plain text part of the line; handle entities as one character
                $content_length = strlen(preg_replace('/&[0-9a-z]{2,8};|&#[0-9]{1,7};|&#x[0-9a-f]{1,6};/i', ' ', $line_matchings[2]));
                if ($total_length+$content_length> $length) {
                    // the number of characters which are left
                    $left = $length - $total_length;
                    $entities_length = 0;
                    // search for html entities
                    if (preg_match_all('/&[0-9a-z]{2,8};|&#[0-9]{1,7};|&#x[0-9a-f]{1,6};/i', $line_matchings[2], $entities, PREG_OFFSET_CAPTURE)) {
                        // calculate the real length of all entities in the legal range
                        foreach ($entities[0] as $entity) {
                            if ($entity[1]+1-$entities_length <= $left) {
                                $left--;
                                $entities_length += strlen($entity[0]);
                            } else {
                                // no more characters left
                                break;
                            }
                        }
                    }
                    $truncate .= substr($line_matchings[2], 0, $left+$entities_length);
                    // maximum lenght is reached, so get off the loop
                    break;
                } else {
                    $truncate .= $line_matchings[2];
                    $total_length += $content_length;
                }
               
                // if the maximum length is reached, get off the loop
                if($total_length>= $length) {
                    break;
                }
            }
        } else {
            if (strlen($text) <= $length) {
                return $text;
            } else {
                $truncate = substr($text, 0, $length - strlen($ending));
            }
        }
       
        // if the words shouldn't be cut in the middle...
        if (!$exact) {
            // ...search the last occurance of a space...
            $spacepos = strrpos($truncate, ' ');
            if (isset($spacepos)) {
                // ...and cut the text in this position
                $truncate = substr($truncate, 0, $spacepos);
            }
        }
       
        // add the defined ending to the text
        $truncate .= $ending;
       
        if($considerHtml) {
            // close all unclosed html-tags
            foreach ($open_tags as $tag) {
                $truncate .= '</' . $tag . '>';
            }
        }
       
        return mb_convert_encoding($truncate, 'UTF-8');
		
	}
	

	/**
	 * Převede sekundy na čas
	 * @param int $seconds 
	 */
	public static function secondsFormating($seconds)
	{
		$time = '';
		$hours = (int) floor( $seconds / ( 60 * 60 ) );
		$secondsPerHours = (int) $hours * 60 * 60;
		$minutes = (int) floor( ($seconds - ( $secondsPerHours )) / 60 );
		$newSeconds = (int) $seconds - $secondsPerHours - ($minutes * 60);
		
		if ($hours > 0) { $time .= $hours . 'h '; }
		if ($minutes >= 0) { $time .= $minutes . 'm '; }
		if ($newSeconds >= 0) { $time .= $newSeconds . 's'; }
		
		return $time;
	}
	

	/**
	* Převod času na textové vyjádření
	* @param mixed $time
	* @return string
	*/
	public static function timeAgoInWordsCzech($time)
	{
		if (!$time) {
			return FALSE;
		} elseif (is_numeric($time)) {
			$time = (int) $time;
		} elseif ($time instanceof DateTime) {
			$time = $time->format('U');
		} else {
			$time = strtotime($time);
		}

		$delta = time() - $time;

		if ($delta < 0) {
			$delta = round(abs($delta) / 60);
			if ($delta == 0) return 'za okamžik';
			if ($delta == 1) return 'za minutu';
			if ($delta < 45) return 'za ' . $delta . ' ' . self::plural($delta, 'minuta', 'minuty', 'minut');
			if ($delta < 90) return 'za hodinu';
			if ($delta < 1440) return 'za ' . round($delta / 60) . ' ' . self::plural(round($delta / 60), 'hodina', 'hodiny', 'hodin');
			if ($delta < 2880) return 'zítra';
			if ($delta < 43200) return 'za ' . round($delta / 1440) . ' ' . self::plural(round($delta / 1440), 'den', 'dny', 'dní');
			if ($delta < 86400) return 'za měsíc';
			if ($delta < 525960) return 'za ' . round($delta / 43200) . ' ' . self::plural(round($delta / 43200), 'měsíc', 'měsíce', 'měsíců');
			if ($delta < 1051920) return 'za rok';
			return 'za ' . round($delta / 525960) . ' ' . self::plural(round($delta / 525960), 'rok', 'roky', 'let');
		}

		$delta = round($delta / 60);
		if ($delta == 0) return 'před okamžikem';
		if ($delta == 1) return 'před minutou';
		if ($delta < 45) return "před $delta minutami";
		if ($delta < 90) return 'před hodinou';
		if ($delta < 1440) return 'před ' . round($delta / 60) . ' hodinami';
		if ($delta < 2880) return 'včera';
		if ($delta < 43200) return 'před ' . round($delta / 1440) . ' dny';
		if ($delta < 86400) return 'před měsícem';
		if ($delta < 525960) return 'před ' . round($delta / 43200) . ' měsíci';
		if ($delta < 1051920) return 'před rokem';
		return 'před ' . round($delta / 525960) . ' lety';
	}



	/**
	* Plural: three forms, special cases for 1 and 2, 3, 4.
	* (Slavic family: Slovak, Czech)
	* @param  int
	* @return mixed
	*/
	private static function plural($n)
	{
		$args = func_get_args();
		return $args[($n == 1) ? 1 : (($n >= 2 && $n <= 4) ? 2 : 3)];
	}


	public static function timeToSeconds($time) 
	{
		str_replace( ' ', '', $time);

		$strlen = strlen($time);

		if($strlen > 8){
			return null;
		}

		if( $strlen < 8){
			switch ($strlen) {
				case 7:	$time = '0' . $time; break;
				case 6:	$time = '00' . $time; break;
				case 5:	$time = '00:' . $time; break;
				case 4:	$time = '00:0'. $time; break;
				case 3:	$time = '00:00' . $time; break;
				case 2:	$time = '00:00:' . $time; break;
				case 1:	$time = '00:00:0' . $time; break;
			}
		}

		list($hours, $minutes, $seconds) = explode(":", $time);		

		if(is_numeric($hours) and is_numeric($minutes) and is_numeric($seconds)){
			return $seconds + ( ($minutes * 60) + ($hours *60 * 60));
		}

		return null;
	}


}