const image = document.querySelector(".mainImage__img")
const service1 = document.querySelector("#service1")
const service2 = document.querySelector("#service2")
const service3 = document.querySelector("#service3")
const service4 = document.querySelector("#service4")
const service5 = document.querySelector("#service5")

window.addEventListener("scroll", () => {
  const scrollNumber = window.pageYOffset;
  if (scrollNumber >= service1.offsetTop - 100) {
    image.setAttribute("src", "./media/serviceImg.png")
  }
  if (scrollNumber >= service2.offsetTop - 100) {
    image.setAttribute("src", "./media/gif.gif")
  }
  if (scrollNumber >= service3.offsetTop - 100) {
    image.setAttribute("src", "./media/howo.png")
  }
  if (scrollNumber >= service4.offsetTop - 100) {
    image.setAttribute("src", "./media/heroBg.png")
  }
  if (scrollNumber >= service5.offsetTop - 100) {
    image.setAttribute("src", "./media/heroTruck.png")
  }
})





