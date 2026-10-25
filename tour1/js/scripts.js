document.addEventListener('DOMContentLoaded', function () {
    var burger = document.querySelector('.burger');
    var nav = document.getElementById('nav');
    if (burger && nav) {
        burger.addEventListener('click', function () {
            var open = nav.classList.toggle('open');
            burger.setAttribute('aria-expanded', open ? 'true' : 'false');
        });
        nav.querySelectorAll('a').forEach(function (a) {
            a.addEventListener('click', function () {
                nav.classList.remove('open');
                burger.setAttribute('aria-expanded', 'false');
            });
        });
    }

    var top = document.querySelector('.top');
    if (top) {
        var onScroll = function () {
            if (window.scrollY > 8) top.classList.add('scrolled');
            else top.classList.remove('scrolled');
        };
        window.addEventListener('scroll', onScroll, { passive: true });
        onScroll();
    }

    if (!window.matchMedia('(prefers-reduced-motion: reduce)').matches && 'IntersectionObserver' in window) {
        var els = document.querySelectorAll('.js .search, .js .dest, .js .sec-head, .js .panel, .js .hot, .js .foot__grid');
        var io = new IntersectionObserver(function (entries) {
            entries.forEach(function (e) {
                if (e.isIntersecting) { e.target.classList.add('in'); io.unobserve(e.target); }
            });
        }, { threshold: 0.12, rootMargin: '0px 0px -40px 0px' });
        els.forEach(function (el) { io.observe(el); });
    } else {
        document.querySelectorAll('.js .search, .js .dest, .js .sec-head, .js .panel, .js .hot, .js .foot__grid').forEach(function (el) { el.classList.add('in'); });
    }

    var price = document.getElementById('price');
    var priceValue = document.getElementById('priceValue');
    if (price && priceValue) {
        var update = function () { priceValue.textContent = price.value; };
        price.addEventListener('input', update);
        update();
    }
});