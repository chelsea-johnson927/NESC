<?php 
add_action('wp_ajax_nopriv_calendar','soulCalendar');
add_action('wp_ajax_calendar','soulCalendar'); 
//add_action('wp_ajax_nopriv_syn','synthForm');
//add_action('wp_ajax_syn','synthForm');  
//add_action( 'wp_ajax_unregister', 'unregister' ); 
//add_action( 'wp_ajax_addtoreg', 'addtoreg' );  




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
    $eStat = $_POST["event-status-holder"]; 
    $table_name = "";    
   

    //determine whether we need to insert user information in registrantion or waitlist table by looking at the 
    //current status of the event. (Open, almost full, or full).  

    

    if($eStat == "Open" || $eStat == "Almost Full" ){ 
 
       $table_name = $wpdb->prefix . 'registrants';
      
    }elseif( $eStat == "Full"){ 

        $table_name = $wpdb->prefix . 'waitlist';
       
    }else{ 

        
    }


     
    $query = "SELECT  eventID FROM $table_name WHERE eventID ="." $eventID"; 
 
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



die();  


}



    function  unregister() {
        
        global $wpdb;  
        $table_name = $wpdb->prefix."registrants"; 
        $dataID= $_POST["ID"]; 
	    $wpdb->delete( $table_name, array( 'id' => $dataID ) );

    
        wp_die(); // this is required to terminate immediately and return a proper response
    }


    function  addtoreg() {
        
        global $wpdb;   
        global $post;
        $table_name = $wpdb->prefix."waitlist";  
        $reg_table = $wpdb->prefix."registrants";  
        $dataID= $_POST["ID"]; 
         
        //making sure there is space in the registration box to add a person from the waitlist 

        if(isset($_GET['post']) && !empty($_GET['post'])){ 

            $eventID = $_GET['post'];   

            $rowcount = intval($wpdb->get_var("SELECT COUNT(*) FROM  $reg_name  WHERE eventID ="." $eventID"));  

            $max_reg = intval(get_post_meta($post->ID, 'max_registrants', true));  

            if($max_reg == 10){ 

                $query = "SELECT  * FROM $table_name WHERE id ="." $dataID";  

                $result = $wpdb->get_results($query);  


               $success =  $wpdb->insert( $reg_name, $result);     

               if($success){ 

                $wpdb->delete( $table_name, array( 'id' => $dataID ) ); 

               }else{ 


            }
             

    }else{ 

    }   

}

 wp_die(); // this is required to terminate immediately and return a proper response



    }
    
    
  ?> 
