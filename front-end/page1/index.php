<?php include('../../initialize.php'); ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="style.css" />
  <style>
    .gb {
  color: #ffffff;
}
  </style>
  <title>Resort Design</title>
</head>

<body>
 

  <div class="main">
    <!--Nav-->
    <header>
      <div class="container">
        <div class="nav">
          <div class="resort-img">
            <img src="WEBSITE IMG/Logo.png" alt="Resort Logo" class="circle-img" />
          </div>
          <div class="icon">
            <div class="bg-primary">Resort</div>
          </div>
          <div class="menu">
            <ul>
              <li><a href="#"  onclick="">Home</a></li>
              <li><a href="#About">About</a></li>
              <li><a href="#Experience">Experiences</a></li>
              <li><a href="#Packages">Packages</a></li>
              <li><a href="#Contact">Contact</a></li>
              <li>
                <button type="button" class="book-now-button" onclick="window.location.href='../page2/index.php'">
                  Book Now!
                </button>
              </li>
              </ul>
              </div>
              
              
              </div>
              
              </header>
              <div class="hero-heading">
                <h1>HEADING</h1>
                <button  type="button" class="view-packages-button" onclick=""><a href="#Packages"> View Packages</a>
                 
                </button>
                <button type="button" class="Book-Now-button" onclick="window.location.href='../page2/index.php'">
                  Book Now
                </button>

                
              </div>
              
              
           <!-- Chat Button -->
<div class="chathead" onclick="toggleChat()" >
💬
</div>

<!-- Chat Box -->
<div id="chat-box" class="chatbox">
  <div class="chatheader"><h1>Resort Name</h1></div>
  <div class="chatbody"><h1>Hi there<br> How can we help you?</h1> </div>
  <div class="messageus"><p>Send us message</p><h6>We typically reply in a few hours</h6> <button class="sendbtn"><img src="WEBSITE IMG/sendus.png" alt="sendus Logo" class="sendus-img" onclick="toggleMessageChat()" /></button></div>
  <div class="search">
    <div class="searchtyp"> <input type="searchtext" placeholder="Send for help" /><button class="searchbtn"><img src="WEBSITE IMG/maglass.png" alt="maglass Logo" class="maglass-img" onclick="toggleSupportChat() "/></button></div>
    <button class="scontent" onclick=""><p>How do i refund?     &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;></p></button>
  </div>
  
  <div class="footertab">
    <button class="footer-btn" onclick="toggleChat()">
      <img src="WEBSITE IMG/homie.png" alt="Home" class="footer-img" />
      <p>Home</p>
    </button>
  
    <button class="footer-btn" onclick="toggleMessageChat()">
      <img src="WEBSITE IMG/messageme.png" alt="Message" class="footer-img" />
      <p>Message</p>
    </button>
  
    <button class="footer-btn" onclick="toggleSupportChat()">
      <img src="WEBSITE IMG/huh.png" alt="Questions" class="footer-img" />
      <p>Questions</p>
    </button>
  </div>
</div>
            
              
 </div>
  </div>

<!-- Chat Box Message -->
<div id="chat-boxM" class="chatboxmss">
  <div class="chatheaderm"><h1>Resort Name</h1></div>
   <button class="buton" onclick="toggleSendm()">Click this to type concern</button>
   <p class="hi">Hi</p>
   <p class="help">How can we help you</p>
  
  <div class="footertabmss">
    <button class="footer-btn" onclick="toggleHomeChat()">
      <img src="WEBSITE IMG/homie.png" alt="Home" class="footer-img" />
      <p>Home</p>
    </button>
  
    <button class="footer-btn" onclick="toggleMessageChat()">
      <img src="WEBSITE IMG/messageme.png" alt="Message" class="footer-img" />
      <p>Message</p>
    </button>
  
    <button class="footer-btn"  onclick="toggleSupportChat()">
      <img src="WEBSITE IMG/huh.png" alt="Questions" class="footer-img" />
      <p>Questions</p>
    </button>
  </div>
  <div class="sendm" style="display: none;">
    <button class="down" onclick="toggleSendm()">v</button>
    <input type="text" id="message" placeholder="Email@example.com">
    <input type="text" id="message" placeholder="Type your message here.....">
    <button onclick="sendEmail()">Send</button>
  </div>
</div>
            
              
 </div>
  </div>
