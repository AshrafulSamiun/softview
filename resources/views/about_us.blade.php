
@extends('layouts.appWebsite')
@section('title', 'Guard Pro')
@section('content')
 
   
    
    
    <!-- ======= About Section ======= -->
    <section id="about-page" class="about section-bg" >
       
             
        <img src="assets/img/Home/about_2.jpg" class="img-fluid img_left" alt="" style="margin-top:-60px">
                
        <div class="overlay"></div>      
           
      <div class="container about-banner" data-aos="fade-up">

        <div class="section-title">
          <h3 class="title">About Us</h3>

        </div>       

      </div>
    </section>

    <!-- End About Section -->


    <!-- ======= About Section ======= -->
    <section id="" class=" section-bg">
      <div class="container" data-aos="fade-up" style="">

        <div class="row">
          <div class="col-lg-6" data-aos="zoom-out" data-aos-delay="100">
            <div class="member">
              <div class="member-img">
                <img src="assets/img/Home/about_3.jpg" class="img-fluid img_left" alt="">
                
              </div>
              <img src="assets/img/Home/about_4.jpg" class="img-fluid img_right" alt="">
            </div>
          </div>
          <div class="col-lg-6 pt-4 pt-lg-0 content d-flex flex-column justify-content-center" data-aos="fade-up" data-aos-delay="100">
            <h3>Ensuring Your Success</h3>
            <p class="">
              Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.
            </p>
            <p class="">
              Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. 
            </p>
            <div class="row">
              <div class="col-lg-6 col-md-6 col-sm-6">
                <ul>
                  <li style="list-style:none;">
                    <i class="bx bx-check-circle"></i>
                    Lorem Ipsum is simply dummy
                    </li>
                    <li style="list-style:none;">
                    <i class="bx bx-check-circle"></i>
                    Lorem Ipsum is simply dummy
                    </li>
                    <li style="list-style:none;">
                    <i class="bx bx-check-circle"></i>
                    Lorem Ipsum is simply dummy
                    </li>
                  
                </ul>
              </div>
              <div class="col-lg-6 col-md-6 col-sm-6">
                <ul>
                  <li style="list-style:none;">
                    <i class="bx bx-check-circle"></i>
                    Lorem Ipsum is simply dummy
                    </li>
                    <li style="list-style:none;">
                    <i class="bx bx-check-circle"></i>
                    Lorem Ipsum is simply dummy
                    </li>
                    <li style="list-style:none;">
                    <i class="bx bx-check-circle"></i>
                    Lorem Ipsum is simply dummy
                    </li>
                  
                </ul>
              </div>
            </div>

            <div class="d-flex support">
              <a href="#about" class="btn-get-started scrollto">Explore More </a>
              <a href="#about" style="padding-left:20px">
                  <img class="media-object rounded-circle" style="border: 2px solid rgba(255, 255, 255, 1);" src="assets/img/Home/ceo.jpg"  width="38" height="38">
                  Mr. Shawn, 
                  CEO & Founder
            </a>
            </div>
          </div>
        </div>

      </div>
    </section><!-- End About Section -->

    <!-- ======= About Section ======= -->
    <section id="about" class="about section-bg" >
       
             
        <img src="assets/img/Home/about_1.jpg" class="img-fluid img_left" alt="" style="margin-top:-60px">
                
        <div class="overlay"></div>      
           
      <div class="container " data-aos="fade-up">
        


        <div class="section-title">
          <h3 class="title">About Us</h3>

        </div>
        <div class="d-flex explore">
          <a href="" class="btn-get-started scrollto">View All Cart<i class="icofont-long-arrow-right" style="font-size:24px"></i></a>
          
        </div>

        <div class="row home-about">
          
            <div class="col-lg-12 col-md-12 d-flex align-items-stretch " data-aos="fade-up" data-aos-delay="100" >
               
              <div class="text" style="background: white;">
                
                <h3>The Leading Security Service.</h3>
                <p >
                  At Artemis Security, we are dedicated to revolutionizing the way security guard companies operate. With a team of experienced developers and security industry experts, we have crafted innovative web applications that address the specific challenges faced by security professionals.
                </p>
                <p >
                  Our mission is to empower security guard companies with the tools they need to succeed in a rapidly evolving security landscape. Through continuous innovation and a commitment to excellence, we strive to be the preferred technology partner for security firms worldwide.
                </p>
              </div>
                 
            
            
          </div>
        </div>

      </div>
    </section><!-- End About Section -->


     <section id="" class="contact-us section-bg">

        <div class="row">
          <div class="col-lg-6 d-flex" data-aos="zoom-out" data-aos-delay="100" style="position: relative;">
            <div class="member">
              <div class="member-img">
                <img src="assets/img/Home/security_7.jpg" class="img-fluid img_left" alt="">
                
              </div>
              <div class=" contact-form">
                <div class="section-title" style="text-align:left; color:#fff">
                  <div>
                      <h2 style="border: 3px solid rgba(255,255,255, 1);color: rgba(48, 92, 202, 1);">
                        <span style=" background: rgba(255,255,255,1);"></span>
                      </h2>
                      <span class="plan-title" style="color:#fff">Talk To Us </span>
                  </div>
                </div>
                <h4>How may we help you! </h4>

                <form action="forms/contact.php" method="post" role="form" class="php-email-form">
                  <div class=" form-group">
                    <label>Your Name*</label>
                    <input type="text" name="name" class="form-control" id="name" placeholder="Your Name" data-rule="minlen:4" data-msg="Please enter at least 4 chars" />
                    <div class="validate"></div>
                  </div>
                  <div class=" form-group">
                    <label>Email*</label>
                    <input type="email" class="form-control" name="email" id="email" placeholder="Your Phone" data-rule="phone" data-msg="Please enter a valid Phone Number" />
                    <div class="validate"></div>
                  </div>
                  <div class=" form-group">
                    <label>Phone*</label>
                    <input type="email" class="form-control" name="phone" id="phone" placeholder="Your Email" data-rule="email" data-msg="Please enter a valid email" />
                    <div class="validate"></div>
                  </div>
                  <div class="form-group">
                     <label>Subject*</label>
                    <input type="text" class="form-control" name="subject" id="subject" placeholder="Subject" data-rule="minlen:4" data-msg="Please enter at least 8 chars of subject" />
                    <div class="validate"></div>
                  </div>
                  <div class="form-group">
                     <label>Message*</label>
                    <textarea class="form-control" name="message" rows="5" data-rule="required" data-msg="Please write something for us" placeholder="Message"></textarea>
                    <div class="validate"></div>
                  </div>
                  
                  <div class="text-center"><button class="btn btn-secondary btn-lg btn-block" type="submit" style="background:#000 !important">Send Message</button></div>
                </form>

              </div>
            </div>
          </div>
          <div class="col-lg-6 pt-4 pt-lg-0 content d-flex flex-column justify-content-center" data-aos="fade-up" data-aos-delay="100">
            <div class="section-title" style="text-align:left;">
              <div ><h2><span></span></h2><span class="plan-title">Contact </span></div>
            </div>
            <h3>Contact Us</h3>
            <p class="" style=" text-align: justify; font-size: 1.5rem; ">
              Ready to take your security operations to the next level? Contact us today to learn more about our web applications and how they can benefit your security guard company. Our friendly team is here to answer any questions you may have and help you find the perfect solution for your needs.
            </p>
           
            
          </div>
        </div>

    </section><!-- End About Section -->

    <!-- ======= Team Section ======= -->
    <section id="team" class="team section-bg">
      <div class="container" data-aos="fade-up">
        <div class="section-title">
          <h2>Team</h2>
          <h3>Our LeaderShip <span>Team</span></h3>
          <p>Ut possimus qui ut temporibus culpa velit eveniet modi omnis est adipisci expedita at voluptas atque vitae autem.</p>
        </div>

        <div class="row">

          <div class="col-lg-3 col-md-6 d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="100">
            <div class="member">
              <div class="member-img">
                <img src="assets/img/team/team-1.jpg" class="img-fluid" alt="">
                
              </div>
              <div class="member-info">
                <h4>Mr Shawn</h4>
                <span>CEO & Founder</span>
                <div class="social">
                  <a href=""><i class="icofont-twitter"></i></a>
                  <a href=""><i class="icofont-facebook"></i></a>
                  <a href=""><i class="icofont-instagram"></i></a>
                  <a href=""><i class="icofont-linkedin"></i></a>
                </div>
              </div>
            </div>
          </div>

          <div class="col-lg-3 col-md-6 d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="200">
            <div class="member">
              <div class="member-img">
                <img src="assets/img/team/team-2.jpg" class="img-fluid" alt="">
                
              </div>
              <div class="member-info">
                <h4>Rebeca Soul</h4>
                <span>Director</span>
                <div class="social">
                  <a href=""><i class="icofont-twitter"></i></a>
                  <a href=""><i class="icofont-facebook"></i></a>
                  <a href=""><i class="icofont-instagram"></i></a>
                  <a href=""><i class="icofont-linkedin"></i></a>
                </div>
              </div>
            </div>
          </div>

          <div class="col-lg-3 col-md-6 d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="300">
            <div class="member">
              <div class="member-img">
                <img src="assets/img/team/team-3.jpg" class="img-fluid" alt="">
                
              </div>
              <div class="member-info">
                <h4>Honey Robert</h4>
                <span>Business Executive</span>
                <div class="social">
                  <a href=""><i class="icofont-twitter"></i></a>
                  <a href=""><i class="icofont-facebook"></i></a>
                  <a href=""><i class="icofont-instagram"></i></a>
                  <a href=""><i class="icofont-linkedin"></i></a>
                </div>
              </div>
            </div>
          </div>

          <div class="col-lg-3 col-md-6 d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="400">
            <div class="member">
              <div class="member-img">
                <img src="assets/img/team/team-4.png" class="img-fluid" alt="">
                
              </div>
              <div class="member-info" style="">
                <h4>Ashraful Islam</h4>
                <span>CTO</span>
                <div class="social">
                  <a href=""><i class="icofont-twitter"></i></a>
                  <a href=""><i class="icofont-facebook"></i></a>
                  <a href=""><i class="icofont-instagram"></i></a>
                  <a href=""><i class="icofont-linkedin"></i></a>
                </div>
              </div>
            </div>
          </div>

        </div>

      </div>
    </section><!-- End Team Section -->
@endsection

