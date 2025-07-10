const playBtn = document.querySelector(".playSvg")
const videoModal = document.querySelector(".videoModal")
const video = document.querySelector(".video")
const videoModal__content = document.querySelector(".videoModal__content")

playBtn.addEventListener("click", () => {
  videoModal.style.display = "flex"
})

video.addEventListener("click", () => {
  video.stop()
})

window.addEventListener("click", (e) => {
  if (e.target == videoModal__content) {
    videoModal.style.display = "flex"
  } else if (e.target == videoModal) {
    videoModal.style.display = "none"
    video.pause()
  }
})

const catalogueContainers = document.querySelectorAll(".catalogueToggle")
const buttons = document.querySelectorAll(".tab__btn")
const links = document.querySelectorAll(".centeredDiv")

buttons.forEach((btn, i) => {
  btn.addEventListener("click", () => {
    catalogueContainers.forEach(catalogue => {
      catalogue.classList.remove("active")
    })
    buttons.forEach(btn => {
      btn.classList.remove("active")
    })
    links.forEach(link => {
      link.classList.remove("active")
    })

    catalogueContainers[i].classList.add("active")
    buttons[i].classList.add("active")
    links[i].classList.add("active")
  })
})

const serviceQuestions = document.querySelectorAll(".serviceNameDiv")
const answers = document.querySelectorAll(".serviceTextDiv")

serviceQuestions.forEach((faq) => {
  faq.addEventListener("click", () => {
    const body = faq.nextElementSibling;
    body.classList.toggle("active");
    faq.classList.toggle("active");
  });
});