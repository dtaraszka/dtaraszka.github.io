const switchLabel = document.querySelector('.wrap-motyw__label');
const switchCbox = document.querySelector('.cbox');
const activeMotyw = localStorage.getItem('aMotyw');

if (activeMotyw) {

  document.documentElement.setAttribute('motyw', activeMotyw);

  if (activeMotyw == 'dark') {
    switchLabel.checked = true;
    switchCbox.checked =true;
  }
}
function changeMotyw(e) {
  if (e.target.checked) {
    document.documentElement.setAttribute('motyw', 'dark');
    localStorage.setItem('aMotyw', 'dark');
  }
  else {
    document.documentElement.setAttribute('motyw', 'normal');
    localStorage.setItem('aMotyw', 'normal');
  }
}

switchLabel.addEventListener('click', changeMotyw);
switchCbox.addEventListener('click', changeMotyw);