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