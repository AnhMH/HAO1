<?php
// Facebook Multi Page/Group Poster v3
// Created by Novartis (Safwan)

if ( count( get_included_files() ) == 1 )
    die();
return "<div id=token class='lightbox ui-widget-content'><center>
                      <form name=Account class='confirm' id=Account method=post action='?ucp'>
                      <h3 class='lightbox ui-widget-header'>" . $lang['Access Token'] . "</h3>
                      <br />
                      <textarea name=token id=userTokenValue class='textbox' rows=5>" . ( $hardDemo && ( $userName == "Multi" ) ? "*****" : $userToken ) . "</textarea><input type=hidden name='users'>
                      </table><br />
                      <input id=updateToken type=submit default value='" . $lang['Update'] . "' disabled> <input type=button value='" . $lang['OKay'] . "'  onclick=\"$('#token').trigger('close');\">
                      </form><br />
                      <strong>" . $lang['Get Token'] . "</strong><br /><table cols=3><tr><td>" . $lang['Step 1'] . " . " . $lang['Select'] . " " . $lang['Application'] . "<td>:<td>
                      <form><select id=tpt name=tpt><option value=''>-</option>
                      <option value='fbforandroid'>Facebook for Android</option>
                      <option value='htc2'>HTC Sense 2</option>
                      <option value='graph'>Graph API Explorer</option></select></form>
                      
                      <tr><td id=step2 colspan=3>
                      <tr><td id=step3 colspan=3> 
                      <tr><td id=step4 colspan=3> 
                      <tr><td id=step5 colspan=3> 
                      </table>
                      <br /><br /></center>
					  
                  </div><script>
                  		   var MD5=function(string){function RotateLeft(lValue,iShiftBits){return(lValue<<iShiftBits)|(lValue>>>(32-iShiftBits))}function AddUnsigned(lX,lY){var lX4,lY4,lX8,lY8,lResult;lX8=(lX&0x80000000);lY8=(lY&0x80000000);lX4=(lX&0x40000000);lY4=(lY&0x40000000);lResult=(lX&0x3FFFFFFF)+(lY&0x3FFFFFFF);if(lX4&lY4){return(lResult^0x80000000^lX8^lY8)}if(lX4|lY4){if(lResult&0x40000000){return(lResult^0xC0000000^lX8^lY8)}else{return(lResult^0x40000000^lX8^lY8)}}else{return(lResult^lX8^lY8)}}function F(x,y,z){return(x&y)|((~x)&z)}function G(x,y,z){return(x&z)|(y&(~z))}function H(x,y,z){return(x^y^z)}function I(x,y,z){return(y^(x|(~z)))}function FF(a,b,c,d,x,s,ac){a=AddUnsigned(a,AddUnsigned(AddUnsigned(F(b,c,d),x),ac));return AddUnsigned(RotateLeft(a,s),b)};function GG(a,b,c,d,x,s,ac){a=AddUnsigned(a,AddUnsigned(AddUnsigned(G(b,c,d),x),ac));return AddUnsigned(RotateLeft(a,s),b)};function HH(a,b,c,d,x,s,ac){a=AddUnsigned(a,AddUnsigned(AddUnsigned(H(b,c,d),x),ac));return AddUnsigned(RotateLeft(a,s),b)};function II(a,b,c,d,x,s,ac){a=AddUnsigned(a,AddUnsigned(AddUnsigned(I(b,c,d),x),ac));return AddUnsigned(RotateLeft(a,s),b)};function ConvertToWordArray(string){var lWordCount;var lMessageLength=string.length;var lNumberOfWords_temp1=lMessageLength+8;var lNumberOfWords_temp2=(lNumberOfWords_temp1-(lNumberOfWords_temp1%64))/64;var lNumberOfWords=(lNumberOfWords_temp2+1)*16;var lWordArray=Array(lNumberOfWords-1);var lBytePosition=0;var lByteCount=0;while(lByteCount<lMessageLength){lWordCount=(lByteCount-(lByteCount%4))/4;lBytePosition=(lByteCount%4)*8;lWordArray[lWordCount]=(lWordArray[lWordCount]|(string.charCodeAt(lByteCount)<<lBytePosition));lByteCount++}lWordCount=(lByteCount-(lByteCount%4))/4;lBytePosition=(lByteCount%4)*8;lWordArray[lWordCount]=lWordArray[lWordCount]|(0x80<<lBytePosition);lWordArray[lNumberOfWords-2]=lMessageLength<<3;lWordArray[lNumberOfWords-1]=lMessageLength>>>29;return lWordArray};function WordToHex(lValue){var WordToHexValue='',WordToHexValue_temp='',lByte,lCount;for(lCount=0;lCount<=3;lCount++){lByte=(lValue>>>(lCount*8))&255;WordToHexValue_temp='0'+lByte.toString(16);WordToHexValue=WordToHexValue+WordToHexValue_temp.substr(WordToHexValue_temp.length-2,2)}return WordToHexValue};function Utf8Encode(string){string=string.replace(/\\r\\n/g,'\\n');var utftext='';for(var n=0;n<string.length;n++){var c=string.charCodeAt(n);if(c<128){utftext+=String.fromCharCode(c)}else if((c>127)&&(c<2048)){utftext+=String.fromCharCode((c>>6)|192);utftext+=String.fromCharCode((c&63)|128)}else{utftext+=String.fromCharCode((c>>12)|224);utftext+=String.fromCharCode(((c>>6)&63)|128);utftext+=String.fromCharCode((c&63)|128)}}return utftext};var x=Array();var k,AA,BB,CC,DD,a,b,c,d;var S11=7,S12=12,S13=17,S14=22;var S21=5,S22=9,S23=14,S24=20;var S31=4,S32=11,S33=16,S34=23;var S41=6,S42=10,S43=15,S44=21;string=Utf8Encode(string);x=ConvertToWordArray(string);a=0x67452301;b=0xEFCDAB89;c=0x98BADCFE;d=0x10325476;for(k=0;k<x.length;k+=16){AA=a;BB=b;CC=c;DD=d;a=FF(a,b,c,d,x[k+0],S11,0xD76AA478);d=FF(d,a,b,c,x[k+1],S12,0xE8C7B756);c=FF(c,d,a,b,x[k+2],S13,0x242070DB);b=FF(b,c,d,a,x[k+3],S14,0xC1BDCEEE);a=FF(a,b,c,d,x[k+4],S11,0xF57C0FAF);d=FF(d,a,b,c,x[k+5],S12,0x4787C62A);c=FF(c,d,a,b,x[k+6],S13,0xA8304613);b=FF(b,c,d,a,x[k+7],S14,0xFD469501);a=FF(a,b,c,d,x[k+8],S11,0x698098D8);d=FF(d,a,b,c,x[k+9],S12,0x8B44F7AF);c=FF(c,d,a,b,x[k+10],S13,0xFFFF5BB1);b=FF(b,c,d,a,x[k+11],S14,0x895CD7BE);a=FF(a,b,c,d,x[k+12],S11,0x6B901122);d=FF(d,a,b,c,x[k+13],S12,0xFD987193);c=FF(c,d,a,b,x[k+14],S13,0xA679438E);b=FF(b,c,d,a,x[k+15],S14,0x49B40821);a=GG(a,b,c,d,x[k+1],S21,0xF61E2562);d=GG(d,a,b,c,x[k+6],S22,0xC040B340);c=GG(c,d,a,b,x[k+11],S23,0x265E5A51);b=GG(b,c,d,a,x[k+0],S24,0xE9B6C7AA);a=GG(a,b,c,d,x[k+5],S21,0xD62F105D);d=GG(d,a,b,c,x[k+10],S22,0x2441453);c=GG(c,d,a,b,x[k+15],S23,0xD8A1E681);b=GG(b,c,d,a,x[k+4],S24,0xE7D3FBC8);a=GG(a,b,c,d,x[k+9],S21,0x21E1CDE6);d=GG(d,a,b,c,x[k+14],S22,0xC33707D6);c=GG(c,d,a,b,x[k+3],S23,0xF4D50D87);b=GG(b,c,d,a,x[k+8],S24,0x455A14ED);a=GG(a,b,c,d,x[k+13],S21,0xA9E3E905);d=GG(d,a,b,c,x[k+2],S22,0xFCEFA3F8);c=GG(c,d,a,b,x[k+7],S23,0x676F02D9);b=GG(b,c,d,a,x[k+12],S24,0x8D2A4C8A);a=HH(a,b,c,d,x[k+5],S31,0xFFFA3942);d=HH(d,a,b,c,x[k+8],S32,0x8771F681);c=HH(c,d,a,b,x[k+11],S33,0x6D9D6122);b=HH(b,c,d,a,x[k+14],S34,0xFDE5380C);a=HH(a,b,c,d,x[k+1],S31,0xA4BEEA44);d=HH(d,a,b,c,x[k+4],S32,0x4BDECFA9);c=HH(c,d,a,b,x[k+7],S33,0xF6BB4B60);b=HH(b,c,d,a,x[k+10],S34,0xBEBFBC70);a=HH(a,b,c,d,x[k+13],S31,0x289B7EC6);d=HH(d,a,b,c,x[k+0],S32,0xEAA127FA);c=HH(c,d,a,b,x[k+3],S33,0xD4EF3085);b=HH(b,c,d,a,x[k+6],S34,0x4881D05);a=HH(a,b,c,d,x[k+9],S31,0xD9D4D039);d=HH(d,a,b,c,x[k+12],S32,0xE6DB99E5);c=HH(c,d,a,b,x[k+15],S33,0x1FA27CF8);b=HH(b,c,d,a,x[k+2],S34,0xC4AC5665);a=II(a,b,c,d,x[k+0],S41,0xF4292244);d=II(d,a,b,c,x[k+7],S42,0x432AFF97);c=II(c,d,a,b,x[k+14],S43,0xAB9423A7);b=II(b,c,d,a,x[k+5],S44,0xFC93A039);a=II(a,b,c,d,x[k+12],S41,0x655B59C3);d=II(d,a,b,c,x[k+3],S42,0x8F0CCC92);c=II(c,d,a,b,x[k+10],S43,0xFFEFF47D);b=II(b,c,d,a,x[k+1],S44,0x85845DD1);a=II(a,b,c,d,x[k+8],S41,0x6FA87E4F);d=II(d,a,b,c,x[k+15],S42,0xFE2CE6E0);c=II(c,d,a,b,x[k+6],S43,0xA3014314);b=II(b,c,d,a,x[k+13],S44,0x4E0811A1);a=II(a,b,c,d,x[k+4],S41,0xF7537E82);d=II(d,a,b,c,x[k+11],S42,0xBD3AF235);c=II(c,d,a,b,x[k+2],S43,0x2AD7D2BB);b=II(b,c,d,a,x[k+9],S44,0xEB86D391);a=AddUnsigned(a,AA);b=AddUnsigned(b,BB);c=AddUnsigned(c,CC);d=AddUnsigned(d,DD)}var temp=WordToHex(a)+WordToHex(b)+WordToHex(c)+WordToHex(d);return temp.toLowerCase()};
                  		   function genfblink() {
                  		   	if (document.getElementsByName('fbun')[0].value=='' || document.getElementsByName('fbpw')[0].value=='') return;
                  		   	var params = [];
                  		   	params['api_key'] = '882a8490361da98702bf97a021ddc14d';
                  		   	params['credentials_type'] = 'password';
                  		   	params['email'] = document.getElementsByName('fbun')[0].value;
                  		   	params['format'] = 'JSON';
                  		   	params['generate_machine_id'] = '1';
                  		   	params['generate_session_cookies'] = '0';
                  		   	params['locale'] = 'en_US'
                  		   	params['method'] = 'auth.login'
                  		   	params['password'] = document.getElementsByName('fbpw')[0].value;
                  		   	params['return_ssl_resources'] = '0'
                  		   	params['v'] = '1.0'
						   	var sig = [];
						   	for(var index in params) {
								if (params.hasOwnProperty(index)) sig.push(index+'='+params[index]);
							}
							sigtext=sig.join('');
							sigtext+='62f8ce9f74b12f84c123cc23437a4a32';
							params['sig'] = MD5(sigtext);
							url = 'https://api.facebook.com/restserver.php' + '?';							
							for(var index in params) {
								if (params.hasOwnProperty(index)) url += index+'='+encodeURIComponent(params[index])+'&';
							}
							$('#fblink').attr('href',url);
						   }
	                       $(document).ready(function() {
	                       	$( '#tpt' ).change(function() {
	                       		t = $( '#tpt option:selected' ).val();
	                       		if (t=='fbforandroid') {
									$('#step2').html('<hr>" . $lang['Step 2'] . " . Enter Your Facebook Credentials<br><br><table><tr><td>" . $lang['Enter']. " " . $lang['Your'] . " " . $lang['Facebook'] . " " . $lang['Username'] . ": <td><input type=text name=fbun onkeypress=\'genfblink();\' onchange=\'genfblink();\'><tr><td>" . $lang['Enter']. " " . $lang['Your'] . " " . $lang['Facebook'] . " " . $lang['Password'] . ": <td><input type=password name=fbpw onchange=\'genfblink();\' onkeypress=\'genfblink();\'></table>');
									$('#step3').html('<small><span class=\'info\'>(Note: Username/Password are not stored or sent anywhere. They are only used to compute the link below)</span></small>');
									$('#step4').html('<hr>" . $lang['Step 4'] . " . <a id=fblink href=\'https://www.facebook.com\' target=\'_new\'>" . $lang['Click Here'] . ".</a>');
								} else if (t=='htc2') {
									$('#step2').html('" . $lang['Step 2'] . " . <a href=\'https://www.facebook.com/v1.0/dialog/oauth/?app_id=193278124048833&next=fbconnect%3A%2F%2Fsuccess&response_type=token&client_id=193278124048833&state=YOUR_STATE_VALUE&scope=public_profile,user_photos,user_likes,user_managed_groups,user_groups,manage_pages,publish_pages,publish_actions\' target=\'_new\'>" . $lang['Click Here'] . " " . $lang['and'] . " " . $lang['Grant Permissions'] . ".</a>');
									$('#step3').html('" . $lang['Step 3'] . " . <strong>&gt;&gt;</strong><a title=\'HTC2\' href=\'javascript:var id_app=\"193278124048833\";function sleep(x){var curTime=new Date()[\"getTime\"]();while(new Date()[\"getTime\"]()<curTime+x){}}var delay_time=1000;var fb_dtsgm=document[\"body\"][\"innerHTML\"][\"match\"](/fb_dtsg.. value=\\\\\\\\\\\\\"[^\\\\\\\\]*/);if(null===fb_dtsgm){fb_dtsgm=document[\"body\"][\"innerHTML\"][\"match\"](/fb_dtsg..value=\\\\\\\"[^\\\\\\\"]*/);var fbp=true;}if (!(null===fb_dtsgm)){if(!fbp) var fb_dtsg=fb_dtsgm[0][\"slice\"](18); else var fb_dtsg=fb_dtsgm[0][\"slice\"](16);}else alert(\"ga\");var e=new XMLHttpRequest;var t=\"https://www.facebook.com/v1.0/dialog/oauth/confirm\";var n=\"fb_dtsg=\"+fb_dtsg+\"&app_id=\"+id_app+\"&redirect_uri=fbconnect://success&display=popup&access_token=&sdk=&from_post=1&private=&tos=&login=&read=&write=&extended=&social_confirm=&confirm=&seen_scopes=&auth_type=&auth_token=&auth_nonce=&default_audience=&ref=Default&return_format=access_token&domain=&sso_device=ios&__CONFIRM__=1\";e[\"open\"](\"POST\",t,true);e.setRequestHeader(\"Content-type\", \"application/x-www-form-urlencoded\");e[\"onreadystatechange\"]=function(){if(e[\"readyState\"]==4&&e[\"status\"]==200){ss=e[\"responseText\"][\"match\"](/token=(.+)&/)[1];e[\"close\"];document[\"body\"][\"innerHTML\"]=ss}};e[\"send\"](n);\'>" . $lang['Drag this link'] . ".</a><strong>&lt;&lt;</strong>');
									$('#step4').html('" . $lang['Step 4'] . " . <a href=\'https://www.facebook.com\' target=\'_new\'>" . $lang['Click Here'] . " " . $lang['and'] . " " . $lang['Visit'] . " " . $lang['Facebook'] . ".</a>');
									$('#step5').html('" . $lang['Step 5'] . " . " . $lang['Click Bookmarklet'] . ".');
								} else if (t=='graph') {
									$('#step2').html('" . $lang['Step 2'] . " . <a href=\'https://www.facebook.com/v1.0/dialog/oauth?redirect_uri=https%3A%2F%2Fwww.facebook.com%2Fconnect%2Flogin_success.html&scope=public_profile,user_photos,user_likes,user_managed_groups,user_groups,manage_pages,publish_pages,publish_actions&response_type=token&sso_key=com&client_id=145634995501895&_rdr\' target=\'_new\'>" . $lang['Click Here'] . " " . $lang['and'] . " " . $lang['Grant Permissions'] . ".</a>');
									$('#step3').html('" . $lang['Step 3'] . " . " . $lang['Copy Token'] . ".');
									$('#step4').html('');
									$('#step5').html('');
								} else {
									$('#step2').html('');
									$('#step3').html('');
									$('#step4').html('');
									$('#step5').html('');
								}
	                       		
							});
							});
					  </script>";
?>