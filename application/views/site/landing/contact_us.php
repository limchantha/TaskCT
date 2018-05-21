<?php $this->load->view('site/common/header');	?>
		<section>
		<div class="clearfix"></div>
			<div class="contact_us_base">
                     <div class="container">
                            <div class="contact_detail_inner col-md-12 col-sm-12 col-xs-12 text-center">
                                    <h1>Contact Us</h1>
                                    <div class="contact_fields">
                                                    <form id="contact-form" action="#" method="post">
                                                <div class="col-md-12 col-sm-12 col-xs-12 contact_text">
                                                        <input type="text" placeholder="Name" name="name" id="name" class="error">
														<label for="name" generated="true" class="error"></label>
                                                </div>
                                                 <div class="col-md-12 col-sm-12 col-xs-12 contact_text">
                                                        <input type="text" placeholder="Email" name="email" id="email" class="error"><label for="email" generated="true" class="error"></label>
                                                </div>
                                                 <div class="col-md-12 col-sm-12 col-xs-12 contact_text">
                                                        <input type="text" placeholder="Mobile" name="phone" id="phone" class="error"><label for="phone" generated="true" class="error"></label>
                                                </div>
                                                 <div class="col-md-12 col-sm-12 col-xs-12 contact_text">
                                                        <textarea placeholder="Message" name="message" id="message" class="error"></textarea>					<label for="message" generated="true" class="error"></label><br>
												</div>
                                                 <div class="col-md-12 col-sm-12 col-xs-12 contact_text">
                                                        <button id="load" data-loading-text="<i class='fa fa-spinner fa-spin '></i> Wait Processing..." class="submit_btn" type="submit"> Send now</button>	
                                                </div>
                                                    </form>
                                    </div>
                            </div>
                     </div>   
			</div>
			<div class="clearfix"></div>
			
	</section>
	<script>
	$(document).ready(function() {
    $.validator.addMethod("nameRegex", function(value, element) {
        return this.optional(element) || /^[a-z\- . ]+$/i.test(value);
    }, "Username must contain only letters, numbers, or dashes.");
    $.validator.addMethod("number", function(value, element) {
        return this.optional(element) || /^[0-9\-( ) + ]+$/i.test(value);
    }, "For Eg:1234567890, this field allows numbers,+,hyphen,(),single space only.");
    $("#contact-form").validate({
        errorElement: "label",
        rules: {
            name: {
                required: true,
                minlength: 3,
                maxlength: 50
            },
            email: {
                required: true,
                email: true
            },
            phone: {
                required: true,
                number: true,
                minlength: 8,
                maxlength: 15
            },
            message: {
                required: true,
                minlength: 3,
                maxlength: 1000
            }
        },
        messages: {
            name: {
                required: "Enter your Name",
                minlength: "Minimum 3 characters long",
                maxlength: "can not be more than 50 characters"
            },
            email: {
                required: "Enter a Email ID",
                email: "Enter a Valid Email"
            },
            phone: {
                required: "Enter a Phone Number",
                number: " Enter Numbers only",
                minlength: "Minimum 8 digit long",
                maxlength: "Maximum 15 digit long"
            },
            message: {
                required: "Enter a message",
                minlength: "Minimum 3 characters long",
                maxlength: "Maximum 1000 characters long"
            }
        },
        errorPlacement: function(error, element) {
            error.appendTo(element.parent());
        },
        submitHandler: function(form) {
            $('#load').html($('#load').attr('data-loading-text'));
            $.ajax({
                type: "POST",
                url: "<?php echo base_url();?>site/landing/save_contactus",
                dataType: "json",
                timeout: 500000,
                data: $('#contact-form').serialize(),
                success: function(json) {
                    if (json.result == '1') {
                        swal({
                            title: "Success",
                            text: "Your enquiry received successfully. We contact you shortly.",
                            type: "success"
                        }, function() {
                            location.href = '<?php echo base_url();?>';
                        });
                        return false;
                    } else if (json.result == '0') {
                        swal({
                                title: "Opps",
                                text: "System Busy try later",
                                type: "error"
                            }, function() {
                                location.href = '<?php echo base_url();?>';
                            }

                        );
                    }
                }
            });
        }
    });
});
	</script>
<?php $this->load->view('site/common/footer');?>