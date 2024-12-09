<?php $__env->startSection('title', 'Guard Pro'); ?>
<?php $__env->startSection('content'); ?>
 
   
    
    
    <!-- ======= About Section ======= -->
    <section id="about-page" class="about section-bg" >
       
             
        <img src="assets/img/Home/contact_1.jpg" class="img-fluid img_left" alt="" style="margin-top:-60px">
                
        <div class="overlay"></div>      
           
      <div class="container about-banner" data-aos="fade-up">

        <div class="section-title">
          <h3 class="title">Contact Us</h3>

        </div>       

      </div>
    </section><!-- End About Section -->



     <section id="" class=" section-bg">
        <div class="container">
          <div class="row">
            <div class="col-lg-6 d-flex" data-aos="zoom-out" data-aos-delay="100" style="position: relative;">
                
                <div class=" contact-details">
                  <div class="section-title" style="text-align:left; color:#fff">
                    <div class="title">
                        <h4 > Contact Information
                        </h4>
                        <p style="width: 100%;">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                    </div>
                  </div>

                  <div class="icon-box-circle" data-aos="fade-up" data-aos-delay="300">
                    <div class="icon-cercle">
                      <i class="bx bx-phone "></i>
                    </div>
                    <div class="icon-description">
                      <span>Call US 7/24 </span>
                      <p class="description">+101236546988</p>
                    </div>
                  </div>
                  <div class="icon-box-circle" data-aos="fade-up" data-aos-delay="300">
                    <div class="icon-cercle">
                      <i class="bx  bxs-envelope"></i>
                    </div>
                    <div class="icon-description">
                      <span>Make a Quote </span>
                      <p class="description">+101236546988</p>
                    </div>
                  </div>
                  <div class="icon-box-circle" data-aos="fade-up" data-aos-delay="300">
                    <div class="icon-cercle">
                      <i class="bx bxs-location-plus"></i>

                    </div>
                    <div class="icon-description">
                      <span>Location </span>
                      <p class="description">26985 Brighton Lane,Lake Forest, CA 92630 </p>
                    </div>
                  </div>
                  <div class="social-links mt-3" align="center" style="text-align:left;">
                    <p> Follow Social: </p>
                    <a href="#" class="twitter"><i class="bx bxl-twitter"></i></a>
                    <a href="#" class="facebook"><i class="bx bxl-facebook"></i></a>
                    <a href="#" class="instagram"><i class="bx bxl-instagram"></i></a>
                    <a href="#" class="google-plus"><i class="bx bxl-skype"></i></a>
                    <a href="#" class="linkedin"><i class="bx bxl-linkedin"></i></a>
                  </div>

                </div>

             
            </div>
            <div class="col-lg-6 pt-4 pt-lg-0 content d-flex flex-column justify-content-center" data-aos="fade-up" data-aos-delay="100">
              <div class="section-title" style="text-align:left;">
                <div ><h2><span></span></h2><span class="plan-title">Contact </span></div>
              </div>
              <h3> Ready To Get Started?</h3>
              <p  style=" text-align: justify; font-size: 1.5rem; ">
                Our friendly team is here to answer any questions you may have and help you find the perfect solution for your needs.
              </p>
              <div class="contact">
                 <form action="forms/contact.php" method="post" role="form" class="php-email-form">
                  <div class="form-row">
                    <div class="col form-group">
                       <label>Your Name*</label>
                      <input type="text" name="name" class="form-control" id="name" placeholder="Your Name" data-rule="minlen:4" data-msg="Please enter at least 4 chars" />
                      <div class="validate"></div>
                    </div>
                    <div class="col form-group">
                       <label>Your Email*</label>
                      <input type="email" class="form-control" name="email" id="email" placeholder="Your Email" data-rule="email" data-msg="Please enter a valid email" />
                      <div class="validate"></div>
                    </div>
                  </div>
                  <div class="form-group">
                     <label>Your Subject*</label>
                    <input type="text" class="form-control" name="subject" id="subject" placeholder="Subject" data-rule="minlen:4" data-msg="Please enter at least 8 chars of subject" />
                    <div class="validate"></div>
                  </div>
                  <div class="form-group">
                     <label>Write Message*</label>
                    <textarea class="form-control" name="message" rows="5" data-rule="required" data-msg="Please write something for us" placeholder="Message"></textarea>
                    <div class="validate"></div>
                  </div>
                  <div class="mb-3">
                    <div class="loading">Loading</div>
                    <div class="error-message"></div>
                    <div class="sent-message">Your message has been sent. Thank you!</div>
                  </div>
                  <div class="text-center"><button type="submit">Send Message</button></div>
                </form>
              </div>
             
              
            </div>
          </div>
        </div>
    </section><!-- End About Section -->




     <section id="" class="">

        <div class="row" data-aos="fade-up" data-aos-delay="100">

          <div class="col-lg-12 col-md-12 ">
           

            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d30416.200107173743!2d-123.16599587289863!3d49.24396985813209!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x5486738678c76dc1%3A0x88c158f58601257!2sVanDusen%20Botanical%20Garden!5e0!3m2!1sen!2sbd!4v1720027956434!5m2!1sen!2sbd" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
          </div>

         

        </div>

    </section><!-- End Contact Section -->    
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.appWebsite', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH G:\WampServer\www\Development\SoftView\resources\views/contact_us.blade.php ENDPATH**/ ?>