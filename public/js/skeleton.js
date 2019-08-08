jQuery(function ($) {
  $(".sidebar-dropdown > a").click(function() {
  $(".sidebar-submenu").slideUp(200);
  if(
    $(this)
    .parent()
    .hasClass("active")
    ) {
    $(".sidebar-dropdown").removeClass("active");
    $(this)
    .parent()
    .removeClass("active");
    } else {
    $(".sidebar-dropdown").removeClass("active");
    $(this)
    .next(".sidebar-submenu")
    .slideDown(200);
    $(this)
    .parent()
    .addClass("active");
    }
  });

$("#close-sidebar").click(function() {
    $(".page-wrapper").removeClass("toggled");
    });
    $("#show-sidebar").click(function() {
    $(".page-wrapper").addClass("toggled");
    });
});

//js for increment and decrement input

$(document).on('click','.decrement-input',function(){
    input = $(this).parents('.input-group').find('input');
    value = input.val();
    min = input.attr('min');
    if(input.val() == min || input.val() < min + 0.99){
      input.val(min);
      return;
    }
    value--;
    input.val(value);
});
$(document).on('click','.increment-input',function(){
    input = $(this).parents('.input-group').find('input');
    value = input.val();
    value++;
    input.val(value);
});

$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
  e.target // newly activated tab
  e.relatedTarget // previous active tab
})

