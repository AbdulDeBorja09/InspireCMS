function changeImage(element) {
  let mainImage = document.getElementById("mainImage");
  mainImage.style.opacity = "0";
  setTimeout(() => {
    mainImage.src = element.src;
    mainImage.style.opacity = "1";
  }, 300);
}
