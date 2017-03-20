(function($) {
  function IconsSelect() {
    //alert('ok select');
    //$('.acf-field[data-name*="box_icon_select"] .acf-input > select').append()
    $('.input-alt').click(function(){
      alert('ok');
    });

    /*$('[data-layout*=group_field_category_events]').each(function() {
      var date_start = $(this).find('.acf-field-date-time-picker[data-name*=datum] .input-alt');
      var date_end = $(this).find('.acf-field-date-time-picker[data-name*=end_datum] .input');
      date_start.click(function() {
        var value_start = $(this).val();
        console.log(value_start);
        alert('ok');
      });
    });*/
  }

  $(document).ready(function() {
    // Call to function
    //IconsSelect();

    // acf.add_action('append', function( $el ){

    //   // $el will be equivalent to the new element being appended $('tr.row')


    //   // find a specific field
    //   var $field = $el.find('#acf-group_584772db7c653');

    //   alert('ok');
    // });

  });

  $(window).load(function() {
    // Call to function
  });

  $(window).resize(function() {
    // Call to function
  });
})(jQuery);
