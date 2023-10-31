import './bootstrap';

import '../sass/app.scss';

import '../css/app.css';

import * as bootstrap from 'bootstrap';

// Import Font Awesome CSS
import 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css';

// Import Font Awesome JS
import 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/js/all.min.js';



//tool tips
const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))

$('#opn-cls-btn button').on('click', function() {
   if ($(this).hasClass('open-btn')) {
     $(this).removeClass('open-btn').addClass('close-btn');
     $('#side_nav').css('margin-left', '0');
     $(this).css('margin-left', '250px');
     $('i.fa-bars-staggered').removeClass('fa-bars-staggered').addClass('fa-xmark');
   } else {
     $(this).removeClass('close-btn').addClass('open-btn');
     $('#side_nav').css('margin-left', '-250px');
     $(this).css('margin-left', '0');
     $('i.fa-xmark').removeClass('fa-xmark').addClass('fa-bars-staggered');
   }
 });

// Close add document modal after inputs are validated
window.addEventListener('closeAddDocumentModal', event => {
  $('#addDocumentModal').modal('hide');
});

// Clears the file input field for add document modal
window.addEventListener('clearInputFile', event => {
    document.getElementById("document").value = "";
});


// Close delete document modal 
window.addEventListener('closeDeleteDocumentModal', event => {
  $('#deleteDocument-'+ event.detail.id).modal('hide');
});

// Close edit document modal 
window.addEventListener('closeEditDocumentModal', event => {
  $('#editDocument-'+ event.detail.id).modal('hide');
});


// Categories Carousel
const multipleItemCarousel = document.querySelector('#categoriesCarousel')
const showSeeAll = document.querySelector('#showSeeAll')

if(window.matchMedia("(min-width:576px)").matches){
  if (multipleItemCarousel){
    const carousel = new bootstrap.Carousel(multipleItemCarousel, {
      interval: false,
    });
  
  

  var carouselWidth = $('#categories .carousel-inner')[0].scrollWidth;
  var cardWidth = $('#categories .carousel-item').width();

  var scrollPosition = 0;

  $('#categories .carousel-control-next').on('click', function() {
    if(scrollPosition < (carouselWidth - (cardWidth * 5))) {
      scrollPosition = scrollPosition + cardWidth;
      $('#categories .carousel-inner').animate({scrollLeft: scrollPosition}, 600);
    }
  });

  $('#categories .carousel-control-prev').on('click', function() {
    if(scrollPosition > 0 ){
      scrollPosition = scrollPosition - cardWidth;
      $('#categories .carousel-inner').animate({scrollLeft: scrollPosition}, 600);
    }
  });
}
} else {
  $(multipleItemCarousel).addClass('slide');
}





 



