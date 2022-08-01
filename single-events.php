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
        <div class="col-sm-12"> 

        <?php 
        if ( have_posts() ) {
	while ( have_posts() ) {
		
        the_post();    
        $postID = get_the_ID();

    } 

} 

        echo '<main id="main-content"> 
               <div class="row"> 
                <div class="col-sm-12">'; 

               

            
                ?>        

            <h3 class="form-title">REGISTER HERE</h3> 
                        <form id="registration-form"> 
                        <label for="name">Enter your first name:</label>
                         <input type="text" name="fname" id="fname" placeholder="Jane"  pattern="[A-Za-z]{1,32}"  required>   
                         <label for="name">Enter your last name:</label>
                         <input type="text" name="lname" id="lname" placeholder="Doe" pattern="[a-zA-Z]+('[a-zA-Z])?[a-zA-Z]*{1,32}" required>   
                         <label for="phone">Enter your phone number:</label>
                        <input type="tel" id="phone" name="phone"  placeholder="123-456-7899"  pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}">
                         <label for="email">Enter your email:</label>
                            <input type="email" id="email" name="email" placeholder="janedoe@gmail.com" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$"  required> 
                            <input type="hidden" id="event-ID-holder" name="event-ID-holder" value="<?php echo htmlspecialchars($postID); ?>">
                            <input type="submit" value="Register">
                            </form> 

                            <h3 id="registrant-message"></h3> 
                

    
        </div> 
</div>
  </div>
<?php get_footer(); ?> 