<!--Chat Support-->
<div id="chat-boxS" class="chatbox">
  <div class="chatheaders"><h1>Help</h1></div>
  
  <div class="searchs">
    <div class="searchtyps"> <input type="searchtexts" placeholder="Send for help" /><button class="searchbtns"><img src="WEBSITE IMG/maglass.png" alt="maglass Logo" class="maglass-img" onclick="toggleSupportChat()"/></button></div>
    <button class="scontents" onclick=""><p>How do i refund?     &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;></p></button>
  </div>
  
  <div class="footertab">
    <button class="footer-btn" onclick="toggleChat()">
      <img src="WEBSITE IMG/homie.png" alt="Home" class="footer-img" />
      <p>Home</p>
    </button>
  
    <button class="footer-btn" onclick="toggleMessageChat()">
      <img src="WEBSITE IMG/messageme.png" alt="Message" class="footer-img" />
      <p>Message</p>
    </button>
  
    <button class="footer-btn" onclick="toggleSupportChat()">
      <img src="WEBSITE IMG/huh.png" alt="Questions" class="footer-img" />
      <p>Questions</p>
    </button>
  </div>
</div>
            
              
 </div>
  </div>



<!--About-->
  <section id="About" class="second-section">
    <div class="container">
      <div class="section-content">
        <h2>RESORT NAME</h2>
        <p>
          Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod
        </p>
        <h4>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut Lorem ipsum
          dolor sit amet, consectetur adipislabore et dolore magna aliqua. Ut enim ad minim veniam, quis nostru

          Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore
          magna aliqua. Ut enim ad minim veniam, quis nostrud </h4>
      </div>
    </div>
  </section>
  <section class="third-section">
    <div class="container">
      <div class="section-content3">
        <img src="WEBSITE IMG/Map pin.png" alt="Resort Logo" class="locationpng" />
        <h2>RESORT LOCATION</h2>
        <p>
          Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod
        </p>
        <h3>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et
          dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea
          commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat
          nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim
          id est laborum <br><br><br>

          Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore
          magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
          consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla
          pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id
          est laborum</h3>
        <button type="button" class="view-map-button" onclick="">
          View Map
        </button>
        <button type="button" class="contact-us-button" onclick="">
          Contact Us
        </button>
      </div>
    </div>
  </section>
  <!--Experiences-->
  <section id="Experience" class="fourth-section">
    <div class="container">
      <div class="section-content4">

        <h2>EXPERIENCE</h2>

        <h5>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et
          dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea
          commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat
          nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim
          id est laborum <br><br><br>
        </h5>
        <div class="line1">
          <img src="WEBSITE IMG/bar.png" alt="bar Logo" class="circle-img" />
          <img src="WEBSITE IMG/venue.png" alt="venue Logo" class="circle-img" />
          <img src="WEBSITE IMG/playground.png" alt="playground Logo" class="circle-img" />
          <img src="WEBSITE IMG/kayaking.png" alt="kayaking Logo" class="circle-img" />

          <div class="word1flex">
            <h1>Bar&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</h1>
            <h1>Venue</h1>
            <h1>Playground</h1>
            <h1>Kayaking</h1>
          </div>

        </div>
        <div class="line2">
          <img src="WEBSITE IMG/sun lounge.png" alt="sunlounge Logo" class="circle-img" />
          <img src="WEBSITE IMG/swimmimg lounge.png" alt="swim Logo" class="circle-img" />
          <img src="WEBSITE IMG/grecian ruins.png" alt="grecian Logo" class="circle-img" />

          <div class="word2flex">
            <h1>Sun &nbsp;<br>Lounge&nbsp;</h1>
            <h1>&nbsp;Swimming&nbsp;&nbsp;<br>Pool</h1>
            <h1>Grecian<br>Ruins</h1>

          </div>

        </div>
        <div class="line3">
          <img src="WEBSITE IMG/dream islet.png" alt="islet Logo" class="circle-img" />
          <img src="WEBSITE IMG/tennis court.png" alt="tennis Logo" class="circle-img" />
          <img src="WEBSITE IMG/game room.png" alt="game Logo" class="circle-img" />
          <img src="WEBSITE IMG/fitness gym.png" alt="fitness Logo" class="circle-img" />

          <div class="word3flex">
            <h1>Dream<br> Islet</h1>
            <h1>Tennis<br> Court</h1>
            <h1>Game<br> Room</h1>
            <h1>Fitness<br> Gym</h1>
          </div>

        </div>
      </div>
    </div>
  </section>
  <section  class="fifth-section">
    <div class="container">
      <div class="section-content5">

      </div>
      <div class="box">

      </div>
      <div class="box2">
        <h1>Lorem ipsum dolor sit amet</h1>
        <p>consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad
          minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo conseq</p>
      </div>
    </div>
  </section>
  <section class="sixth-section">
    <div class="container">
      <div class="section-content6">

      </div>
      <div class="box3">

      </div>
      <div class="box4">
        <h1>Lorem ipsum dolor sit amet</h1>
        <p>consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad
          minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo conseq</p>
      </div>
    </div>
  </section>
  <section class="seventh-section">
    <div class="container">
      <div class="section-content7">

      </div>
      <div class="box5">

      </div>
      <div class="box6">
        <h1>Lorem ipsum dolor sit amet</h1>
        <p>consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad
          minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo conseq</p>
      </div>
    </div>
  </section>
