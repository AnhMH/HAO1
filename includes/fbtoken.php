<?php
// Facebook Multi Page/Group Poster v3
// Created by Novartis (Safwan)

if ( count( get_included_files() ) == 1 )
    die();
// Access Token Checking
if ( !isset( $userOptions[ 'role' ] ) || $userOptions[ 'role' ] == "" ) {
    $roles = json_decode( readURL( 'https://graph.facebook.com/' . $GLOBALS[ '__FBAPI__' ] . '/' . $config[ 'appId' ] . '/roles?limit=10000&access_token=' . $config[ 'appId' ] . '|' . $config[ 'secret' ] ) );
    $role  = "";
    foreach ( $roles->data as $r ) {
        if ( $r->user == $userId ) {
            $role = $r->role;
            break;
        }
    }
    if ( $role != "" ) {
        $userOptions[ 'role' ] = $role;
        if ( $db2 = new PDO( 'sqlite:' . $dbName . '-users.db' ) ) { //Should use saveUserOptions
            $option = "";
            foreach ( $userOptions as $key => $value ) {
                if ( ( $key != "" ) && ( $value != "" ) ) {
                    if ( $option != "" )
                        $option .= "|";
                    $option .= $key . ":" . $value;
                }
            }
            $statement = $db2->prepare( "UPDATE FB SET useroptions=\"$option\" WHERE userid=\"$userId\"" );
            if ( $statement )
                $statement->execute();
            else
                showHTML( "Error x34353054" );
            authRedirect();
        } else {
            showHTML( "Error while opening users database." );
        }
    } else {
        if ( !$adminOptions[ 'enableARA' ] )
            $message = "<div>" . $lang['Congratulations'] . ". " . $lang['Signup success'] . ".<br /><br />
                        " . $lang['Manual approval'] . "<br />
                        " . $lang['recieve notification'] . "</div>";
        else
            $message = '<div>' . $lang['Congratulations'] . '. ' . $lang['almost complete'] . '. ' . $lang['steps remain'] . '<br /><br />
                        <strong>' . $lang['Step 1'] . ':</strong> ' . $lang['new notification'] . '<br />
                        <strong>' . $lang['Step 2'] . ':</strong> ' . $lang['click notification'] . '<br />
                        <strong>' . $lang['Step 3'] . ':</strong> ' . $lang['return here'] . '<br />
                        <br /><br />                                                        
                        <strong>' . $lang['Note'] . '</strong>: ' . $lang['Note full'] . '<br /></div>';
        $userToken = '';
        $message .= '<br /><center>
            <form method=get id=Authorize action="https://www.facebook.com/' . $GLOBALS[ '__FBAPI__' ] . '/dialog/oauth">
            <input type=hidden name=client_id value="' . $config[ 'appId' ] . '">
            <input type=hidden name=redirect_uri value="' . ($_SERVER[ 'HTTPS' ] ? 'https': 'http') . '://' . $_SERVER[ 'HTTP_HOST' ] . $_SERVER[ 'SCRIPT_NAME' ] . '">
            <!-- <input type=hidden name=scope value="public_profile,user_photos,user_likes,user_managed_groups,manage_pages,publish_pages,publish_actions"> -->
            <input type=hidden name=state value="' . $userName . '|safInit">    
            <input type=button onclick="showToken()" value="' . $lang['or'] . ' ' . $lang['Enter'] . ' ' . $lang['Access Token'] . '"></form></center>';
        $message .= require_once( 'includes/tptoken.php' );
	    $message .= "<script>            
	            function showToken() {
	                $('#token').lightbox_me({
	                    centered: true, 
	                    onLoad: function() { 
	                        $('#Account').find('textarea:first').focus()
	                    }
	                }); 
	            }
	            function showTokenHelp() {
	                $('#tokenhelp').lightbox_me({
	                    centered: true,                     
	                }); 
	            }
	            $(document).ready(function() {
	                $('#userTokenValue').on('change keydown paste', function(){
	                      $('#updateToken').enable();
	                });
	            });
	            $('#Authorize').easyconfirm({
	                eventType: 'submit',
	                locale: { title: '" . $lang['Important Note'] . "', text: '" . $lang['User Auth Note'] . "', button: ['" . $lang['Cancel'] . "','" . $lang['Proceed'] . "']}
	            });
	            </script>";
        showHTML( $message, $lang['Welcome'] . " $userName" );
    }
} else {
    //Validity checking
}
?>