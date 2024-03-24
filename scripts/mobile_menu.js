function showMenu(menu_item_id) {
  console.log("test");
  if (window.innerWidth <= 750) {
    gsap
      .timeline()
      .to(`#${menu_item_id} .text`, { display: "unset", duration: 0 })
      .to(`#${menu_item_id} .text`, { opacity: 1, duration: 1 });
  }
}
