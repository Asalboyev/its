const tabSections = document.querySelectorAll(".tabSection")
const buttons = document.querySelectorAll(".button")

buttons.forEach((btn, i) => {
    btn.addEventListener("click", () => {
        tabSections.forEach(section => {
            section.classList.remove("active")
        })
        buttons.forEach(btn => {
            btn.classList.remove("active")
        })

        tabSections[i].classList.add("active")
        buttons[i].classList.add("active")
    })
})

const btns = document.querySelectorAll(".isothermic__link")
const modal = document.querySelector(".modal")
const modalContent = document.querySelector(".modal__inner")
const xBtn = document.querySelector(".xBtn")

btns.forEach(btn => {
    btn.addEventListener("click", () => {
        modal.style.display = "flex"
    })
})

xBtn.addEventListener("click", () => {
    modal.style.display = "none"
})

if (window.innerWidth > 600) {
    window.addEventListener("click", (e) => {
        if (e.target == modal) {
            modal.style.display = "none"
        } else if (e.target == xBtn) {
            modal.style.display = "none"
        } else if (e.target == modalContent) {
            modal.style.display = "flex"
        }
    })
}