<!--Packages-->
  <section id="Packages" class="eight-section">
    <div class="container">
      <div class="section-content8">
        <h2>RESORT NAME</h2>
      </div>
    </div>
  </section>

  <section class="nineth-section">
    <div class="container">
      <div class="section-content9">
</div>
<div class="box-container">
  <div class="box8">
  </div>
  <div class="box7">
    <h2>Heading</h2>
    <h1>Subheading</h1>
    <p><br>Body text for your whole article or post. We’ll put in some lorem ipsum to show how a filled-out page might look:</p>
    <p><br>Excepteur efficient emerging, minim veniam anim aute carefully curated Ginza conversation exquisite perfect nostrud nisi intricate Content. Qui  international first-class nulla ut. Punctual adipisicing, essential lovely queen tempor eiusmod irure. Exclusive izakaya charming Scandinavian impeccable aute quality of life soft power pariatur Melbourne occaecat discerning. Qui wardrobe aliquip, et Porter destination Toto remarkable officia Helsinki excepteur Basset hound. Zürich sleepy perfect consectetur.</p>
  </div>
</div>

    </div>
  </section>

  <section class="tenth-section">
    <div class="container">
      <div class="section-content10">
</div>
<div class="box-container">
  <div class="box9">
    <h2>Heading</h2>
    <h1>Subheading</h1>
    <p><br>Body text for your whole article or post. We’ll put in some lorem ipsum to show how a filled-out page might look:</p>
    <p><br>Excepteur efficient emerging, minim veniam anim aute carefully curated Ginza conversation exquisite perfect nostrud nisi intricate Content. Qui  international first-class nulla ut. Punctual adipisicing, essential lovely queen tempor eiusmod irure. Exclusive izakaya charming Scandinavian impeccable aute quality of life soft power pariatur Melbourne occaecat discerning. Qui wardrobe aliquip, et Porter destination Toto remarkable officia Helsinki excepteur Basset hound. Zürich sleepy perfect consectetur.</p>
  </div>
  <div class="box10">
    
  </div>
</div>

    </div>
  </section>

  <section class="eleventh-section">
    <div class="container">
      <div class="section-content11">
</div>
<div class="box-container">
  <div class="box11">

  </div>
  <div class="box12">
    <h2>Heading</h2>
    <h1>Subheading</h1>
    <p><br>Body text for your whole article or post. We’ll put in some lorem ipsum to show how a filled-out page might look:</p>
    <p><br>Excepteur efficient emerging, minim veniam anim aute carefully curated Ginza conversation exquisite perfect nostrud nisi intricate Content. Qui  international first-class nulla ut. Punctual adipisicing, essential lovely queen tempor eiusmod irure. Exclusive izakaya charming Scandinavian impeccable aute quality of life soft power pariatur Melbourne occaecat discerning. Qui wardrobe aliquip, et Porter destination Toto remarkable officia Helsinki excepteur Basset hound. Zürich sleepy perfect consectetur.</p>
  </div>
</div>

    </div>
  </section>

  <section class="twelveth-section">
    <div class="container">
      <div class="section-content12">
</div>
<div class="box-container">
  <div class="box13">
    <h2>Heading</h2>
    <h1>Subheading</h1>
    <p><br>Body text for your whole article or post. We’ll put in some lorem ipsum to show how a filled-out page might look:</p>
    <p><br>Excepteur efficient emerging, minim veniam anim aute carefully curated Ginza conversation exquisite perfect nostrud nisi intricate Content. Qui  international first-class nulla ut. Punctual adipisicing, essential lovely queen tempor eiusmod irure. Exclusive izakaya charming Scandinavian impeccable aute quality of life soft power pariatur Melbourne occaecat discerning. Qui wardrobe aliquip, et Porter destination Toto remarkable officia Helsinki excepteur Basset hound. Zürich sleepy perfect consectetur.</p>
  </div>
  <div class="box14">
    
  </div>
