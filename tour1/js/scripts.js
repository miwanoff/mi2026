document.addEventListener('DOMContentLoaded', function () {
    var burger = document.querySelector('.burger');
    var nav = document.getElementById('nav');
    if (burger && nav) {
        burger.addEventListener('click', function () {
            var open = nav.classList.toggle('open');
            burger.setAttribute('aria-expanded', open ? 'true' : 'false');
        });
    }
    var price = document.getElementById('price');
    var priceValue = document.getElementById('priceValue');
    if (price && priceValue) {
        var update = function () { priceValue.textContent = price.value; };
        price.addEventListener('input', update);
        update();
    }
});