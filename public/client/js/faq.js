const btn = document.querySelector(".playButtonDiv")
const video = document.querySelector(".about__video")
const mask = document.querySelector(".videoMask")
btn.addEventListener("click", () => {
  video.play()
  mask.style.display = "none"
})

video.addEventListener("click", () => {
  mask.style.display = "flex"
  video.stop()
})

const faqs = document.querySelectorAll(".faqQuestionDiv")
const answers = document.querySelectorAll(".answer")

faqs.forEach(faq => {
  faq.addEventListener("click", (e) => {
    answers.forEach(answer => {
      if (e.target.nextElementSibling !== answer && answer.classList.contains("active")) {
        answer.classList.remove("active")
      }
    });

    const body = faq.nextElementSibling;
    body.classList.toggle("active");
    faq.classList.toggle("active");
  });
});