</div>

    </div>
  </section>

  <section class="thirteenth-section">
    <div class="container">
      <div class="section-content13">
</div>
<div class="box-container">
  <div class="box15">

  </div>
  <div class="box16">
    <h2>Heading</h2>
    <h1>Subheading</h1>
    <p><br>Body text for your whole article or post. We’ll put in some lorem ipsum to show how a filled-out page might look:</p>
    <p><br>Excepteur efficient emerging, minim veniam anim aute carefully curated Ginza conversation exquisite perfect nostrud nisi intricate Content. Qui  international first-class nulla ut. Punctual adipisicing, essential lovely queen tempor eiusmod irure. Exclusive izakaya charming Scandinavian impeccable aute quality of life soft power pariatur Melbourne occaecat discerning. Qui wardrobe aliquip, et Porter destination Toto remarkable officia Helsinki excepteur Basset hound. Zürich sleepy perfect consectetur.</p>
  </div>
</div>

    </div>
  </section>

  <section class="fourteenth-section">
    <div class="container">
      <div class="section-content14">
</div>
<div class="box-container">
  <div class="box17">
    <h2>Heading</h2>
    <h1>Subheading</h1>
    <p><br>Body text for your whole article or post. We’ll put in some lorem ipsum to show how a filled-out page might look:</p>
    <p><br>Excepteur efficient emerging, minim veniam anim aute carefully curated Ginza conversation exquisite perfect nostrud nisi intricate Content. Qui  international first-class nulla ut. Punctual adipisicing, essential lovely queen tempor eiusmod irure. Exclusive izakaya charming Scandinavian impeccable aute quality of life soft power pariatur Melbourne occaecat discerning. Qui wardrobe aliquip, et Porter destination Toto remarkable officia Helsinki excepteur Basset hound. Zürich sleepy perfect consectetur.</p>
  </div>
  <div class="box18">
    
  </div>
</div>

    </div>
  </section>

  <section class="fifthteenth-section">
    <div class="container">
      <div class="section-content15">
</div>
<div class="box-container">
  <div class="box19">

  </div>
  <div class="box20">
    <h2>Heading</h2>
    <h1>Subheading</h1>
    <p><br>Body text for your whole article or post. We’ll put in some lorem ipsum to show how a filled-out page might look:</p>
    <p><br>Excepteur efficient emerging, minim veniam anim aute carefully curated Ginza conversation exquisite perfect nostrud nisi intricate Content. Qui  international first-class nulla ut. Punctual adipisicing, essential lovely queen tempor eiusmod irure. Exclusive izakaya charming Scandinavian impeccable aute quality of life soft power pariatur Melbourne occaecat discerning. Qui wardrobe aliquip, et Porter destination Toto remarkable officia Helsinki excepteur Basset hound. Zürich sleepy perfect consectetur.</p>
  </div>
</div>

    </div>
  </section>

<section class="sixtteenth-section">
  <div class="container">
    <div class ="section-content16">

      <div class="carousel">
        <h2>WHAT OUR GUESTS SAY ABOUT US</h2>
        <p>At Resort, we are committed to providing every guest with the warmth and care that Fortune Island is known for.</p>
    
        <div class="testimonial active">
          “Best Anniversary ever! Thank you for arranging the special dinner by the beach, flowers and sign in the room. Your staff are amazing and 5-star service is fantastic!”<br>— Arlie
        </div>
        <div class="testimonial">
          “Absolutely magical. The sunset view and peaceful vibes were exactly what I needed.”<br>— Mia
        </div>
        <div class="testimonial">
          “A secret paradise. The food, the people, the place—everything was top-tier.”<br>— Noah
        </div>
    
        <div class="arrows">
          <button class="arrow-btn" onclick="changeTestimonial(-1)">&#8592;</button>
          <button class="arrow-btn" onclick="changeTestimonial(1)">&#8594;</button>
        </div>
    
        <div class="dots">
          <span class="dot active" onclick="goToSlide(0)"></span>
          <span class="dot" onclick="goToSlide(1)"></span>
          <span class="dot" onclick="goToSlide(2)"></span>
        </div>
      </div>
    



    </div>
  </div>
