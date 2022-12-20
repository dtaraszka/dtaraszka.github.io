const menuacti = document.querySelector('.menu');

const menuAc = ()=>{
    menuacti.classList.toggle("active");
}
menuacti.addEventListener('click', menuAc)