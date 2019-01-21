<?php
// Facebook Multi Page/Group Poster v3
// Created by Novartis (Safwan)

if ( count( get_included_files() ) == 1 )
    die();
if ( $loggedIn ) {
    if ( isset( $_POST[ 'userOptions' ] ) ) {
        foreach ( $_POST as $key => $data ) {            
            if ( $key != "userOptions" )
                $userOptions[ $key ] = $data;
        }
        saveUserOptions();
        header( "Location: ./?ucp" );
        exit;
    } elseif ( isset( $_POST[ 'token' ] ) && ( $_POST[ 'token' ] != '') && ( $_POST[ 'token' ] != $userToken ) ) {
        if ( $hardDemo && $userName == "Multi" )
            return;        
        if ( ( $longUserToken = getStringBetween( $_POST[ 'token' ], 'access_token=','&', true ) ) == "" )
        	if ( ( $longUserToken = getStringBetween( $_POST[ 'token' ], '"access_token":"','"', true ) ) == "" )
        		$longUserToken = $_POST[ 'token' ];
        $bypass = true;
        require_once( 'includes/fbauth.php' );
    }
    $output = "<h4>" . $lang['Access Token'] . " " . $lang['Information'] . ": ";
    try {    
        $permissions = $fb->api( "/" . $GLOBALS[ '__FBAPI__' ] . "/me/permissions", array( "access_token" => $userToken ) );
        $appData = $fb->api( "//app", array( "access_token" => $userToken ) );
        $output .= "<img src='" . $appData[ "icon_url" ] . "'> " . $appData[ "name" ] . "</h4>";
        foreach ( $permissions[ 'data' ] as $perm ) {
            if ( $perm[ 'status' ] == 'granted' ) {
                if ( $perm[ 'permission' ] == 'public_profile' ) $public_profile = true;
                if ( $perm[ 'permission' ] == 'user_photos' ) $user_photos = true;
                if ( $perm[ 'permission' ] == 'user_managed_groups' ) $user_groups = true;
                if ( $perm[ 'permission' ] == 'manage_pages' ) $manage_pages = true;
                if ( $perm[ 'permission' ] == 'publish_pages' ) $publish_pages = true;
                if ( $perm[ 'permission' ] == 'publish_to_groups' ) $publish_actions = true;
                if ( $perm[ 'permission' ] == 'user_likes' ) $user_likes = true;
            }
        }
        if ( isset( $public_profile ) )
            $output .= "$successImg " . $lang['Your Profile'] . " " . $lang['Permission Granted'] . "<br />";
        else
            $output .= "$failImg <strong>" . $lang['Your Profile'] . " " . $lang['Not Found'] . "</strong><br />";
        if ( isset( $user_photos ) )
            $output .= "$successImg " . $lang['Your Photos'] . " " . $lang['Permission Granted'] . "<br />";
        else
            $output .= "$failImg <strong>" . $lang['Your Photos'] . " " . $lang['Not Found'] . "</strong><br />";
        if ( isset( $user_groups ) )
            $output .= "$successImg " . $lang['Groups List'] . " " . $lang['Permission Granted'] . "<br />";
        else
            $output .= "$failImg <strong>" . $lang['Groups List'] . " " . $lang['Not Found'] . "</strong><br />";
        if ( isset( $manage_pages ) && isset( $publish_pages ) && isset( $user_likes ) )
            $output .= "$successImg " . $lang['Your Pages'] . " " . $lang['Permission Granted'] . "<br />";
        else
            $output .= "$failImg <strong>" . $lang['Your Pages'] . " " . $lang['Not Found'] . "</strong><br />";
        if ( isset( $publish_actions ) )
            $output .= "$successImg " . $lang['Publish Actions'] . " " . $lang['Permission Granted'] . "<br />";
        else
            $output .= "$failImg <strong>" . $lang['Publish Actions'] . " " . $lang['Not Found'] . "</strong><br />"; 
    }
    catch ( Exception $e ) {
        $output .= "$failImg " . $e->getMessage();
    }    
    $output .= "<br />";
    if ( isset( $public_profile ) && isset( $user_photos ) && isset( $user_groups ) && isset( $manage_pages ) && isset( $publish_pages ) && isset( $user_likes ) && isset( $publish_actions ) )
    	$output .= "<form name=refresh id=userToken method=post><input type=hidden name=token value='access_token=" . $userToken . "&'>
    	<input type=hidden name=backtomain id=backtomain value='0'><input id='RefreshGroups' type=submit title='" . $lang['Refresh Data message'] . "' value='" . $lang['Refresh Groups'] . "'>";
    else
    	$output .= "<form name=refresh id=userToken method=get><input type=hidden name=rg value=1><input type=submit value='" . $lang['Refresh Token'] . "'>";
    $output .= "&nbsp;<input type=button onclick='showToken()' value='" . $lang['View Token'] . "'></form>";
    $output .= "<script>            
            $('#userToken').easyconfirm({
                eventType: 'submit',
                locale: { title: '" . $lang['Important Note'] . "', text: '" . $lang['User Token Note'] . "', button: ['" . $lang['Cancel'] . "','" . $lang['Proceed'] . "']}
            });
            </script>";
    $message = $output . "<hr><h4>" . $lang['Change'] . " " . $lang['password'] . ": </h4>
                <form name=userCP method=post action='?ucp'>
                <table class=user><colgroup>
			       <col span='1' style='width: 40%;'>
			       <col span='1' style='width: 60%;'>
			    </colgroup>
			    <tr><td>" . $lang['Enter'] . " " . $lang['current'] . " " . $lang['password'] . ":<td> <input type=password name=oldP>
                <tr><td>" . $lang['Enter'] . " " . $lang['new'] . " " . $lang['password'] . ":<td> <input type=password name=newP>
                <tr><td>" . $lang['Repeat'] . " " . $lang['new'] . " " . $lang['password'] . ":<td> <input type=password name=renewP>
                <tr><td colspan=2 class='text-center'><input type=submit value='" .$lang['Submit'] . "'></table></form>";
    $message .= "<hr><h4>" . $lang['User'] . " " . $lang['Options'] . "</h4>
    			<form action='?ucp' name=userOptionsForm id=userOptionsForm method=post><input type=hidden name=userOptions value=1>
                  <table class='user alignleft'>
                  <tr><td>" . $lang['Auto Clear'] . "<td><input type=checkbox name=autoClearForm " . ( $userOptions[ 'autoClearForm' ] == 0 ? "" : "checked" ) . ">
                  <tr><td>" . $lang['Auto Remove'] . "<td><input type=checkbox name=autoRemoveGroups " . ( $userOptions[ 'autoRemoveGroups' ] == 0 ? "" : "checked" ) . ">
                  <tr><td>" . $lang['Delay Handling'] . "<td><input type=radio name=delayHandling value=0 " . ( $userOptions[ 'delayHandling' ] == 0 ? "checked" : "" ) . "> " . $lang['Browser'] . "&nbsp;&nbsp;<input type=radio name=delayHandling value=1 " . ( $adminOptions[ 'useCron' ] ? "" : "disabled title='This setting cannot be used unless CRON is enabled by administrator'" ) . " " . ( $userOptions[ 'delayHandling' ] == 1 ? "checked" : "" ) . "> " . $lang['Server'] . "
                  <tr><td>" . $lang['Auto Pause'] . "<td><input id=autoPauseYes type=radio name=autoPause value=1 " . ( $adminOptions[ 'useCron' ] ? "" : "disabled title='This setting cannot be used unless CRON is enabled by administrator'" ) . " " . ( $userOptions[ 'autoPause' ] == 1 ? "checked" : "" ) . "> " . $lang['Yes'] . "
            &nbsp;&nbsp;<input id=autoPauseNo type=radio name=autoPause value=0 " . ( $userOptions[ 'autoPause' ] == 0 ? "checked" : "" ) . "> " . $lang['No'];
	$message .= "<tr><td>" . $lang['Auto Pause After'] . "<td><select id=autoPauseAfter name=autoPauseAfter " . ( ($adminOptions[ 'useCron' ] && $userOptions[ 'autoPause' ]) ? "" : "disabled" ) . ">";
    for ( $i = 1; $i <= 400; $i += 5 ) {
    	$i = $i - ( $i % 5 );
        if ( $i == 0 )
            $i = 1;        
        if ( $i == $userOptions[ 'autoPauseAfter' ] )
            $message .= "<option value=$i selected>$i " . $lang['posts'] . "</option>";
        else
            $message .= "<option value=$i>$i " . $lang['posts'] . "</option>";
    }
    $message .= "</select>
    			  <tr><td>" . $lang['Auto Pause Duration'] . "<td><select id=autoPauseDelay name=autoPauseDelay " . ( ($adminOptions[ 'useCron' ] && $userOptions[ 'autoPause' ]) ? "" : "disabled" ) . ">";
    for ( $i = 1; $i <= 360; $i += 5 ) {
        $i = $i - ( $i % 5 );
        if ( $i == 0 )
            $i = 1;
        if ( $i == $userOptions[ 'autoPauseDelay' ] )
            $message .= "<option value=$i selected>$i " . $lang['min'] . "</option>";
        else
            $message .= "<option value=$i>$i " . $lang['min'] . "</option>";
    }
    $message .= "</select>
    			<tr><td>" . $lang['API Version'] . "<td><select id=fbapi name=fbapi>";
    for ( $i = -2; $i <= 8; ++$i ) {
        if ( $i === -2 )
            $j = 'none';
        elseif ( $i === -1 )
        	$j = "v1.0";
        else
        	$j = "v2.$i";
        if ( $j == $userOptions[ 'fbapi' ] )
            $message .= "<option value='$j' selected>" . ( $i === -2 ? $lang['No Override'] : $j ) . "</option>";
        else
            $message .= "<option value='$j'>" . ( $i === -2 ? $lang['No Override'] : $j ) . "</option>";
    }
    $message .= "</select>
    			<tr><td>" . $lang['Shorten Links'] . "<td><select id=shortenLinks name=shortenLinks><option value='disabled' " . ( $userOptions[ 'shortenLinks' ] == 'disabled' ? 'selected' : '' ) . ">" . $lang['Disable'] . "</option><option value='klurl' " . ( $userOptions[ 'shortenLinks' ] == 'klurl' ? 'selected' : '' ) . ">Klurl.nl</option><option value='urltv' " . ( $userOptions[ 'shortenLinks' ] == 'urltv' ? 'selected' : '' ) . ">Urltv.nl</option></select>
    			<tr><td colspan=2 class='text-center'><input type=submit value='" .$lang['Save'] . "'></table></form>";
    $message .= require_once( 'includes/tptoken.php' );
    $message .= "<script>					
                    $('#userOptionsForm').submit(function(event){
                        $('#userOptionsForm').block({ 
                            message: '<img src=\"img/loading.gif\">', 
                            timeout: 10000,
                            css: { border: '0px', backgroundColor: 'rgba(255, 255, 255, 0)' },
                            overlayCSS:  { backgroundColor: '#fff', opacity: 0.8 } ,
                            fadeIn:  0
                        }); 
                        $('input[type=checkbox]').each(function() {
                            if (this.checked) {
                                this.value=1;
                            } else {
                                this.checked=true;
                                this.value=0;
                            }
                        });
                    });
                    function showToken() {
                        $('#token').lightbox_me({
                            centered: true, 
                            onLoad: function() { 
                                $('#reasonCell').find('input:first').focus()
                            }
                        }); 
                    }
                    function showTokenHelp() {
		                $('#tokenhelp').lightbox_me({
		                    centered: true,                     
		                }); 
		            }
                    $(document).ready(function() {
                    	$('#RefreshGroups').click(function(e) {
		                    $('#backtomain').val('1');
		                    //e.preventDefault();
		                });
                        $('#userTokenValue').on('change keydown paste', function(){
                              $('#updateToken').enable();
                        });
                        $('#autoPauseNo').click(function(e) {
		                    $('#autoPauseAfter').attr('disabled','disabled');
		                    $('#autoPauseDelay').attr('disabled','disabled');
		                    //e.preventDefault();
		                });
		                $('#autoPauseYes').click(function(e) {
		                    $('#autoPauseAfter').enable();
		                    $('#autoPauseDelay').enable();
		                    //e.preventDefault();
		                });
                    });
                  </script>";            
    if ( isset( $_POST[ 'oldP' ] ) && isset( $_POST[ 'newP' ] ) && isset( $_POST[ 'renewP' ] ) ) {
        if ( $_POST[ 'oldP' ] != $password ) {
            $message .= "<span class='notice'>" . $lang['Incorrect'] . " " . $lang['password'] . "</span>";
        } elseif ( $_POST[ 'newP' ] != $_POST[ 'renewP' ] ) {
            $message .= "<span class='notice'>" . $lang['Passwords'] . " " . $lang['do not match'] . "</span>";
        } elseif ( strlen( $_POST[ 'newP' ] ) < 5 ) {
            $message .= "<span class='notice'>" . $lang['Password'] . " " . $lang['length'] . "</span>";
        } elseif ( $hardDemo && ( $userName == "Multi" ) ) {
            $message .= "<span class='notice'>Password cannot be changed for this user!</span>";
        } else {
            $newP = encrypt( $_POST[ 'newP' ] );
            if ( $db = new PDO( 'sqlite:' . $dbName . '-users.db' ) ) {
                $statement = $db->prepare( "UPDATE FB SET password = \"$newP\" WHERE username = \"$userName\"" );
                if ( $statement ) {
                    $statement->execute();
                    $message .= "<span class='notice'>" . $lang['Password'] . " " . $lang['Changed'] . " " . $lang['Successfully'] . "</span>";
                } else {
                    $message .= "<span class='notice'>" . $lang['Critical Error'] . " " . $lang['while changeing'] . " " . $lang['Password'] . "</span>";
                }
            } else {
                $message .= "<span class='notice'>Error opening database!</span>";
            }
        }
    }    
    showHTML( $message, $lang['User Control Panel'] );
}
?>