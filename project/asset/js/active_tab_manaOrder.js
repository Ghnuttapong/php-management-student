var content_order1 = document.getElementById("conntent_taborder1");
var content_order2 = document.getElementById("conntent_taborder2");
var active1 = document.getElementById("btn_conntent_taborder1");
var active2 = document.getElementById("btn_conntent_taborder2");

var table_ordernew1 = document.getElementById("table_ordernew1");
var table_ordernew2 = document.getElementById("table_ordernew2");

// var form_search = document.getElementById("form_search");


content_order2.style.display = "none";
active1.style.cssText = "color:#000; background: #fff;";

active1.addEventListener("click", () => {
  active1.style.cssText = "color:#000; background: #fff;";
  active2.style.cssText = "color:#fff; background: rgb(255 255 255 / 0%);";
  content_order1.style.display = "block";
  content_order2.style.display = "none";
})

active2.addEventListener("click", () => {
  active2.style.cssText = "color:#000; background: #fff;";
  active1.style.cssText = "color:#fff; background: rgb(255 255 255 / 0%);";
  content_order2.style.display = "block";
  content_order1.style.display = "none";
})

