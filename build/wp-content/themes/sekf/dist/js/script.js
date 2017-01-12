/*jslint browser: true*/
/*global $, jQuery, Modernizr, enquire, audiojs*/

(function($) {
  // Pagination Ajax.
  var pagination_ajax = function () {
    var parent_views = $(this).parents('.views');
    var name = parent_views.find('input[name="name"]').val();
    var post_type = parent_views.find('input[name="post_type"]').val();
    var per_page = parent_views.find('input[name="per_page"]').val();
    var cat_id = parent_views.find('input[name="cat_id"]').val();
    var custom_fields = parent_views.find('input[name="custom_fields"]').val();
    var use_pagination = parent_views.find('input[name="use_pagination"]').val();
    var paged_index = $(this).parent('li').attr('data-value');
    //alert(name);
    $(this).parents('ul.pager').find('> li').removeClass('current');
    $(this).parent('li').addClass('current');

    $.ajax({
      type : "post",
      dataType : "json",
      url : paginationAjax.ajaxurl,
      data : {action: "pagination", name: name, post_type: post_type, per_page: per_page, cat_id: cat_id, custom_fields: custom_fields, paged_index: paged_index, use_pagination: '' },
      beforeSend: function() {
        //parent_views.find('.load-views').empty();
        parent_views.find('.tool-pagination.ajax-pagination').before('<div class="ajax-load-icon">load items</div>');
      },
      success: function(response) {
        parent_views.find('.ajax_views').fadeOut("normal", function() {
          $(this).remove();
        });
        parent_views.find('.load-views').fadeOut("normal", function() {
          $(this).remove();
        });
        parent_views.find('.ajax-load-icon').fadeOut("normal", function() {
          $(this).remove();
        });
        parent_views.find('.tool-pagination.ajax-pagination').before('<div class="load-views"></div>');
        parent_views.find('.load-views').fadeIn("normal", function() {
          $(this).html(response.markup);
        });
        $("select").chosen();
        popupDownload();
      },
      error: function(response) {

      }
    });

    return false;

  };

  $(document).ready(function() {
    $('.ajax-pagination .pager-item a').on('click', pagination_ajax);
    $('.box-slide').slick({
      autoplay: false,
      autoplaySpeed: 2000,
      dots: true,
      arrows : false,
      pauseOnHover: false,
    });
    $('.box-partners__list').slick({
      autoplay: true,
      autoplaySpeed: 2000,
      dots: false,
      arrows : false,
      pauseOnHover: true,
      slidesToShow: 4,
      slidesToScroll: 1,
      responsive: [
      {
        breakpoint: 1024,
        settings: {
          slidesToShow: 3,
          slidesToScroll: 1,
          infinite: true,
          dots: false
        }
      },
      {
        breakpoint: 600,
        settings: {
          slidesToShow: 3,
          slidesToScroll: 1
        }
      },
      {
        breakpoint: 480,
        settings: {
          slidesToShow: 2,
          slidesToScroll: 1
        }
      }]
    });

    $('.box-testimonial__list').slick({
      autoplay: false,
      autoplaySpeed: 2000,
      dots: false,
      arrows : true,
      pauseOnHover: true,
      slidesToShow: 3,
      slidesToScroll: 1,
      responsive: [
      {
        breakpoint: 1024,
        settings: {
          slidesToShow: 2,
          slidesToScroll: 1,
          infinite: true,
          dots: false
        }
      },
      {
        breakpoint: 600,
        settings: {
          slidesToShow: 2,
          slidesToScroll: 1
        }
      },
      {
        breakpoint: 480,
        settings: {
          slidesToShow: 1,
          slidesToScroll: 1
        }
      }]
    });

     $('.header__top .js-toggle').on('click', function(e) {
      $('.form-search').toggleClass("active");
      e.preventDefault();
    });



     $(window).load(function(){
      var $postlistmasonry = $('.js-masonry-teaser');
      $postlistmasonry.masonry({
          itemSelector: '.teaser-list__item'
      });
     });

  });

  $('.box-testimonial__quote').matchHeight();
  $('.box-member__item').matchHeight();
  $('.js-matchHeight').matchHeight();


  $('.toggle-nav').click(function(e) {
      $(this).toggleClass('active');
      $('.toggle-nav-mainmenu').toggleClass('active');
      e.preventDefault();
  });

  function myFunction() {
    $(".dataTables_wrapper .dataTables_filter input").attr('placeholder','search for a member' );
  }

  $(window).load(function() {
    // Call to function
     myFunction();
  });

  $(window).resize(function() {
    // Call to function
  });
})(jQuery);
