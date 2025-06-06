const links = document.querySelectorAll('nav ul li a');

links.forEach((link) => {
  link.addEventListener('click', (e) => {
    e.preventDefault();
    const href = link.getAttribute('href');
    const target = document.querySelector(href);
    target.scrollIntoView({ behavior: 'smooth' });
  });
});