<?php

require 'maybe_select.php';

function vcard2ldap($vcard) {
	maybe_select($vcard, 'fn', $rtrn, 'cn', 'force');
	maybe_select($vcard, 'fn', $rtrn, 'displayName', 'force');
	maybe_select($vcard, 'nickname', $rtrn, 'cn', 'force');
	maybe_select($vcard, array('n', 'given-name'), $rtrn, 'gn', 'force');
	maybe_select($vcard, array('n', 'family-name'), $rtrn, 'sn', 'force');
//	maybe_select($vcard, array('n', 'additional-name'), $rtrn, '', 'force');
//	maybe_select($vcard, array('n', 'honorific-prefix'), $rtrn, 'personalTitle', 'force');
//	maybe_select($vcard, array('n', 'honorific-suffix'), $rtrn, 'generationQualifier', 'force');
	maybe_select($vcard, array('adr', 'post-office-box'), $rtrn, 'postOfficeBox', 'force');
	maybe_select($vcard, array('adr', 'street-address'), $rtrn, 'street', 'force');
	maybe_select($vcard, array('adr', 'locality'), $rtrn, 'l', 'force');
	maybe_select($vcard, array('adr', 'region'), $rtrn, 'st', 'force');
	maybe_select($vcard, array('adr', 'postal-code'), $rtrn, 'postalCode', 'force');
	maybe_select($vcard, array('adr', 'country-name'), $rtrn, 'c', 'force');
	maybe_select($vcard, 'note', $rtrn, 'description', 'force');
	maybe_select($vcard, array('org', 'organization-name'), $rtrn, 'o', 'force');
	maybe_select($vcard, array('org', 'organization-unit'), $rtrn, 'ou', 'force');
//	maybe_select($vcard, 'photo', $rtrn, 'photo|jpegPhoto', 'force');
	maybe_select($vcard, 'title', $rtrn, 'title', 'force');
	maybe_select($vcard, 'url', $rtrn, 'labeledURI', 'force');
	foreach((array)$vcard['email'] as $email) {
		maybe_select($email, 'email', $rtrn, 'mail', 'force');
	}
	foreach((array)$vcard['tel'] as $tel) {
		switch($tel['type']) {
			case 'cell':
			case 'mobile':
				$type = 'mobile';
				break;
			case 'fax':
				$type = 'fax';
				break;
			case 'home':
				$type = 'homePhone';
				break;
			default:
				$type = 'telephoneNumber';
		}
		maybe_select($tel, 'tel', $rtrn, $type, 'force');
	}
	return $rtrn;
}

?>
