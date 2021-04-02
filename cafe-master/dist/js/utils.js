function showNav() {
    const nav = document.querySelector(".nav-links");

    const burger = document.querySelector(".burger");
    nav.classList.toggle("active");
    burger.classList.toggle("burger-active");

}