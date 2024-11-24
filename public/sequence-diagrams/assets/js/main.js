const contentMenuToggle = document.getElementById('content__menu-toggle')
const wrapper = document.getElementById('wrapper')
const closed = document.querySelector('.closed')

contentMenuToggle.addEventListener('click', function(e) {
  e.preventDefault();
  wrapper.classList.toggle('toggled');
  closed.classList.toggle('closed')
})
  