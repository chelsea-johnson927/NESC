<?php 
add_action('wp_ajax_nopriv_calendar','soulCalendar');
add_action('wp_ajax_calendar','soulCalendar'); 
add_action('wp_ajax_nopriv_syn','synthForm');
add_action('wp_ajax_syn','synthForm');  





function soulCalendar(){
    global $wpdb;

    $data = $_POST;
    $start = date('Y-m-d H:i:s',$data['start']);
    $end =  date('Y-m-d H:i:s',$data['end']);

    $query = "SELECT post.* FROM {$wpdb->prefix}posts post INNER JOIN {$wpdb->prefix}postmeta meta1 ON meta1.post_id=post.ID WHERE post.post_type='events' AND meta1.meta_key = 'start_time' AND meta1.meta_value BETWEEN '$start' AND '$end'";
    $results = $wpdb->get_results($query);

    $json = calendarParse($results);
    echo json_encode($json);
    exit;
}

function calendarParse ($data){
    $events = [];

    foreach($data as $k => $v){
        $startTime = get_post_meta($v->ID,'start_time',true);

        array_push($events, [
                'title'=> $v->post_title,
                'start'=> date('Y-m-d',strtotime($startTime)) . 'T' . date('H:i:s',strtotime($startTime)),
                'url' => get_the_permalink($v) 
                
            ]);
    }

    return $events;
} 
    
//adding valid user input into the either the registrants or waitlist table 

function synthForm(){ 

    
    
    global $wpdb;   
    $first = $_POST["fname"]; 
    $last = $_POST["lname"]; 
    $email = $_POST["email"]; 
    $phone = $_POST["phone"];  
    $eventID = $_POST["ID"]; 
    $eStat = $_POST["eStat"];  
    $postTitle = get_the_title($eventID); 
    $postTime = get_post_meta( $eventID, 'start_time', true ); 
    $table_name = "";    
    $headers = array('Content-Type: text/html; charset=UTF-8');

    //determine whether we need to insert user information in registrantion or waitlist table by looking at the 
    //current status of the event. (Open, almost full, or full).  

    

    if($eStat == "Open" || $eStat == "Almost Full" ){ 
 
       $table_name = $wpdb->prefix . 'registrants'; 
       $subject = 'Notification For NESC' . $postTitle . 'Registration'; 
       $body = 'You are now registered for ' . $postTitle . 'which will be held on' . $postTime . ' at location: 167 Prospect Street Unit #1 Waltham,MA 02453. If you need to unregister for any reason please call: 781.538.6519  or email:people@newenglandsynth.com  to unregister. Thanks!'; 
      
    }else{ 

        $table_name = $wpdb->prefix . 'waitlist'; 
        $subject = 'Notification For'. $postTitle . 'Waitlist'; 
       $body = 'You are now placed on the waitlist  for ' . $postTitle . 'which will be held on' . $postTime . 'at location: 167 Prospect Street Unit #1 Waltham,MA 02453. If a spot opens up, we will add you to the registration list then reach out to you via email. Thanks!'; 
       
    }
    
 
    $wpdb->insert( 
        $table_name, 
        array( 
            'FirstName' => $first, 
            'LastName' => $last, 
            'phoneNumber' => $phone, 
            'email' => $email,  
            'eventID' => $eventID  

        )  
    );    


 
wp_mail( $email, $subject, $body, $headers ); 

echo json_encode($eStat);

die();  


}

    
    
  ?> 
