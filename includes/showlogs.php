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
        $message = '';
        foreach ($tempData as $s) {
        	//print_r($s);
        	//die();
        	if ($message != '')
        		$message .= '<hr>';
            $dateTime = new DateTime(date('d-M-Y G:i',$s['date']));
            if (!isset($day)) {
                $day = $dateTime->format('d-M-Y');
                $message .= "<div class='log'><center><h3 class='page odd'>".$day."</h3></center><div style='padding: 2px;'>";
            } elseif (($dateTime->format('d-M-Y')) != $day) {
                $day = $dateTime->format('d-M-Y');
                $message .= "</div></div><br /><div class='log'><center><h3 class='page odd'>".$day."</h3></center><div style='padding: 2px;'>";
            }
            if ($s['status']) $message .= $successImg; else $message .= $failImg;
            $message .= " <img src=\"img/";
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
                default:
                	$message .= "arrow.gif\" title='Slideshow'";
            }
            $message .= " width=16 height=16 />";
            $message .= " ".$dateTime->format('G:i');    
            if ($loggedIn) $message .= " ($timezoneString)";
            $message .= ": <strong>".$s['user']."</strong> to ";
            $message .= ($s['targettype'] ? "Group ":"Page ") . "<a target=_new href='http://www.facebook.com/".$s['target']."'>".$s['target']."</a><br /><center><br> ";                
            if ($s['status']) {
                $message .= ucwords($s['action']);
                $message .= ": <a target=_new href='".$s['permalink']."'>" . $lang['Post Link'] . "</a>";
            } else {
                $message .= "<span style='background-color: rgb(253,239,239);text-align:center;'>".$s['action']."</span>";
            }
            $message .= "<br />";
            $param = explode("|",$s['params']);                
            foreach ($param as $p) {
            	$temp = explode(":",$p);
                //list($k, $v) = explode(":",$p);
                if ( ( $temp[0] ) && ( $temp[0] != "access_token" ) && ( $temp[0] != "postType" ) && ( $temp[0] != "targetID" ) )
                	$message .= "<strong>".ucwords($temp[0])."</strong>: ".urldecode($temp[1])."<br />"; 
            }
            $message .= "</center>";
        }
        $message .= "<br /></div></div>";
        if ($adminloggedIn) {
            $message .= "<br /><div style='float: right'><form method='GET'><input type=hidden name='clogs' value=1><input type=submit value='" . $lang['Clear'] . " " . $lang['All'] . " " . $lang['Post Logs'] . "'></form></div>";
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