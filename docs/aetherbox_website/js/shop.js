

// Get the button
let scrollButton = document.getElementById("scroll-to-top");

// When the user scrolls down 300px from the top of the document, show the button
window.onscroll = function() {scrollFunction()};

function scrollFunction() {
  if (document.body.scrollTop > 300 || document.documentElement.scrollTop > 300) {
    scrollButton.style.display = "block";
  } else {
    scrollButton.style.display = "none";
  }
}

// When the user clicks on the button, scroll to the top of the document
scrollButton.addEventListener("click", function() {
  // For smooth scrolling
  window.scrollTo({
    top: 0,
    behavior: "smooth"
  });
  
  // Alternative method for older browsers
  // document.body.scrollTop = 0; // For Safari
  // document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE and Opera
});