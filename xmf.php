<?php
define('XMFP_INCLUDE_PATH', dirname(__FILE__).'/xmf_parser-0.7/');
require_once(XMFP_INCLUDE_PATH . 'mfdef.mF_roots.php');
require_once(XMFP_INCLUDE_PATH . 'class.Xmf_Parser.php');
$html = file_get_contents('hcards/beau.html');
$xmfp = Xmf_Parser::create_by_HTML($mF_roots, $html);
$ufs = $xmfp->get_parsed_mfs();
require 'vcard2ldap.php';
foreach((array)$ufs['vcard'] as $vcard) {
	var_dump(vcard2ldap($vcard));
}
?>
