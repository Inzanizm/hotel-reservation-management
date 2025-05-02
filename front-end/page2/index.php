<?php include('../../initialize.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Resort Booking</title>
  <link rel="stylesheet" href="styles.css" />
</head>
<body>

  <div class="page-wrapper">
    <div class="header-banner">
      <h1>Resort</h1>
      <div class="remove">
      <a href="../page1/index.php"><img src="pic/remove.png" alt="Resort Logo" class="header-img" /></a>
    </div>
    </div>

    <section class="second-section">
      <div class="container">
        <div class="section-content"></div>
      </div>
    </section>

    <div class="filters">
      <button onclick="toggleContainer()" id="open-calendar-btn">Select Dates</button>
      <button id="openRoomBtn">Select Rooms & Guests</button>
      <input type="text" placeholder="Enter Promo Code" />
    </div>

    <!-- Calendar -->
    <div id="container" class="hidden">
    <div id="calendar-wrapper">
      <div class="calendar-container">
        <button id="close-calendar-btn">✖</button>
        <div class="calendar-nav">
          <button id="prev-month-btn">❮</button>
          <div id="calendar-months"></div>
          <button id="next-month-btn">❯</button>
        </div>
        <div id="calendar-grid-wrapper"></div>
      </div>
    </div>
    </div>

    <!-- ROOM POPUP -->
<div class="room-popup" id="roomPopup" style="display:none;">
  <div class="room-popup-content">
    <!-- Step 1: Choose number of rooms -->
    <div id="choose-rooms-step">
      <div class="room-selection">
        <p>How many rooms?</p>
        <div class="room-options">
          <button class="room-option" data-rooms="1">1 Room</button>
          <button class="room-option" data-rooms="2">2 Rooms</button>
        </div>
      </div>
    </div>

    <!-- Step 2: Choose guests -->
    <div id="guest-selection-step" style="display:none;">
      <div id="rooms-container">
        <!-- Rooms with guest counters will be dynamically added here -->
      </div>
      <hr />
      <div class="popup-actions">
        <button id="doneRoomBtn"class="done-room">Done</button>
      </div>
    </div>
  </div>
</div>




    <div class="content-area">
      <div class="content-area">
        <!-- Left: Villa List -->
        <div class="villa-list">
          <!-- Villa Card 1 -->
          <div class="villa-card">
            <div class="villa-flex">
              <div class="villa-image" data-carousel>

                <div class="carousel">
                          
                  <div class="testimonial active">
                    <img src="https://images.unsplash.com/photo-1600585154340-be6161a56a0c?auto=format&fit=crop&w=800&q=80" alt="Seaview Villa" />
                  </div>
                  <div class="testimonial">
                    <img src="https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=800&q=80" alt="resort pic" />
                  </div>
                  <div class="testimonial">
                    <img src="pic/p1.jpeg" alt="resort pica" />
                  </div>
              
                 <!-- <div class="arrows">
                    <button class="arrow-btn prev">&#8592;</button>
                    <button class="arrow-btn next">&#8594;</button>
                  </div>-->
                
                  <div class="dots">
                    <span class="dot active"></span>
                    <span class="dot"></span>
                    <span class="dot"></span>
                  </div>
                </div>

              </div>
              <div class="villa-details">
                <div class="villa-title">
                  <h2>Seaview Villa</h2>
                  <div class="labels">
                    <span class="guest-icon"></span>
                    <span>1 King Bed</span>
                    <span>1 Bathroom</span>
                  </div>
                </div>
                <p class="villa-description">
                  Unwind and relax to the sound of the ocean from your bed or spacious living room, indulge in a luxurious soak in the oversized tub, or rejuvenate your senses with an open-air lava rock shower...<span class="view-more-text">View more</span>
                </p>
              </div>
            </div>
            <div class="rate-box">
              <div class="rate-info">
                <strong>Standard Rate</strong>
                <p>✔ Book Now, Pay Later</p>
                <p>❗ Cancellation fees apply</p>
                <span class="view-more-text">View more</span>
               
              </div>
              <div class="price-select">
                <div class="price">₱ 5,000</div>
                <div class="cost"><small></small></div>
               <!-- <p class="selected-message"></p> -->
                <button class="select-btn" data-name="Seaview Villa - Standard Rate" data-price="5000" disabled>Select</button>
              </div>
            </div>
          </div>


<!-- Dialog for Villa Details -->
<div id="villa-dialog" class="dialog" style="display: none;">
  <div class="dialog-content">
    <span class="close-villa-dialog">&times;</span>
    <div id="villa-dialog-body">
      <!-- Dynamic content goes here -->
    </div>
  </div>
</div>


      
          <!-- Villa Card 2 -->
          <div class="villa-card2">
            <div class="villa-flex">
              <div class="villa-image">

                <div class="carousel" data-carousel>
                          
                  <div class="testimonial active">
                    <img src="https://images.unsplash.com/photo-1505693416388-ac5ce068fe85?auto=format&fit=crop&w=800&q=80" alt="Seaview Villa 2" />
                  </div>
                  <div class="testimonial">
                    <img src="https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=800&q=80" alt="resort pic" />
                  </div>
                  <div class="testimonial">
                    <img src="pic/p1.jpeg" alt="resort pica" />
                  </div>
              
                  <!--<div class="arrows">
                    <button class="arrow-btn prev">&#8592;</button>
                    <button class="arrow-btn next">&#8594;</button>
                  </div>-->
                
                  <div class="dots">
                    <span class="dot active"></span>
                    <span class="dot"></span>
                    <span class="dot"></span>
                  </div>
                </div>
              

              </div>

              <div class="villa-details">
                <div class="villa-title">
                  <h2>Seaview Villa Deluxe</h2>
                  <div class="labels">
                    <span class="guest-icon"></span>
                    <span>2 Queen Beds</span>
                    <span>2 Bathrooms</span>
                  </div>
                </div>
                <p class="villa-description">
                  Enjoy more space and privacy with deluxe features, private balcony, modern design, and stunning views. Perfect for families or groups seeking relaxation...<span class="view-more-text">View more</span>
                </p>
              </div>
            </div>
            <div class="rate-box">
              <div class="rate-info">
                <strong>Standard Rate</strong>
                <p>✔ Free Breakfast Included</p>
                <p>❗ Non-refundable</p>
                <span class="view-more-text">View more</span>
              </div>
              <div class="price-select">
                <div class="price">₱ 8,000</div>
                <div class="cost"><small></small></div>
                <!-- <p class="selected-message"></p> -->
                <button class="select-btn2" data-name="Seaview Villa Deluxe - Standard Rate" data-price="8000" disabled>Select</button>
              </div>
            </div>
          </div>
        </div>
      
       <!-- Dialog for Villa Details -->
<div id="villa-dialog" class="dialog" style="display: none;">
  <div class="dialog-content">
    <span class="close-villa-dialog">&times;</span>
    <div id="villa-dialog-body">
      <!-- Dynamic content goes here -->
    </div>
  </div>
</div>

      
     <!-- <div class="summary-box">
        <p>Sun, Apr 6 2025 - Mon, Apr 7 2025</p>
        <p>1 night<br>1 room, 2 guests</p>
        <hr />
        <p class="summary-prompt">Select a rate to continue</p>
        <button class="continue-btn0">Continue</button>
      </div>-->
    
    <div id="summary-container"></div>
    <div id="summary-container2"></div>
    <div id="summary-container3"></div>
    
    </div>
  </div>
  <div id="contact-container"  style="display: none;"></div>
  

  <div id="contact-overlay" class="contact-inline" style="display: none;">
    <section id="Contact" class="seventeenth-section">
      <form class="contact-form" action="guestinfo.php" method = "POST">
        <div class="form-row">
          <div class="form-group">
            <label for="firstname">Firstname</label>
            <input type="text" id="firstname" name="firstname" placeholder="Your name" required>
          </div>
          <div class="form-group">
            <label for="lastname">Lastname</label>
            <input type="text" id="lastname" name="lastname" placeholder="Your lastname" required>
          </div>
        </div>
      
        <div class="form-row">
          <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" placeholder="Your email" required>
          </div>
          <div class="form-group">
            <label for="contact-number">Contact Number</label>
            <input type="text" id="contact_number" name="contact_number" placeholder="e.g. 09123456789" required>
          </div>
        </div>
  
        <div class="form-row">
          <div class="form-group">
            <label for="home-address">Home Address</label>
            <input type="text" id="home-address" name="home_address" placeholder="Your Address" required>
          </div>
          <div class="form-group">
            <label for="street-name">Street Name</label>
            <input type="text" id="street-name" name="street_name" placeholder="Your Street Name" >
          </div>
        </div>
  
        <div class="form-row">
          <div class="form-group">
            <label for="barangay">Barangay/District/Locality</label>
            <input type="text" id="barangay" name="barangay" placeholder="Your Barangay" required>
          </div>
          <div class="form-group">
            <label for="municipality">City/Municipality</label>
            <input type="text" id="municipality" name="city_municipality" placeholder="Your City/Municipality" required>
          </div>
        </div>
  
        <div class="form-row">
          <div class="form-group">
            <label for="province">Province</label>
            <input type="text" id="province" name="province" placeholder="Your Province" required>
          </div>
          <div class="form-group">
            <label for="eta">Estimated Arrival Time</label>
            <input type="text" id="eta" name="eta" placeholder="Your Estimated Arrival Time">
          </div>
        </div>
      
        <div class="form-group full">
          <label for="special-request">Special Request</label>
          <textarea id="special-request" rows="4" name="special-request" placeholder="Type your request here..."></textarea>
        </div>
      
        <button type="submit" name="submit" class="submit-btn">Submit</button>
      </form>
    </section>
  </div>

<!-- POLICY MODAL -->
<div id="policy-modal" class="modal" style="display: none;">
  <div class="modal-content">
    <span class="close-modal" title="Close">&times;</span>
    <h2 class="modal-title">Check-In & Check-Out Policy</h2>
    <hr class="modal-divider">
    <div class="modal-body">
      <p>The standard check-in time is <strong>3:00 PM</strong>, while check-out is at <strong>12:00 NN</strong>.</p>
      <p>Early check-in from <strong>12:00 NN</strong> and late check-out until <strong>1:00 PM</strong> are free, subject to availability. Beyond that, additional charges apply:</p>
      <ul class="modal-list">
        <li><strong>2:00 AM – 10:59 AM</strong>: Early check-in at 50% of the room rate</li>
        <li><strong>2:00 PM – 5:00 PM</strong>: Late check-out at 50% of the room rate</li>
        <li><strong>After 5:00 PM</strong>: Full-day room rate applies</li>
      </ul>
      <p>All bookings are subject to availability and must be confirmed in writing.</p>
    </div>
    <button class="close-btn">I Understand</button>
  </div>
</div>

<!--
  <div id="contact-overlay" class="contact-modal" style="display: none;">
    <button id="close-contact" class="close-btn">✕</button>
    <section id="Contact" class="seventeenth-section">
      <form class="contact-form">
        <div class="form-row">
          <div class="form-group">
            <label for="name">Firstname</label>
            <input type="text" id="name" placeholder="Your name" >
          </div>
          <div class="form-group">
            <label for="lastname">Lastname</label>
            <input type="text" id="lastname" placeholder="Your lastname" >
          </div>
        </div>
      
        <div class="form-row">
          <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" placeholder="Your email" >
          </div>
          <div class="form-group">
            <label for="contact">Contact Number</label>
            <input type="text" id="contact" placeholder="e.g. 09123456789" >
          </div>
        </div>
      
        <div class="form-group full">
          <label for="message">Message</label>
          <textarea id="message" rows="4" placeholder="Type your message here..." ></textarea>
        </div>
      
        <button type="submit" class="submit-btn">Submit</button>
      </form>
    </section>
  </div>
-->




  <footer class="footer">
    <div class="footer-logo">
      <img src="logo.png" alt="Logo">
    </div>
    <div class="footer-icons">
      <a href="#"><img src="pic/facebook-new.png" alt="Facebook"></a>
      <a href="#"><img src="pic/insta.png" alt="Instagram"></a>
      <a href="#"><img src="pic/phone.png" alt="Phone"></a>
      <a href="#"><img src="pic/mail.png" alt="Email"></a>
    </div>
    <!--<nav class="footer-nav">
      <a href="#">Home</a> |
      <a href="#">About</a> |
      <a href="#">Experience</a> |
      <a href="#">Packages</a> |
      <a href="#">Contact</a>
    </nav>-->
    <p class="footer-text">COPYRIGHT © 2020 ALL RIGHTS RESERVED RESORT & SPA</p>
  </footer>

  <!-- Calendar JS -->
  <script>

/*The select disabler mwahahahaha*/
document.addEventListener("DOMContentLoaded", () => {
  document.querySelectorAll(".select-btn, .select-btn2").forEach(btn => {
    btn.disabled = true;
  });
});




/*Summary Box*/
function formatDate(dateString) {
  const date = new Date(dateString);
  const options = { weekday: 'short', month: 'short', day: 'numeric', year: 'numeric' };
  return date.toLocaleDateString('en-US', options);
}

function handleDateClick(target) {
  if (!target.classList.contains("calendar-day") || target.classList.contains("unavailable")) return;

  const selectedDate = target.dataset.date;

  if (!checkInDate || (checkInDate && checkOutDate)) {
    // First selection or reset
    clearSelections();
    checkInDate = selectedDate;
    checkOutDate = null;
    target.classList.add("selected");
    document.getElementById("summary-container").innerHTML = ""; // Clear previous summary
  } else if (selectedDate > checkInDate) {
    // Second selection
    checkOutDate = selectedDate;
    highlightRange(checkInDate, checkOutDate);

    const checkInFormatted = formatDate(checkInDate);
    const checkOutFormatted = formatDate(checkOutDate);
    const summaryHtml = `
      <div class="summary-box">
        <p>${checkInFormatted} - ${checkOutFormatted}</p>
        <p>1 night<br>1 room, 2 guests</p>
        <hr />
        <p class="summary-prompt">Select a rate to continue</p>
        <button class="continue-btn0">Continue</button>
      </div>
    `;

    document.getElementById("summary-container").innerHTML = summaryHtml;
    calendarWrapper.style.display = "none";
  } else {
    // Reset if second date is earlier
    clearSelections();
    checkInDate = selectedDate;
    checkOutDate = null;
    target.classList.add("selected");
    document.getElementById("summary-container").innerHTML = ""; // Clear summary again
  }
}





  const calendarWrapper = document.getElementById("calendar-wrapper");
  const openBtn = document.getElementById("open-calendar-btn");
  const closeBtn = document.getElementById("close-calendar-btn");
  const gridWrapper = document.getElementById("calendar-grid-wrapper");
  const monthsLabel = document.getElementById("calendar-months");
  const prevBtn = document.getElementById("prev-month-btn");
  const nextBtn = document.getElementById("next-month-btn");

  let checkInFormatted = "";
let checkOutFormatted = "";
let nightCount = 0;
let checkInDate = null;
let checkOutDate = null;
let currentGuestCount = 0;

  const calendarData = {
  // Unavailable dates
  "2025-05-06": { unavailable: true },
  "2025-05-13": { unavailable: true },
  "2025-05-21": { unavailable: true },
  "2025-05-22": { unavailable: true },
  "2025-05-23": { unavailable: true },
  "2025-05-24": { unavailable: true },
  "2025-06-14": { unavailable: true },
  "2025-06-19": { unavailable: true },
  
  // April 2025
  "2025-04-01": { price: "5K" },
  "2025-04-02": { price: "5K" },
  "2025-04-03": { price: "5.2K" },
  "2025-04-04": { price: "5.2K" },
  "2025-04-05": { price: "5.4K" },
  "2025-04-06": { price: "5.4K" },
  "2025-04-07": { price: "5.6K" },
  "2025-04-08": { price: "5.6K" },
  "2025-04-09": { price: "5.8K" },
  "2025-04-10": { price: "5.8K" },
  "2025-04-11": { price: "6K" },
  "2025-04-12": { price: "6K" },
  "2025-04-13": { price: "6.2K" },
  "2025-04-14": { price: "6.2K" },
  "2025-04-15": { price: "6.4K" },
  "2025-04-16": { price: "6.4K" },
  "2025-04-17": { price: "6.6K" },
  "2025-04-18": { price: "6.6K" },
  "2025-04-19": { price: "6.8K" },
  "2025-04-20": { price: "6.8K" },
  "2025-04-21": { price: "7K" },
  "2025-04-22": { price: "7K" },
  "2025-04-23": { price: "7.2K" },
  "2025-04-24": { price: "7.2K" },
  "2025-04-25": { price: "7.4K" },
  "2025-04-26": { price: "7.4K" },
  "2025-04-27": { price: "7.6K" },
  "2025-04-28": { price: "7.6K" },
  "2025-04-29": { price: "7.8K" },
  "2025-04-30": { price: "7.8K" },

  // May 2025
  "2025-05-01": { price: "8K" },
  "2025-05-02": { price: "8.2K" },
  "2025-05-03": { price: "8.4K" },
  "2025-05-04": { price: "8.6K" },
  "2025-05-05": { price: "8.8K" },
  "2025-05-07": { price: "9K" },
  "2025-05-08": { price: "9.2K" },
  "2025-05-09": { price: "9.4K" },
  "2025-05-10": { price: "9.6K" },
  "2025-05-11": { price: "9.8K" },
  "2025-05-12": { price: "10K" },
  "2025-05-14": { price: "10.2K" },
  "2025-05-15": { price: "10.4K" },
  "2025-05-16": { price: "10.6K" },
  "2025-05-17": { price: "10.8K" },
  "2025-05-18": { price: "11K" },
  "2025-05-19": { price: "11.2K" },
  "2025-05-20": { price: "11.4K" },
  "2025-05-25": { price: "11.6K" },
  "2025-05-26": { price: "11.8K" },
  "2025-05-27": { price: "12K" },
  "2025-05-28": { price: "12.2K" },
  "2025-05-29": { price: "12.4K" },
  "2025-05-30": { price: "12.6K" },
  "2025-05-31": { price: "12.8K" }
};

  let currentDate = new Date();

  const generateCalendar = () => {
    const month1 = new Date(currentDate.getFullYear(), currentDate.getMonth(), 1);
    const month2 = new Date(currentDate.getFullYear(), currentDate.getMonth() + 1, 1);

    const renderMonth = (date) => {
      const year = date.getFullYear();
      const month = date.getMonth();
      const daysInMonth = new Date(year, month + 1, 0).getDate();
      const firstDayIndex = new Date(year, month, 1).getDay();

      let html = `<div class="calendar-month-block">`;
      html += `<div class="calendar-header">${date.toLocaleString("default", { month: "long" })} ${year}</div>`;
      html += `<div class="calendar-weekdays">`;
      ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"].forEach(d => html += `<div>${d}</div>`);
      html += `</div><div class="calendar-days">`;

      for (let i = 0; i < firstDayIndex; i++) {
        html += `<div class="empty-day"></div>`;
      }

      for (let day = 1; day <= daysInMonth; day++) {
        const dateString = `${year}-${String(month + 1).padStart(2, "0")}-${String(day).padStart(2, "0")}`;
        const data = calendarData[dateString] || {};
const isUnavailable = data.unavailable;
const price = data.price || "";


        html += `<button class="calendar-day${isUnavailable ? " unavailable" : ""}" 
          ${isUnavailable ? "disabled" : ""} 
          data-date="${dateString}">
            ${day}<br><span>${price}</span>
        </button>`;
      }

      html += `</div></div>`;
      return html;
    };

    monthsLabel.innerHTML = "";
    gridWrapper.innerHTML = renderMonth(month1) + renderMonth(month2);
  };

  openBtn.addEventListener("click", () => {
    generateCalendar();
    calendarWrapper.style.display = "block";
  });

  closeBtn.addEventListener("click", () => {
    calendarWrapper.style.display = "none";
  });

  prevBtn.addEventListener("click", () => {
    currentDate.setMonth(currentDate.getMonth() - 1);
    generateCalendar();
  });

  nextBtn.addEventListener("click", () => {
    currentDate.setMonth(currentDate.getMonth() + 1);
    generateCalendar();
  });



function clearSelections() {
  document.querySelectorAll(".calendar-day").forEach(btn => {
    btn.classList.remove("selected", "range");
  });
}

function highlightRange(start, end) {
  const buttons = document.querySelectorAll(".calendar-day:not(.unavailable)");
  buttons.forEach(btn => {
    const date = btn.dataset.date;
    if (date >= start && date <= end) {
      if (date === start || date === end) {
        btn.classList.add("selected");
      } else {
        btn.classList.add("range");
      }
    }
  });
}

function handleDateClick(target) {
  if (!target.classList.contains("calendar-day") || target.classList.contains("unavailable")) return;

  const selectedDate = target.dataset.date;

  if (selectedDate > checkInDate) {
  checkOutDate = selectedDate;
  highlightRange(checkInDate, checkOutDate);
  checkIfReadyToEnableSelectButtons(); // 💥

  checkInFormatted = formatDate(checkInDate);
checkOutFormatted = formatDate(checkOutDate);
nightCount = (new Date(checkOutDate) - new Date(checkInDate)) / (1000 * 60 * 60 * 24);
 

  // Update summary (after closing the popup)
const summaryHtml = `
  <div class="summary-box">
    <p>${totalGuests} Guest${totalGuests !== 1 ? 's' : ''}, ${document.querySelectorAll('.room').length} Room${document.querySelectorAll('.room').length > 1 ? 's' : ''}</p>
    <hr />
    <p class="summary-prompt">Select dates and rates to continue</p>
  </div>
`;

document.getElementById("summary-container").innerHTML = summaryHtml;
  calendarWrapper.style.display = "none";
}
  else {
    // Reset if second date is earlier
    clearSelections();
    checkInDate = selectedDate;
    checkOutDate = null;
    target.classList.add("selected");

    document.getElementById("summary-container").innerHTML = ""; // Clear again
  }
}

document.addEventListener("click", (e) => {
  if (e.target.closest(".calendar-day")) {
    handleDateClick(e.target.closest(".calendar-day"));
  }
});
  function toggleContainer() {
  var container = document.getElementById("container");
  if (container.style.display === "none") {
    container.style.display = "block"; // Show the container
  } else {
    container.style.display = "none"; // Hide the container
  }
}

// Initially hide the container
document.getElementById("container").style.display = "none";

//Disable Buttons Again When Resetting Dates
function clearSelections() {
  document.querySelectorAll(".calendar-day").forEach(day => {
    day.classList.remove("selected", "in-range");
  });

  checkInDate = null;
  checkOutDate = null;

  // 🔒 Disable select buttons again
  document.querySelectorAll(".select-btn").forEach(btn => {
    btn.disabled = true;
  });
  updateCostBox();
  updateGuestIcons();
}





// Select main elements
const openRoomBtn = document.getElementById('openRoomBtn');
const roomPopup = document.getElementById('roomPopup');
const chooseRoomsStep = document.getElementById('choose-rooms-step');
const guestSelectionStep = document.getElementById('guest-selection-step');
const roomsContainer = document.getElementById('rooms-container');
const doneRoomBtn = document.getElementById('doneRoomBtn');
const summaryContainer = document.getElementById('summary-container');
const { totalAdults, totalChildren } = getGuestCount();
const totalGuests = totalAdults + totalChildren;
const totalRooms = document.querySelectorAll('.room').length;

// Open room selection popup
openRoomBtn.addEventListener('click', function() {
  roomPopup.style.display = 'block';
});

// Close popup
function closeRoomPopup() {
  roomPopup.style.display = 'none';
}

// Update room & guest info when Done clicked
doneRoomBtn.addEventListener("click", () => {
  document.getElementById('roomPopup').style.display = 'none'; // Hide popup
  updateCostBox();
  updateGuestIcons();
  // Update the button text
  const { totalAdults, totalChildren } = getGuestCount();
  const totalGuests = totalAdults + totalChildren;
  document.getElementById('openRoomBtn').textContent = `${totalGuests} Guest${totalGuests !== 1 ? 's' : ''}, ${document.querySelectorAll('.room').length} Room${document.querySelectorAll('.room').length > 1 ? 's' : ''}`;

  // 🆕 Update the summary box too
  const summaryHtml = `
      <div class="summary-box">
        <p>${checkInFormatted} - ${checkOutFormatted}</p>
        <p>
          ${nightCount} night${nightCount !== 1 ? 's' : ''}<br>
          ${totalAdults} adult${totalAdults !== 1 ? 's' : ''}, ${totalChildren} child${totalChildren !== 1 ? 'ren' : ''}
          <br>
         ${totalGuests} Guest${totalGuests !== 1 ? 's' : ''}, ${document.querySelectorAll('.room').length} Room${document.querySelectorAll('.room').length > 1 ? 's' : ''}
        </p>
        <hr />
        <p class="summary-prompt">Select a rate to continue</p>
        <button class="continue-btn0">Continue</button>
      </div>
    `;
  document.getElementById("summary-container").innerHTML = summaryHtml;
  openRoomBtn.textContent = `${totalGuests} Guest${totalGuests !== 1 ? 's' : ''}, ${totalRooms} Room${totalRooms !== 1 ? 's' : ''}`;
});
  // Update the openRoomBtn text
 


// Get guest counts
function getGuestCount() {
  let totalAdults = 0;
  let totalChildren = 0;

  const rooms = document.querySelectorAll(".room");

  rooms.forEach(room => {
    const guestControls = room.querySelectorAll(".guest-control");

    guestControls.forEach(control => {
      const label = control.querySelector("span")?.textContent.trim();
      const count = parseInt(control.querySelector(".count").textContent);

      if (label && label.startsWith("Adults")) {
        totalAdults += count;
      } else if (label && label.startsWith("Children")) {
        totalChildren += count;
      }
    });
  });

  return { totalAdults, totalChildren };
}

// When user clicks a date (from calendar)
function handleDateClick(target) {
  if (!target.classList.contains("calendar-day") || target.classList.contains("unavailable")) return;

  const selectedDate = target.dataset.date;

  if (selectedDate > checkInDate) {
    checkOutDate = selectedDate;
    highlightRange(checkInDate, checkOutDate);

    checkInFormatted = formatDate(checkInDate);
checkOutFormatted = formatDate(checkOutDate);
nightCount = (new Date(checkOutDate) - new Date(checkInDate)) / (1000 * 60 * 60 * 24);

    

    // Get updated guest counts
    const { totalAdults, totalChildren } = getGuestCount();
    const totalGuests = totalAdults + totalChildren;
    const totalRooms = document.querySelectorAll('.room').length;

    // Generate the summary
    const summaryHtml = `
      <div class="summary-box">
        <p>${checkInFormatted} - ${checkOutFormatted}</p>
        <p>
          ${nightCount} night${nightCount !== 1 ? 's' : ''}<br>
          ${totalAdults} adult${totalAdults !== 1 ? 's' : ''}, ${totalChildren} child${totalChildren !== 1 ? 'ren' : ''}
          <br>
         ${totalGuests} Guest${totalGuests !== 1 ? 's' : ''}, ${document.querySelectorAll('.room').length} Room${document.querySelectorAll('.room').length > 1 ? 's' : ''}
        </p>
        <hr />
        <p class="summary-prompt">Select a rate to continue</p>
        <button class="continue-btn0">Continue</button>
      </div>
    `;

    summaryContainer.innerHTML = summaryHtml;
    calendarWrapper.style.display = "none"; // Hide calendar after selection
  } else {
    // If second date is earlier, reset
    clearSelections();
    checkInDate = selectedDate;
    checkOutDate = null;
    target.classList.add("selected");

    

    summaryContainer.innerHTML = ""; // Clear summary
  }
  document.getElementById('open-calendar-btn').textContent = `${checkInFormatted} - ${checkOutFormatted}`;
    /*The villa card Cost*/
document.querySelector('.cost').innerHTML = `<small>Cost for '${nightCount}' night${nightCount !== 1 ? 's' : ''}, ${totalGuests} guest${totalGuests !== 1 ? 's' : ''}</small>`;
}


// Handling Room & Guest selection step
document.querySelectorAll(".room-option").forEach(button => {
  button.addEventListener("click", () => {
    const numberOfRooms = parseInt(button.getAttribute("data-rooms"));
    chooseRoomsStep.style.display = "none";
    guestSelectionStep.style.display = "block";

    // Clear existing rooms
    roomsContainer.innerHTML = "";

    // Create rooms dynamically
    for (let i = 1; i <= numberOfRooms; i++) {
      const roomDiv = document.createElement("div");
      roomDiv.classList.add("room");

      const roomTitle = document.createElement("span");
      roomTitle.classList.add("room-title");
      roomTitle.textContent = `Room ${i}`;

      const guestGroup = document.createElement("div");
      guestGroup.classList.add("guest-group");

      // Adult control
      const adultControl = document.createElement("div");
      adultControl.classList.add("guest-control");
      adultControl.innerHTML = `
        <span>Adults<br><small>Ages 13+</small></span>
        <div class="counter">
          <button class="minus">−</button>
          <span class="count">0</span>
          <button class="plus">+</button>
        </div>`;

      // Child control
      const childControl = document.createElement("div");
      childControl.classList.add("guest-control");
      childControl.innerHTML = `
        <span>Children<br><small>Ages 2–12</small></span>
        <div class="counter">
          <button class="minus">−</button>
          <span class="count">0</span>
          <button class="plus">+</button>
        </div>`;

      guestGroup.appendChild(adultControl);
      guestGroup.appendChild(childControl);

      roomDiv.appendChild(roomTitle);
      roomDiv.appendChild(guestGroup);
      roomsContainer.appendChild(roomDiv);





      // Setup counters
      const counters = roomDiv.querySelectorAll(".counter");
      counters.forEach(counter => {
        const minusBtn = counter.querySelector(".minus");
        const plusBtn = counter.querySelector(".plus");
        const countSpan = counter.querySelector(".count");

        minusBtn.addEventListener("click", () => {
          let val = parseInt(countSpan.textContent);
          if (val > 0) {
            countSpan.textContent = val - 1;
            checkCounters();
            updateGuestIcons(); // if you added that
            checkIfReadyToEnableSelectButtons(); // 💥
            updateCurrentGuestCount(); // 💥
          }
          
        });

        plusBtn.addEventListener("click", () => {
          let val = parseInt(countSpan.textContent);
          countSpan.textContent = val + 1;
          checkCounters();
          updateGuestIcons(); // if you added that
          checkIfReadyToEnableSelectButtons(); // 💥
          updateCurrentGuestCount(); // 💥

        });
      });
    }
  });
});

// Check if each room has at least 1 adult
function checkCounters() {
  const rooms = document.querySelectorAll(".room");
  let allRoomsHaveAdults = true;

  rooms.forEach(room => {
    const guestControls = room.querySelectorAll(".guest-control");
    let adultCount = 0;

    guestControls.forEach(control => {
      const label = control.querySelector("span")?.textContent.trim();
      if (label && label.startsWith("Adults")) {
        adultCount = parseInt(control.querySelector(".count").textContent);
      }
    });

    if (adultCount <= 0) {
      allRoomsHaveAdults = false;
    }
  });

  doneRoomBtn.disabled = !allRoomsHaveAdults;


}

// Initial disable Done button
checkCounters();

//pang display ng Cost
function updateCostBox() {
  if (!checkInDate || !checkOutDate) return;

  const { totalAdults, totalChildren } = getGuestCount();
  const totalGuests = totalAdults + totalChildren;
  const nightCount = (new Date(checkOutDate) - new Date(checkInDate)) / (1000 * 60 * 60 * 24);

  const costDivs = document.querySelectorAll('.cost'); // Find ALL .cost divs

  costDivs.forEach(div => {
    div.innerHTML = `<small>Cost for '${nightCount}' night${nightCount !== 1 ? 's' : ''}, ${totalGuests} guest${totalGuests !== 1 ? 's' : ''}</small>`;
  });
}
//guest icon2
function updateGuestIcons() {
  const { totalAdults, totalChildren } = getGuestCount();
  const totalGuests = totalAdults + totalChildren;

  const guestSpans = document.querySelectorAll('.guest-icon'); // Use a class for the spans

  guestSpans.forEach(span => {
    span.innerHTML = `👤 ${totalGuests}`;
  });
}


function checkIfReadyToEnableSelectButtons() {
  const { totalAdults, totalChildren } = getGuestCount();
  const totalGuests = totalAdults + totalChildren;

  console.log('Total guests:', totalGuests); // Debugging

  // Enable/disable select buttons
  document.querySelectorAll(".select-btn, .select-btn2").forEach(btn => {
    btn.disabled = !(checkInDate && checkOutDate && totalGuests > 0);
  });

  // Update .value text
  document.querySelectorAll('.value').forEach(p => {
    p.textContent = totalGuests;
  });

  // 🛠 Add these:
  updateCostBox();   // Update the cost boxes
  updateGuestIcons(); // Update guest icons
}
function updateCurrentGuestCount() {
  const { totalAdults, totalChildren } = getGuestCount();
  currentGuestCount = totalAdults + totalChildren;
}


 //carousel
 document.querySelectorAll('[data-carousel]').forEach((carousel) => {
    let index = 0;

    const testimonials = carousel.querySelectorAll('.testimonial');
    const dots = carousel.querySelectorAll('.dot');
    const prevBtn = carousel.querySelector('.prev');
    const nextBtn = carousel.querySelector('.next');

    function showSlide(i) {
      testimonials.forEach((t, idx) => {
        t.classList.toggle('active', idx === i);
        dots[idx].classList.toggle('active', idx === i);
      });
      index = i;
    }

    prevBtn?.addEventListener('click', () => {
      index = (index - 1 + testimonials.length) % testimonials.length;
      showSlide(index);
    });

    nextBtn?.addEventListener('click', () => {
      index = (index + 1) % testimonials.length;
      showSlide(index);
    });

    dots.forEach((dot, i) => {
      dot.addEventListener('click', () => showSlide(i));
    });

    setInterval(() => {
      index = (index + 1) % testimonials.length;
      showSlide(index);
    }, 6000);
  });
/*
  //youve selected dis 1
  document.querySelectorAll('.select-btn').forEach(button => {
    button.addEventListener('click', () => {
      // Hide the button
      button.style.display = 'none';

      // Find the closest rate-info block to place the message
      const rateBox = button.closest('.rate-box');
      const message = rateBox.querySelector('.selected-message');

      // Add the message
      message.textContent = "";
    });
  });

  //youve selected dis 1
  document.querySelectorAll('.select-btn2').forEach(button => {
    button.addEventListener('click', () => {
      // Hide the button
      button.style.display = 'none';

      // Find the closest rate-info block to place the message
      const rateBox = button.closest('.rate-box');
      const message = rateBox.querySelector('.selected-message');

      // Add the message
      message.textContent = "";
    });
  });
*/
//select btn fade away lolololololol
document.addEventListener("DOMContentLoaded", () => {
  const selectButtons = document.querySelectorAll(".select-btn, .select-btn2");

  selectButtons.forEach(button => {
    button.addEventListener("click", () => {
      // ✅ Check if a villa has already been selected
      const alreadySelected = document.querySelector(".villa-card.selected-card, .villa-card2.selected-card");
      if (alreadySelected) return; // stop further selections

      // ✅ Mark the clicked card as selected
      const thisCard = button.closest(".villa-card, .villa-card2");
      button.textContent = "Selected";
      button.disabled = true;
      button.classList.add("selected");
      thisCard.classList.add("selected-card");
      
      // ✅ Optional: Show confirmation message
      const message = thisCard.querySelector(".selected-message");
      if (message) message.textContent = "";

      // ✅ Hide the other select button
      selectButtons.forEach(btn => {
        if (btn !== button) {
          btn.style.display = "none";  // Hide the other button completely
        }
      });
    });
  });
});
// lock



//Booking Details
document.addEventListener('DOMContentLoaded', () => {
  document.querySelectorAll('.select-btn').forEach(btn => {
    btn.addEventListener('click', function () {
      const villaName = this.getAttribute('data-name');
      const price = parseFloat(this.getAttribute('data-price'));
      const vat = price * 0.04;
      const total = price + vat;

      const { totalAdults, totalChildren } = getGuestCount();
  const totalGuests = totalAdults + totalChildren;

 // Format selected check-in and check-out dates
 const checkInFormatted = checkInDate ? formatDate(checkInDate) : 'Not selected';
    const checkOutFormatted = checkOutDate ? formatDate(checkOutDate) : 'Not selected';


      // ⛔ Hide all summary-boxes
      document.querySelectorAll('.summary-box').forEach(box => {
        box.style.display = 'none';
      });

      // ✅ Show the summary container
      const summaryContainer = document.getElementById('summary-container');
      summaryContainer.style.display = 'block';

      const confirmation = document.createElement("p");
      confirmation.textContent = "You've selected this one";
      confirmation.style.fontWeight = "bold";
      confirmation.style.color = "#107a49";
      this.parentElement.appendChild(confirmation);

      const summaryHTML = `
        <div class="booking-summary">
          <h3 class="summary-title">Booking Details</h3>
          <div class="villa-name">${villaName}</div>

          <div class="summary-card">
            <div class="summary-info">
              <div>
                <p class="label">CHECK IN</p>
                <p class="value">${checkInFormatted}</p>
              </div>
              <div>
                <p class="label">CHECK OUT</p>
                <p class="value">${checkOutFormatted}</p>
              </div>
              <div>
                <p class="label">👤</p>
                <p class="value">${totalGuests}</p>
              </div>
            </div>
            <div class="price-row">
              <span>Room - 1</span>
              <span>₱ ${price.toFixed(2)}</span>
            </div>
            <div class="price-row subtotal">
              <span>Subtotal</span>
              <span>₱ ${price.toFixed(2)}</span>
            </div>
          </div>

          <div class="summary-total">
            <div class="total-line">
              <span>Total</span>
              <span>₱ ${total.toFixed(2)}</span>
            </div>
            <p class="small-text">Included taxes + fees</p>
            <div class="total-line vat">
              <span>VAT</span>
              <span>₱ ${vat.toFixed(2)}</span>
            </div>
            <div class="payment-info">
              <p><strong>Book Now, Pay Later!</strong></p>
              <p>Outstanding Balance: ₱${total.toFixed(2)}</p>
            </div>
          </div>

          <button class="continue-btn" data-name="${villaName}" data-price="${price}" >Continue</button>
        </div>
      `;

      summaryContainer.innerHTML = summaryHTML;
    });
  });
});

//Booking Details 2
document.addEventListener('DOMContentLoaded', () => {
  document.querySelectorAll('.select-btn2').forEach(btn => {
    btn.addEventListener('click', function () {
      const villaName = this.getAttribute('data-name');
      const price = parseFloat(this.getAttribute('data-price'));
      const vat = price * 0.04;
      const total = price + vat;

      const { totalAdults, totalChildren } = getGuestCount();
  const totalGuests = totalAdults + totalChildren;

 // Format selected check-in and check-out dates
 const checkInFormatted = checkInDate ? formatDate(checkInDate) : 'Not selected';
    const checkOutFormatted = checkOutDate ? formatDate(checkOutDate) : 'Not selected';

      // ⛔ Hide all summary-boxes
      document.querySelectorAll('.summary-box').forEach(box => {
        box.style.display = 'none';
      });

      // ✅ Show the summary container
      const summaryContainer = document.getElementById('summary-container2');
      summaryContainer.style.display = 'block';

      const confirmation = document.createElement("p");
      confirmation.textContent = "You've selected this one";
      confirmation.style.fontWeight = "bold";
      confirmation.style.color = "#107a49";
      this.parentElement.appendChild(confirmation);

      const summaryHTML = `
        <div class="booking-summary">
          <h3 class="summary-title">Booking Details</h3>
          <div class="villa-name">${villaName}</div>

          <div class="summary-card">
            <div class="summary-info">
              <div>
                <p class="label">CHECK IN</p>
                <p class="value">${checkInFormatted}</p>
              </div>
              <div>
                <p class="label">CHECK OUT</p>
                <p class="value">${checkOutFormatted}</p>
              </div>
              <div>
                <p class="label">👤</p>
                <p class="value">${totalGuests}</p>
              </div>
            </div>
            <div class="price-row">
              <span>Room - 2</span>
              <span>₱ ${price.toFixed(2)}</span>
            </div>
            <div class="price-row subtotal">
              <span>Subtotal</span>
              <span>₱ ${price.toFixed(2)}</span>
            </div>
          </div>

          <div class="summary-total">
            <div class="total-line">
              <span>Total</span>
              <span>₱ ${total.toFixed(2)}</span>
            </div>
            <p class="small-text">Included taxes + fees</p>
            <div class="total-line vat">
              <span>VAT</span>
              <span>₱ ${vat.toFixed(2)}</span>
            </div>
            <div class="payment-info">
              <p><strong>Book Now, Pay Later!</strong></p>
              <p>Outstanding Balance: ₱${total.toFixed(2)}</p>
            </div>
          </div>

         <button class="continue-btn2" data-name="${villaName}" data-price="${price}" >Continue</button>
        </div>
      `;

      summaryContainer.innerHTML = summaryHTML;
      // 🔥 Show the button now that booking info is ready
const continueBtn = summaryContainer.querySelector('.continue-btn,.continue-btn2');

if (continueBtn) {
  continueBtn.style.display = 'block';
}
    });
  });
});

// Booking Details 3 — Handles the Continue button Part1

document.addEventListener('click', function (e) {
  if (e.target.classList.contains('continue-btn')) {
    const btn = e.target;
    const villaName = btn.getAttribute('data-name') || 'Unknown Villa';
    const price = parseFloat(btn.getAttribute('data-price')) || 0;
    const vat = price * 0.04;
    const total = price + vat;

    const { totalAdults, totalChildren } = getGuestCount();
  const totalGuests = totalAdults + totalChildren;

    // Format selected check-in and check-out dates
    const checkInFormatted = checkInDate ? formatDate(checkInDate) : 'Not selected';
    const checkOutFormatted = checkOutDate ? formatDate(checkOutDate) : 'Not selected';

    // ⛔ Hide all other booking summaries
    document.querySelectorAll('.booking-summary').forEach(summary => {
      summary.style.display = 'none';
    });

    // ✅ Show the correct summary container
    const summaryContainer = document.getElementById('summary-container3');
    summaryContainer.style.display = 'block';

    // 💡 Fill it with updated content
    summaryContainer.innerHTML = `
      <div class="booking-summary">
        <h3 class="summary-title">Booking Details</h3>
        <div class="villa-name">${villaName}</div>

        <div class="summary-card">
          <div class="summary-info">
            <div>
              <p class="label">CHECK IN</p>
              <p class="value">${checkInFormatted}</p>
            </div>
            <div>
              <p class="label">CHECK OUT</p>
             <p class="value">${checkOutFormatted}</p>
            </div>
            <div>
              <p class="label">👤</p>
              <p class="value">${totalGuests}</p>
            </div>
          </div>
          <div class="price-row">
            <span>Room - 1</span>
            <span>₱ ${price.toFixed(2)}</span>
          </div>
          <div class="price-row subtotal">
            <span>Subtotal</span>
            <span>₱ ${price.toFixed(2)}</span>
          </div>
        </div>

        <div class="summary-total">
          <div class="total-line">
            <span>Total</span>
            <span>₱ ${total.toFixed(2)}</span>
          </div>
          <p class="small-text">Included taxes + fees</p>
          <div class="total-line vat">
            <span>VAT</span>
            <span>₱ ${vat.toFixed(2)}</span>
          </div>
          <div class="payment-info">
            <p><strong>Book Now, Pay Later!</strong></p>
            <p>Outstanding Balance: ₱${total.toFixed(2)}</p>
          </div>
        </div>

        <div class="terms-and-conditions">
          <label>
            <input type="checkbox" id="agreeTerms" />
            I have read and agree to the <a href="#">terms and conditions</a>
          </label>
        </div>

        <div class="action-buttons">
          <button class="book-now-btn">Book Now</button>
          <button class="pay-now-btn">Pay Now</button>
        </div>
      </div>
    `;
  }
});

// Booking Details 3 — Handles the Continue button Part2
document.addEventListener('click', function (e) {
  if (e.target.classList.contains('continue-btn2')) {
    const btn = e.target;
    const villaName = btn.getAttribute('data-name') || 'Unknown Villa';
    const price = parseFloat(btn.getAttribute('data-price')) || 0;
    const vat = price * 0.04;
    const total = price + vat;

    const { totalAdults, totalChildren } = getGuestCount();
  const totalGuests = totalAdults + totalChildren;

 // Format selected check-in and check-out dates
 const checkInFormatted = checkInDate ? formatDate(checkInDate) : 'Not selected';
    const checkOutFormatted = checkOutDate ? formatDate(checkOutDate) : 'Not selected';


    // ⛔ Hide all other booking summaries
    document.querySelectorAll('.booking-summary').forEach(summary => {
      summary.style.display = 'none';
    });

    // ✅ Show the correct summary container
    const summaryContainer = document.getElementById('summary-container3');
    summaryContainer.style.display = 'block';

    // 💡 Fill it with updated content
    summaryContainer.innerHTML = `
      <div class="booking-summary">
        <h3 class="summary-title">Booking Details</h3>
        <div class="villa-name">${villaName}</div>

        <div class="summary-card">
          <div class="summary-info">
            <div>
              <p class="label">CHECK IN</p>
              <p class="value">${checkInFormatted}</p>
            </div>
            <div>
              <p class="label">CHECK OUT</p>
              <p class="value">${checkOutFormatted}</p>
            </div>
            <div>
              <p class="label">👤</p>
              <p class="value">${totalGuests}</p>
            </div>
          </div>
          <div class="price-row">
            <span>Room - 2</span>
            <span>₱ ${price.toFixed(2)}</span>
          </div>
          <div class="price-row subtotal">
            <span>Subtotal</span>
            <span>₱ ${price.toFixed(2)}</span>
          </div>
        </div>

        <div class="summary-total">
          <div class="total-line">
            <span>Total</span>
            <span>₱ ${total.toFixed(2)}</span>
          </div>
          <p class="small-text">Included taxes + fees</p>
          <div class="total-line vat">
            <span>VAT</span>
            <span>₱ ${vat.toFixed(2)}</span>
          </div>
          <div class="payment-info">
            <p><strong>Book Now, Pay Later!</strong></p>
            <p>Outstanding Balance: ₱${total.toFixed(2)}</p>
          </div>
        </div>

        <div class="terms-and-conditions">
          <label>
            <input type="checkbox" id="agreeTerms"  />
            I have read and agree to the <a href="#">terms and conditions</a>
          </label>
        </div>

        <div class="action-buttons">
          <button class="book-now-btn">Book Now</button>
          <button class="pay-now-btn">Pay Now</button>
        </div>
      </div>
    `;
  }
});

/*
// SHOW contact modal
document.addEventListener('click', function (event) {
  if (event.target.classList.contains('continue-btn') || event.target.classList.contains('continue-btn2')) {
    const contactOverlay = document.getElementById('contact-overlay');
    contactOverlay.style.display = 'flex';
    document.body.style.overflow = 'hidden'; // prevent background scroll
  }
});

// CLOSE contact modal (only if all fields are filled)

document.addEventListener('click', function (event) {
  if (event.target.id === 'close-contact') {
    const contactOverlay = document.getElementById('contact-overlay');
    const inputs = contactOverlay.querySelectorAll('input, textarea');
    let allFilled = true;

    inputs.forEach(input => {
      if (!input.value.trim()) {
        allFilled = false;
      }
    });

    if (allFilled) {
      contactOverlay.style.display = 'none';
      document.body.style.overflow = ''; // restore scroll
    } else {
      alert('Please fill out all fields before closing the form.');
    }
  }
}); 

*/


// Handle contact form submission
/*document.addEventListener('DOMContentLoaded', function () {
  const form = document.querySelector('#contact-overlay .contact-form');

  form.addEventListener('submit', function (e) {
    e.preventDefault(); // Prevent the default form submission

    const inputs = form.querySelectorAll('input, textarea');
    let allFilled = true;

    inputs.forEach(input => {
      if (!input.value.trim()) {
        allFilled = false;
        input.classList.add('input-error'); // Optional: highlight empty fields
      } else {
        input.classList.remove('input-error');
      }
    });

    if (allFilled) {
      // Close the modal
      const contactOverlay = document.getElementById('contact-overlay');
      contactOverlay.style.display = 'none';
      document.body.style.overflow = '';
      form.reset(); // Optional: clear form fields
    } else {
      alert('Please fill in all fields before submitting.');
    }
  });
});

*/

  // select buttons
  
  document.addEventListener("DOMContentLoaded", () => {
  const selectButtons = document.querySelectorAll(".select-btn, .select-btn2");

  selectButtons.forEach(button => {
    button.addEventListener("click", () => {
      // Remove previous selection
      document.querySelectorAll(".villa-card, .villa-card2").forEach(card => {
        card.classList.remove("selected-card");
        const btn = card.querySelector(".select-btn, .select-btn2");
        if (btn) {
          btn.textContent = "Select";
          btn.disabled = false;
          btn.classList.remove("selected");
        }
        const msg = card.querySelector(".selected-message");
        if (msg) msg.textContent = "";
      });

      // Mark the clicked card as selected
      const thisCard = button.closest(".villa-card, .villa-card2");
      button.textContent = "Selected";
      button.disabled = true;
      button.classList.add("selected");
      thisCard.classList.add("selected-card");
      const message = thisCard.querySelector(".selected-message");
      if (message) message.textContent = "✔ You selected this villa.";
    });
  });
});

document.addEventListener('DOMContentLoaded', function () {
  const selectButtons = document.querySelectorAll('.select-btn, .select-btn2');
  const contactOverlay = document.getElementById('contact-overlay');

  selectButtons.forEach(button => {
    button.addEventListener('click', function () {
      const card = button.closest('.villa-card, .villa-card2');

      // Move the form right below the clicked villa card
      card.insertAdjacentElement('afterend', contactOverlay);
      contactOverlay.style.display = 'block';

      // Optional: scroll to the form
      contactOverlay.scrollIntoView({ behavior: 'smooth', block: 'start' });
    });
  });

  // Optional: reset form on submit
  const form = contactOverlay.querySelector('form');
  form.addEventListener('submit', function (e) {
    // e.preventDefault();
    // alert('Form submitted!'); // Replace with actual submit logic
    // form.reset();
    contactOverlay.style.display = 'none';
  });
});


//Policy!!!!
function attachPolicyModalEvent() {
  const policyModal = document.getElementById('policy-modal');

  document.addEventListener('click', function (event) {
    const target = event.target;

    // Show modal when any continue button is clicked
    if (target.classList.contains('continue-btn') || target.classList.contains('continue-btn2')) {
      console.log("Continue button clicked");
      policyModal.style.display = 'flex';
    }

    // Close modal on close icon or Continue inside modal
    if (target.classList.contains('close-modal') || target.classList.contains('close-btn')) {
      policyModal.style.display = 'none';
    }

    // Click outside modal content to close
    if (target.id === 'policy-modal') {
      policyModal.style.display = 'none';
    }
  });
}

// Make sure it's called
document.addEventListener('DOMContentLoaded', attachPolicyModalEvent);

//Villa cancellation
function setupVillaDialog() {
  const dialog = document.getElementById('villa-dialog');
  const dialogBody = document.getElementById('villa-dialog-body');

  document.addEventListener('click', function (e) {
    // Open dialog when clicking view-more-text
    if (e.target.classList.contains('view-more-text')) {
      const card = e.target.closest('.villa-card, .villa-card2');
      
      if (card.classList.contains('villa-card')) {
        // Seaview Villa content
        dialogBody.innerHTML = `
  <h2>Seaview Villa - Standard Rate</h2>
  <div class="dialog-section">
    <h3>Cancellation Policy</h3>
    <ul>
      <li>50% off total accommodation is due within 7 days of booking confirmation and final balance will be due 60 days prior to arrival.</li>
      <li>Up until 60 days prior to arrival – all payments will be refunded.</li>
      <li>Less than 60 days prior to arrival are subject to 100% cancellation fee of all monies received.</li>
      <li>If you cancel within 60 days, we may offer the option to rebook your stay.</li>
      <li>In case of <em>force majeure</em>, Resort may consider refunding your deposit.</li>
    </ul>
  </div>
  <div class="dialog-section">
    <h3>Room Features</h3>
    <ul>
      <li>Max Occupancy: Sleeps 3</li>
      <li>Bed Size: 1 King Bed</li>
      <li>Room Size: 153.3m²</li>
      <li>Number of Bathrooms: 1</li>
      <li>View: Ocean View</li>
      <li>Smoking: Non-Smoking</li>
    </ul>
  </div>
  <div class="dialog-section">
    <h3>Amenities</h3>
    <div class="amenities">
      <span>Air Conditioned</span>
      <span>Wireless Internet</span>
      <span>Room Service</span>
      <span>Television</span>
    </div>
  </div>
`;
      } else if (card.classList.contains('villa-card2')) {
        // Seaview Villa Deluxe content
        dialogBody.innerHTML = `
  <h2>Seaview Villa - Standard Rate</h2>
  <div class="dialog-section">
    <h3>Cancellation Policy</h3>
    <ul>
      <li>50% off total accommodation is due within 7 days of booking confirmation and final balance will be due 60 days prior to arrival.</li>
      <li>Up until 60 days prior to arrival – all payments will be refunded.</li>
      <li>Less than 60 days prior to arrival are subject to 100% cancellation fee of all monies received.</li>
      <li>If you cancel within 60 days, we may offer the option to rebook your stay.</li>
      <li>In case of <em>force majeure</em>, Resort may consider refunding your deposit.</li>
    </ul>
  </div>
  <div class="dialog-section">
    <h3>Room Features</h3>
    <ul>
      <li>Max Occupancy: Sleeps 3</li>
      <li>Bed Size: 1 King Bed</li>
      <li>Room Size: 153.3m²</li>
      <li>Number of Bathrooms: 1</li>
      <li>View: Ocean View</li>
      <li>Smoking: Non-Smoking</li>
    </ul>
  </div>
  <div class="dialog-section">
    <h3>Amenities</h3>
    <div class="amenities">
      <span>Air Conditioned</span>
      <span>Wireless Internet</span>
      <span>Room Service</span>
      <span>Television</span>
    </div>
  </div>
`;
      }

      dialog.style.display = 'flex';
    }

    // Close dialog when clicking close icon or outside content
    if (e.target.classList.contains('close-villa-dialog') || e.target.id === 'villa-dialog') {
      dialog.style.display = 'none';
    }
  });
}

// Call it after page loads
document.addEventListener('DOMContentLoaded', setupVillaDialog);

</script>

</body>
</html>




  

  


