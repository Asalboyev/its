const video = document.querySelector(".video")
const videoDiv = document.querySelector(".productionVideoDiv")
const playBtn = document.querySelector(".playButton")
const videoMask = document.querySelector(".videoMask")

let clicked12 = false
const toggleVideo = () => {
  if (clicked12) {
    videoMask.style.display = "flex"
    clicked12 = false
    video.pause()
  } else {
    videoMask.style.display = "none"
    clicked12 = true
    video.play()
  }
}
videoDiv.addEventListener("click", toggleVideo)