document.addEventListener("DOMContentLoaded", () => {
  let burger = document.querySelector(".header__menu-burger-btn");
  const menu = document.querySelector(".burger-menu-nav");
console.log(burger,menu);
  burger.addEventListener("click", function (e) {
    menu.classList.toggle("active");
    burger.classList.toggle("active");
  });
 
});