</section>
<!--Contact-->
<section id="Contact" class="seventeenth-section">
  <div class="container">
    <div class="section-content17">
      <section class="contact-section">
        <h2>CONTACT US</h2>
        <p>We're excited to welcome you to Resort. Reach out to us by filling out the form below, and let your journey to paradise begin.</p>
    
        <form class="contact-form" action="inquiries.php" method = "post">
          <div class="form-row">
            <div class="form-group">
              <label for="name">Name</label>
              <input type="text" id="name" name="name" placeholder="Your name">
            </div>
            <div class="form-group">
              <label for="contact">Contact Number</label>
              <input type="text" id="contact" name="cn" placeholder="Your number">
            </div>
          </div>
    
          <div class="form-row">
            <div class="form-group">
              <label for="email">Email</label>
              <input type="email" id="email" name="email" placeholder="Your email">
            </div>
            <div class="form-group">
              <label for="inquiry">Inquiry Type</label>
              <input type="text" id="inquiry" name="inquiry_type" placeholder="e.g. Booking, Event, etc.">
            </div>
          </div>
    
          <div class="form-group full">
            <label for="message">Message</label>
            <textarea id="message" rows="4" name="message" placeholder="Type your message here..."></textarea>
          </div>
    
          <button type="submit" name= "submit" class="submit-btn">Submit</button>
        </form>
      </section>
    
    </div>
  </div>
</section>

<footer class="footer">
  <!-- <div class="footer-logo">
  <div class="resort-img">
            <img src="WEBSITE IMG/Logo.png" alt="Resort Logo" class="circle-img" />
          </div>
  </div> -->

  <div class="footer-icons">
      <a href="https://www.facebook.com"><img src="WEBSITE IMG/facebook-new.png" alt="Facebook"></a>
      <a href="https://www.instagram.com/"><img src="WEBSITE IMG/insta.png" alt="Instagram"></a>
      <a href="https://play.google.com/store/apps/details?id=com.google.android.dialer&hl=en"><img src="WEBSITE IMG/phone.png" alt="Phone"></a>
      <a href="https://mail.google.com/"><img src="WEBSITE IMG/mail.png" alt="Email"></a>
  </div>

  <nav class="footer-nav">
      <a href="#">Home</a> |
      <a href="#About">About</a> |
      <a href="#Experience">Experiences</a> |
      <a href="#Packages">Packages</a> |
      <a href="#Contact">Contact</a>
  </nav>

  <p class="footer-text">COPYRIGHT © 2020 ALL RIGHTS RESERVED RESORT & SPA</p>
  <a class="gb" href="../../index.php">Admin Log In</a>
</footer>

<!-- JavaScript -->
<script>
     function toggleChat() {
  const chatBox = document.getElementById("chat-box");
  const messageBox = document.getElementById("chat-boxM");
  const supportBox = document.getElementById("chat-boxS");

  // If chatBox is already visible, close it
  if (chatBox.style.display === "block") {
    chatBox.style.display = "none";
  } else {
    // Open Home chat and close others
    chatBox.style.display = "block";
    messageBox.style.display = "none";
    supportBox.style.display = "none";
  }
}
function toggleHomeChat() {
  const chatBox = document.getElementById("chat-box");
  const messageBox = document.getElementById("chat-boxM");
  const supportBox = document.getElementById("chat-boxS");

  // Show Home chat, hide others
  chatBox.style.display = "block";
  messageBox.style.display = "none";
  supportBox.style.display = "none";
}

function toggleMessageChat() {
  const chatBox = document.getElementById("chat-box");
  const messageBox = document.getElementById("chat-boxM");
  const supportBox = document.getElementById("chat-boxS");

  // Show messageBox, hide others
  messageBox.style.display = "block";
  chatBox.style.display = "none";
  supportBox.style.display = "none";
}

function toggleSupportChat() {
  const chatBox = document.getElementById("chat-box");
  const messageBox = document.getElementById("chat-boxM");
  const supportBox = document.getElementById("chat-boxS");

  // Show supportBox, hide others
  supportBox.style.display = "block";
  chatBox.style.display = "none";
  messageBox.style.display = "none";
}

function toggleSendm() {
  const sendm = document.querySelector(".sendm");
  sendm.style.display = sendm.style.display === "flex" ? "none" : "flex";
}
  //carousel
      let index = 0;
        const testimonials = document.querySelectorAll('.testimonial');
        const dots = document.querySelectorAll('.dot');
    
        function showTestimonial(i) {
          testimonials.forEach((t, idx) => {
            t.classList.toggle('active', idx === i);
            dots[idx].classList.toggle('active', idx === i);
          });
        }
    
        function changeTestimonial(direction) {
          index = (index + direction + testimonials.length) % testimonials.length;
          showTestimonial(index);
        }
    
        function goToSlide(i) {
          index = i;
          showTestimonial(index);
        }
    
        setInterval(() => {
          changeTestimonial(1);
        }, 6000);
  </script>



</body>

</html>