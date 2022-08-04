<?php
/**
 * The template for displaying a single event post
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package newenglandsynthesizertheme
 */

get_header(); 
?>

<div class="container-fluid"> 
    <div class="row">
        <div class="col-sm-12 form-content">  
               

        <?php 
        if ( have_posts() ) {
	while ( have_posts() ) {
		
        the_post();    
        $postID = get_the_ID(); 
        $eventStat = get_post_meta( $postID, 'event_status', true);  
        $spotsLeft = get_post_meta( $postID, 'spots_left', true );  

    }  

    if($eventStat == "Open" || $eventStat == "Almost Full"){  

       
        if($eventStat == "Open"){ 

            echo '<p id="registrant-message">This event is Open! Register below.</p> '; 
        }else{ 

            echo '<p id="registrant-message">Only'." ".'<span style="color:red; font-weight:bold">'. $spotsLeft. '</span>'." ".'spots left! Register Now!</p>';  


        } ?>

       
<?php

    }else{ 

        echo '<p id="registrant-message">This event has now reached its maximum number of registrants. However, you can sign up on the form below to be on the waitlist for this event. If a spot opens up, we will add you to the registration list and follow up with the email you provide.</p>'; 
    } 

} 
?>        

          
                

<h3 class="form-title">REGISTER HERE</h3> 
        <form id="registration-form"> 
        <label for="name">Enter your first name</label>
         <input type="text" name="fname" id="fname" placeholder="Jane"  pattern="[A-Za-z]{1,32}"  required>   
         <label for="name">Enter your last name</label>
         <input type="text" name="lname" id="lname" placeholder="Doe" pattern="[a-zA-Z]+('[a-zA-Z])?[a-zA-Z]*{1,32}" required>   
         <label for="phone">Enter your phone number</label>
        <input type="tel" id="phone" name="phone"  placeholder="123-456-7899"  pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}">
         <label for="email">Enter your email</label>
            <input type="email" id="email" name="email" placeholder="janedoe@gmail.com" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$"  required> 
            <input type="hidden" id="event-ID-holder" name="event-ID-holder" value="<?php echo htmlspecialchars($postID); ?>"> 
            <input type="hidden" id="event-status-holder" name="event-status-holder" value="<?php echo htmlspecialchars($eventStat); ?>"> 
            <input type="submit" value="REGISTER">
            </form> 

            











    
        </div> 
</div>
  </div>
<?php get_footer(); ?> 

