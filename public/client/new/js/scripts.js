const scrollHeader = document.querySelector(".header__scroll")
const fixedHeader = document.querySelector(".fixedHeader")
const headerInner = document.querySelector(".header__inner")
const mobileHeader = document.querySelector(".mobileHeader")
const hamburger = document.querySelector(".hamburgerMenu")
const mobileHeaderContent = document.querySelector(".mobileHeader__inner")
const body = document.querySelector("body")
const span1s = document.querySelectorAll("#span1")
const span2s = document.querySelectorAll("#span2")
const span3s = document.querySelectorAll("#span3")

if (window.innerWidth > 600) {
    window.addEventListener("scroll", () => {
        if (this.scrollY >= 10) {
            scrollHeader.style.display = "flex"
            headerInner.style.visibility = "hidden"
            fixedHeader.style.display = "flex"
        }
        else {
            scrollHeader.style.display = "none"
            headerInner.style.visibility = "inherit"
            fixedHeader.style.display = "none"
        }
    })
}

hamburger.addEventListener("click", () => {
    mobileHeader.classList.toggle("hidden")
    body.classList.toggle("bodyLock")
    span1s.forEach(span => {
        span.classList.toggle("rotate45deg")
    })
    span3s.forEach(span => {
        span.classList.toggle("rotate-45deg")
    })
    span2s.forEach(span => {
        span.classList.toggle("hidden")
    })
})

window.addEventListener("click", (e) => {
    if (e.target == mobileHeader) {
        mobileHeader.classList.add("hidden")
        body.classList.toggle("bodyLock")
        span1s.forEach(span => {
            span.classList.toggle("rotate45deg")
        })
        span3s.forEach(span => {
            span.classList.toggle("rotate-45deg")
        })
        span2s.forEach(span => {
            span.classList.toggle("hidden")
        })
    }
});

const langChanger = document.querySelector(".header__langChanger")
const langMenu = document.querySelector(".extraNavBoxLang")
const chevronScroll = document.querySelector(".chevronParent")
langChanger.addEventListener("click", () => {
    toggleLangMenu()
    chevronScroll.classList.toggle("rotateChevron")
})

let clicked = false
const toggleLangMenu = () => {
    if (clicked) {
        langMenu.style.display = "none"
        clicked = false
    } else {
        langMenu.style.display = "flex"
        clicked = true
    }
}

const toTopBtn = document.querySelector(".toTopBtn")
toTopBtn.addEventListener("click", () => {
    window.scrollTo({
        top: 0,
        behavior: "smooth"
    })
})

const currentYear = new Date().getFullYear()
const spans = document.querySelectorAll(".currentYearSpan")
spans.forEach(span => {
    span.append(currentYear)
})