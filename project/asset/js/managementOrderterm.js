var content_order1 = document.getElementById("conntent_taborder1");
var content_order2 = document.getElementById("conntent_taborder2");
var content_order3 = document.getElementById("conntent_taborder3");
var content_order4 = document.getElementById("conntent_taborder4");
var active1 = document.getElementById("btn_conntent_taborder1");
var active2 = document.getElementById("btn_conntent_taborder2");
var active3 = document.getElementById("btn_conntent_taborder3");
var active4 = document.getElementById("btn_conntent_taborder4");

var table_ordernew1 = document.getElementById("table_ordernew1");
var table_ordernew2 = document.getElementById("table_ordernew2");
var table_ordernew3 = document.getElementById("table_ordernew3");
var table_ordernew4 = document.getElementById("table_ordernew4");

var form_search = document.getElementById("form_search");


content_order2.style.display = "none";
content_order3.style.display = "none";
content_order4.style.display = "none";
active1.style.cssText = "color:#000; background: #fff;";

active1.addEventListener("click", () => {
  active1.style.cssText = "color:#000; background: #fff;";
  active2.style.cssText = "color:#fff; background: rgb(255 255 255 / 0%);";
  active3.style.cssText = "color:#fff; background: rgb(255 255 255 / 0%);";
  active4.style.cssText = "color:#fff; background: rgb(255 255 255 / 0%);";

  content_order1.style.display = "block";
  content_order2.style.display = "none";
  content_order3.style.display = "none";
  content_order4.style.display = "none";

})

active2.addEventListener("click", () => {
  active2.style.cssText = "color:#000; background: #fff;";
  active1.style.cssText = "color:#fff; background: rgb(255 255 255 / 0%);";
  active3.style.cssText = "color:#fff; background: rgb(255 255 255 / 0%);";
  active4.style.cssText = "color:#fff; background: rgb(255 255 255 / 0%);";

  content_order2.style.display = "block";
  content_order1.style.display = "none";
  content_order3.style.display = "none";
  content_order4.style.display = "none";

})

active3.addEventListener("click", () => {
  active3.style.cssText = "color:#000; background: #fff;";
  active2.style.cssText = "color:#fff; background: rgb(255 255 255 / 0%);";
  active1.style.cssText = "color:#fff; background: rgb(255 255 255 / 0%);";
  active4.style.cssText = "color:#fff; background: rgb(255 255 255 / 0%);";

  content_order3.style.display = "block";
  content_order2.style.display = "none";
  content_order1.style.display = "none";
  content_order4.style.display = "none";

})
active4.addEventListener("click", () => {
  active4.style.cssText = "color:#000; background: #fff;";
  active2.style.cssText = "color:#fff; background: rgb(255 255 255 / 0%);";
  active1.style.cssText = "color:#fff; background: rgb(255 255 255 / 0%);";
  active3.style.cssText = "color:#fff; background: rgb(255 255 255 / 0%);";

  content_order4.style.display = "block";
  content_order2.style.display = "none";
  content_order1.style.display = "none";
  content_order3.style.display = "none";

})