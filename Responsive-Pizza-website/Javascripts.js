/*=============== SHOW MENU ===============*/
const navMenu = document.getElementById('nav-menu'),
      navToggle = document.getElementById('nav-toggle'),
      navClose = document.getElementById('nav-close');

// Show menu
if (navToggle) {
  navToggle.addEventListener('click', () => {
    navMenu.classList.add('show-menu');
  });
}

// Hide menu
if (navClose) {
  navClose.addEventListener('click', () => {
    navMenu.classList.remove('show-menu');
  });
}



/*=============== REMOVE MENU MOBILE ===============*/

// All links with class="nav-list"
const navLinks = document.querySelectorAll('.nav-list');

const linkAction = () => {
  const navMenu = document.getElementById('nav-menu');
  navMenu.classList.remove('show-menu');
};

navLinks.forEach(n => n.addEventListener('click', linkAction));

/*=============== ADD SHADOW HEADER ===============*/
const scrollHeader =() =>{
  const shadowlHeader = document.getElementById('header')
  //add a class if the bottom offset is greter than 50 of
  this.scrollY >= 50 ? header.classList.add('shadow-header')
  :header.classList.remove('shadow-header')
}
window.addEventListener('scroll',shadowlHeader)
/*=============== SWIPER POPULAR ===============*/
const swiperPopular = new Swiper('.popular__swiper', {
  loop: true,
  grabCursor:true,
  slidesPerView:'auto',
  centeredSlides:'auto',

})

/*=============== SHOW SCROLL UP ===============*/ 
const scrollUp = () =>{
  const scrollUp = document.getElementById('scroll-up')
  this.scrollY >= 350 ? scrollUp.classList.add('show-scroll')
  :scrollUp.classListr.remove('show-scroll')
}
window.addEventListener('scroll',scrollUp) 
/*const scrollUp = () => {
  const scrollUp = document.getElementById('scroll-up');
  window.scrollY >= 350 
    ? scrollUp.classList.add('show-scroll')
    : scrollUp.classList.remove('show-scroll');
} */
window.addEventListener('scroll', scrollUp);


/*=============== SCROLL SECTIONS ACTIVE LINK ===============*/
window.addEventListener('scroll', scrollUp)

/*=============== SCROLL SECTIONS ACTIVE LINK ===============*/
const sections = document.querySelectorAll('section[id]')

const scrollActive = () => {
  const scrollDown = window.scrollY

  sections.forEach(current => {
    const sectionHeight = current.offsetHeight
    const sectionTop = current.offsetTop - 58
    const sectionId = current.getAttribute('id')
    const sectionsClass = document.querySelector('.nav__menu a[href*=' + sectionId + ']')

    if (scrollDown > sectionTop && scrollDown <= sectionTop + sectionHeight) {
      sectionsClass.classList.add('active-link')
    } else {
      sectionsClass.classList.remove('active-link')
    }
  })
}

window.addEventListener('scroll', scrollActive)


/*=============== SCROLL REVEAL ANIMATION ===============*/
const sr = ScrollReveal({
  origin: 'top',
  distance: '60px',
  duration: 2500,
  delay: 300,
  // reset: true, // animation repeat
});

sr.reveal('.home__data ,.popular__container');
sr.reveal('.home__board' ,{delay:700 , distance:'100px' ,origin:'right'});
sr.reveal('.home__pizza' ,{delay:1400 , distance:'100px' ,origin:'bottom' , rotate:{z:-90}});
sr.reveal('.home__ingredient' ,{delay:2400 , interval:100 });
sr.reveal('.about__data ,.recipe__list ,.contact__data' ,{origin:'right'});
sr.reveal('.about__img ,.recipe__img,.contact__image' ,{origin:'left'});
sr.reveal('.products__card' ,{interval:100});

