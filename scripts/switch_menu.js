let menu_status = "close";

let timeline = gsap.timeline();

function switch_menu() {
  //let ele = document.getElementById("menu_arrow");
  if (menu_status === "close") {
    menu_status = "open";
    timeline
      .to("section > .left", { width: "15%", duration: 1 })
      .to(".items .text", { display: "flex", duration: 0 })
      .to(".items .text", { opacity: 1, duration: 0.5 })
      .to("#menu_arrow", { rotation: 180, duration: 0.5 });
  } else {
    menu_status = "close";
    timeline
      .to(".items .text", { opacity: 0, duration: 1 })
      .to(".items .text", { display: "none", duration: 0 })
      .to("section > .left", { width: "3%", duration: 0.5 })
      .to("#menu_arrow", { rotation: 0, duration: 0.5 });
  }
}

ele1.addEventListener("click", function (e) {
  //main content
  console.log("sup");
  close_profile_pop();
});
ele2[0].addEventListener("click", function (e) {
  //first nav
  console.log("sup1");
  close_profile_pop();
});

function close_profile_pop() {
  gsap
    .timeline()
    .to("#profile_pop_up", { opacity: 0, duration: 0.5 })
    .to("#profile_pop_up", { display: "none", duration: 0 });
}

function open_profile_pop() {
  gsap
    .timeline()
    .to("#profile_pop_up", { display: "flex", duration: 0 })
    .to("#profile_pop_up", { opacity: 1, duration: 0.5 });
}
