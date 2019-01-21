<?php
// Facebook Multi Page/Group Poster v2.74
// Created by Novartis (Safwan)

if ( count( get_included_files() ) == 1 )
    die();
if ( $adminloggedIn || $loggedIn ) {
    if ($db = new PDO('sqlite:'.$dbName.'-logs.db')) {
        if ($adminloggedIn) {
            $statement = $db->prepare("SELECT COUNT(*) FROM Logs");
        } else {
            $statement = $db->prepare("SELECT COUNT(*) FROM Logs WHERE user = \"$fullname ($user)\"");
        }
        if ($statement) {
            $statement->execute();
        } else {
            showHTML("Log Retrieval Failed!");
        }
        $numr = $statement->fetchColumn();
        if (!$numr) showHTML($lang['No Logs'], $lang['Post Logs']);
        $numPerPage=15;
        if (isset($_GET["start"])) {
            $start=$_GET["start"];
            if (($start % $numPerPage)!=0) {
                $start = $start - ($start % $numPerPage);
            }
        } else {
            $start=0;
        }
        $numPages = floor($numr / $numPerPage) ;
        if (($numr % $numPerPage) != 0) $numPages += 1;
        $curPage = ($start / $numPerPage) + 1 ;
        if ($adminloggedIn) {
            $statement = $db->prepare("SELECT * FROM Logs ORDER BY date DESC LIMIT ".$start.",".$numPerPage);
        } else {
            $statement = $db->prepare("SELECT * FROM Logs WHERE user = \"$fullname ($user)\" ORDER BY date DESC LIMIT ".$start.",".$numPerPage);
        }            
        if ($statement) {
            $statement->execute();
        } else {
            showHTML("Log Retrieval Failed x2!");
        }
        $tempData = $statement->fetchAll();
        if ($loggedIn && (isset($_COOKIE['FBMPGPTimezoneValue']))) {
            $timezoneString = $_COOKIE['FBMPGPTimezoneValue'];        
            date_default_timezone_set($_COOKIE['FBMPGPTimezoneValue']);
        }
        $message = '<div><table class=user cols=4><tr><th>Time<th>' . $lang['Username'] . '<th>' . $lang['Page'] . '/' . $lang['Group'] . '<th>' . $lang['Params'] . '<th>' . $lang['Information'] . '</tr>';
        foreach ($tempData as $s) {
        	//print_r($s);
        	//die();        	
            $dateTime = new DateTime(date('d-M-Y G:i',$s['date']));
            if (isset($day) && (($dateTime->format('d-M-Y')) != $day)) {
                $day = $dateTime->format('d-M-Y');
                $message .= "<tr><td colspan=5></tr>";
            } else
            	$day = $dateTime->format('d-M-Y');          
            $message .= "<tr><td> <img class=bottom src=\"img/";
            switch ($s['type']) {
                case 'T':
                    $message .= "text.png\" title='TEXT'";
                    break;
                case 'L':
                    $message .= "link.png\" title='LINK'";
                    break;
                case 'I':
                    $message .= "image.png\" title='IMAGE'";
                    break;
                case 'A':
                    $message .= "album.png\" title='ALBUM'";
                    break;
                case 'V':
                    $message .= "video.png\" title='VIDEO'";
                    break;
                case 'S':
                    $message .= "slideshow.png\" title='Slideshow'";
                    break;
                case 'M':
                    $message .= "multiimage.png\" title='Multi Image'";
                    break;
                default:
                	$message .= "arrow.gif\" title='Unknown'";
            }
            $message .= " width=16 height=16 />";
            $message .= " ".$dateTime->format('d-M-Y G:i');    
            if ($loggedIn) $message .= " ($timezoneString)";
            $message .= "<td><strong>".$s['user']."</strong><td>";
            $message .= ($s['targettype'] ? $lang['Group']:$lang['Page']) . "&nbsp;<a target=_new href='http://www.facebook.com/".$s['target']."'>".$s['target']."</a>";
            $message .= "<td style='word-break: break-all;'>";
            $param = explode("|",$s['params']);                
            foreach ($param as $p) {
            	$temp = explode(":",$p);
                //list($k, $v) = explode(":",$p);
                if ( ( $temp[0] ) && ( $temp[0] != "access_token" ) && ( $temp[0] != "postType" ) && ( ($temp[0] != "file_url") || (strpos($s['params'],"URL:")=== FALSE) ) && ( $temp[0] != "targetID" ) && ( $temp[0] != "isGroupPost" ) && ( stripos($temp[0],"attached_media" ) === FALSE) )
                	$message .= "<strong>".ucwords($temp[0])."</strong>: ".urldecode($temp[1])."<br />"; 
            }
            $message .= "<td>";
            if ($s['status']) {
            	$message .= $successImg;
                $message .= " <a target=_new href='".$s['permalink']."'>" . $lang['Post Link'] . "</a>";
            } else {
            	$message .= $failImg;
                $message .= " <span style='background-color: rgb(253,239,239);text-align:center;'>".$s['action']."</span>";
            }
            $message .= "</tr>";
        }
        $message .= "</table></div>";
        if ($adminloggedIn) {
            $message .= "<br /><center><form method='GET'><input type=hidden name='clogs' value=1><input type=submit value='" . $lang['Clear'] . " " . $lang['All'] . " " . $lang['Post Logs'] . "'></center></form>";
        }
        //Pagination of Results
        $message .= "<br><div>";
        if ($start > 0)
        {
            $message .= " | <a href='./?logs&start=0'>Newest</a>";
            if ($curPage > 2)
            {
                $message .= " | <a href='./?logs&start=".($start-$numPerPage)."'>Newer</a>";
            }
        }
        $message .= " | <b>Page $curPage of $numPages</b>";
        if ($start < ($numr - $numPerPage))
        {	
            if ($curPage <= ($numPages-2))
            {
                $message .= " | <a href='./?logs&start=".($start+$numPerPage)."'>Older</a>";
            }
            $message .= " | <a href='./?logs&start=".(($numPages * $numPerPage) - $numPerPage)."'>Oldest</a>";
        }
        $message .= " |</div>";        
        showHTML($message, $lang['Post Logs']);
    }
}
?>