jQuery(document).ready(function($){   


    document.getElementById("registration-form").addEventListener("submit", function(e){
           
        e.preventDefault();    //stop form from submitting 


    var firstName = document.getElementById("fname").value;
    var lastName =  document.getElementById("lname").value;
    var phone = document.getElementById("phone").value;
    var email = document.getElementById("email").value;
    var ID = document.getElementById("event-ID-holder").value;  


    jQuery.ajax({
        url:synth.ajaxurl,
        type: 'POST',
        data: {
          "action": "syn",  
          "fname": firstName,  
          "lname": lastName, 
          "phone":phone, 
          "email":email, 
          "ID" : ID
        
        },  
        success: function(data) { 

            $("#registration-form").hide(1000, function(){ 

                $("#registrant-message").text("You are all set! We look forward to seeing you!");  

                console.log(data); 
            });  
        } 



        }); 
    });
     

      

      });