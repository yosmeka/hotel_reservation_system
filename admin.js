function openTab(evt, tabId) {
  // Get all tab content elements
  if (tabId === 'tab4') {
    // Redirect to the desired page
    window.location.href = 'Book.php';
  } else{
  var tabContent = document.getElementsByClassName("tab-content");
  
  // Hide all tab content
  for (var i = 0; i < tabContent.length; i++) {
    tabContent[i].style.display = "none";
  }
  
  // Remove "active" class from all tabs
  var tabs = document.getElementsByClassName("tab");
  for (var i = 0; i < tabs.length; i++) {
    tabs[i].classList.remove("active");
  }
  
  // Show the selected tab content
  document.getElementById(tabId).style.display = "flex";
  
  // Add "active" class to the clicked tab
  evt.currentTarget.classList.add("active");
}
}

$(document).ready(function() {
  $('.slider').slick({
    dots: true,
    arrows: false,
    autoplay: true,
    autoplaySpeed: 3000,
    slidesToShow: 1,
    slidesToScroll: 1,
    fade: true,
    cssEase: 'linear',
    adaptiveHeight: true
  });
});



