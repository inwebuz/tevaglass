'use strict'

// header
function fixHeader() {
	var header = $('.header__in'),
		scroll = $(window).scrollTop()

	if (scroll >= 500) header.addClass('fixed')
	else header.removeClass('fixed')
}

fixHeader()
$(window).scroll(fixHeader)

// menu
$('.header__btn').click(function (e) {
	e.stopPropagation()
	$('.menu').addClass('open')
})

$('.menu__box').click(function (e) {
	e.stopPropagation()
})

$('.menu__close, html, body').click(function () {
	$('.menu').removeClass('open')
})

// modal
$('.btn--order').click(function (e) {
	e.stopPropagation()
	$('.modal').addClass('open')
})

$('.modal__box').click(function (e) {
	e.stopPropagation()
})

$('.modal__close, html, body').click(function () {
	$('.modal').removeClass('open')
})

// animations
AOS.init({ disable: 'mobile', offset: 300, once: true, duration: 1000 })

// our projects slider
var progressbar = $('.mry-slider-progress-bar')

var swiper = new Swiper('.mry-main-slider', {
	autoplay: {
		delay: 3000,
		disableOnInteraction: false,
	},
	loop: true,
	parallax: true,
	keyboard: true,
	speed: 1200,
	navigation: {
		nextEl: '.mry-button-next',
		prevEl: '.mry-button-prev',
	},
	pagination: {
		el: '.mry-slider-pagination',
		clickable: true,
	},
	on: {
		init: function () {
			progressbar.removeClass('animate')
			progressbar.removeClass('active')
			progressbar.eq(0).addClass('animate')
			progressbar.eq(0).addClass('active')
		},
		slideChangeTransitionStart: function () {
			progressbar.removeClass('animate')
			progressbar.removeClass('active')
			progressbar.eq(0).addClass('active')
		},
		slideChangeTransitionEnd: function () {
			progressbar.eq(0).addClass('animate')
		},
	},
})
