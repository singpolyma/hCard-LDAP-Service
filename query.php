<?php

function ldap_query_vcard($vcard, $type='guess', $source=null) {
	$r = '';
	if($source) {
		$r .= '(&';
	}
	$r .= '(|';
	if($type == 'name' || $type == 'guess') {
		$r .= '(displayName='.$vcard['fn'].')';
		$r .= '(cn='.$vcard['fn'].')';
		if(is_array($vcard['n'])) $r .= '(&(gn='.$vcard['n']['given-name'].')(sn='.$vcard['n']['family-name'].'))';
	}
	if($type == 'contact' || $type == 'guess') {
		if($vcard['email'] && !is_array($vcard['email'])) $vcard['email'] = array($vcard['email']);
		if($vcard['email']) {
			foreach($vcard['email'] as $email) {
				$r .= '(mail='.$email.')';
			}
		}
		if($vcard['tel'] && !is_array($vcard['tel'])) $vcard['tel'] = array($vcard['tel']);
		if($vcard['tel']) {
			foreach($vcard['tel'] as $tel) {
				if(is_array($tel)) {
					$intl = $tel['value']{0} == '+';
					$tel['value'] = trim(preg_replace('\s+',' ',preg_replace('/[^0-9]+/',' ',$tel['value'])));
					if($intl) $tel['value'] = '+'.$tel['value'];
					switch($tel['type']) {
						case 'home':
							$r .= '(homePhone='.$tel['value'].')';
							break;
						case 'mobile':
						case 'cell':
							$r .= '(mobile='.$tel['value'].')';
							break;
						default:
							$r .= '(telephoneNumber='.$tel['value'].')';
							break;
					}
				} else {
					$intl = $tel{0} == '+';
					$tel = trim(preg_replace('\s+',' ',preg_replace('/[^0-9]+/',' ',$tel)));
					$r .= '(telephoneNumber='.$tel.')';
				}
			}
		}
		if($vcard['url'] && !is_array($vcard['url'])) $vcard['url'] = array($vcard['url']);
		if($vcard['url']) {
			foreach($vcard['url'] as $url) {
				$r .= '(labeledURI='.$url.'*)';
			}
		}
	}
	if($type == 'guess' && is_array($vcard['adr']) && $vcard['adr']['street-address']) {
		$r .= '(street='.$vcard['adr']['street-address'].')';
	}
	$r .= ')';
	if($source) {
		$r .= '(sourceURI='.$source.')';
		$r .= ')';
	}
	return $r;
}

echo ldap_query_vcard(array('fn' => 'Stephen Paul Weber', 'email' => 'singpolyma@singpolyma.net', 'url' => 'http://singpolyma.net'))."\n";

?>
