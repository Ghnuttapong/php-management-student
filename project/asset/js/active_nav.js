// var click = document.getElementById("nav-item-end").addEventListener("click", displayActive);
var nav_page = document.getElementById("nav_page").value;

displayActiveNav(nav_page);

function displayActiveNav(page) {

  if (page == 1) {
    var active = document.querySelector("#nav-link1");
    active.classList.add("active");
  } else if (page == 2) {
    var active = document.querySelector("#nav-link2");
    active.classList.add("active");
  } else if (page == 3) {
    var active = document.querySelector("#nav-link3");
    active.classList.add("active");
  } else if (page == 4) {
    var active = document.querySelector("#nav-link4");
    active.classList.add("active");
  } else if (page == 5) {
    var active = document.querySelector("#nav-link5");
    active.classList.add("active");
  } else if (page == 6) {
    var active = document.querySelector("#nav-link6");
    active.classList.add("active");
  } else if (page == 7) {
    var active = document.querySelector("#nav-link7");
    active.classList.add("active");
  } else if (page == 8) {
    var active = document.querySelector("#nav-link8");
    active.classList.add("active");
  } else if (page == 9) {
    var active = document.querySelector("#nav-link9");
    active.classList.add("active");
  } else if (page == 10) {
    var active = document.querySelector("#nav-link10");
    active.classList.add("active");
  }

};


