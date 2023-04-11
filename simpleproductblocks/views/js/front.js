document.addEventListener('DOMContentLoaded', (ev) => {
  console.log('simpleproduct')

  $('.products_1').slick({
    infinite: false,
    slidesToShow: 3,
    slidesToScroll: 1,
    vertical: true,
    verticalSwiping: true,
    prevArrow: '<span type="button" class="slick-prev">&#8595;</span>',
    nextArrow: '<span type="button" class="slick-next">&#8593;</span>',
    appendArrows: $('.arrows-container_1'),
    arrows: true,
  })

  $('.products_2').slick({
    infinite: false,
    slidesToShow: 3,
    slidesToScroll: 1,
    vertical: true,
    verticalSwiping: true,
    prevArrow: '<span type="button" class="slick-prev">&#8595;</span>',
    nextArrow: '<span type="button" class="slick-next">&#8593;</span>',
    appendArrows: $('.arrows-container_2'),
    arrows: true,
  })

  $('.products_3').slick({
    infinite: false,
    slidesToShow: 3,
    slidesToScroll: 1,
    vertical: true,
    verticalSwiping: true,
    prevArrow: '<span type="button" class="slick-prev">&#8595;</span>',
    nextArrow: '<span type="button" class="slick-next">&#8593;</span>',
    appendArrows: $('.arrows-container_3'),
    arrows: true,
  })

  // $('[data-item="products_container"]').css('heigth', '420')
})
