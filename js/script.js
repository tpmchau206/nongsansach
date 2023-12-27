let menu = document.querySelector("#menu-bar");
let navbar = document.querySelector(".navbar");
let header = document.querySelector(".header-2");

menu.addEventListener("click", () => {
  menu.classList.toggle("fa-times");
  navbar.classList.toggle("active");
});

window.onscroll = () => {
  menu.classList.remove("fa-times");
  navbar.classList.remove("active");

  if (window.scrollY > 70) {
    header.classList.add("active");
    document.querySelector('#scroll-top').classList.add('activebtn');

  } else {
    header.classList.remove("active");
    document.querySelector('#scroll-top').classList.remove('activebtn');

  }
};
// // loader
// function loader() {
//   document.querySelector('.loader-container').classList.add('fade-out');
// }
// function fadeOut() {
//   setInterval(loader, 3000);
// }
// window.onload = fadeOut();

