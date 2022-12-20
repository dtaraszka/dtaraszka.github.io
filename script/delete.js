const btn = document.querySelector('.delete');
const btn2 = document.querySelector('.delete2');
const btn3 = document.querySelector('.delete3');
const div = document.querySelector('.popup');
const blurdiv = document.querySelector(".blur2");
btn.addEventListener("click", function(){
    div.classList.toggle("active");
    blurdiv.classList.toggle("blur");
})
btn2.addEventListener("click", function(){
    div.classList.toggle("active");
    blurdiv.classList.toggle("blur");
})
btn3.addEventListener("click", function(){
    div.classList.toggle("active");
    blurdiv.classList.toggle("blur");
})