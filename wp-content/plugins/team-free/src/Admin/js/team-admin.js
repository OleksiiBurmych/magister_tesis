jQuery(document).ready(function ($) {
  $(".sptp-generator-tabs .spf-wrapper").css("visibility", "hidden");

  $('.sptp_filter_members').find("option:nth-of-type(2), option:nth-of-type(3), option:nth-of-type(4)").attr('disabled', 'disabled');
  $('.sptp_image_grayscale').find("option:nth-of-type(2), option:nth-of-type(3), option:nth-of-type(4)").attr('disabled', 'disabled');
  $('.spf-field-select.sptp_image_size').find("option:last-child").attr('disabled', 'disabled');
  $('.spf--typography').find('.spf--font-family, .spf--font-style-select, .spf--font-size, .spf--line-height, .spf--text-align, .spf--text-transform, .spf--letter-spacing, .spf--margin-top, .spf--margin-bottom').attr('disabled', 'disabled');
  $('.sptp_typography_pro').css('pointer-events', 'none');
  $('.spf--block-preview').css('cursor', 'auto');
  $('.spf--block-preview .spf--toggle').hide();
  $('.spf--block-preview').css('pointer-events', 'none');

  var select_value_layout = $(
    ".sptp-layout-preset .spf--sibling.spf--image.spf--active"
  )
    .find("input")
    .val();
  if (select_value_layout === "carousel") {
    $(".spf-nav-metabox li.spf-menu-item-carousel-controls").show();
  } else {
    $(".spf-nav-metabox li.spf-menu-item-carousel-controls").hide();
  }

  // if (select_value_layout == "list") {
  //   $('.member_content_position').addClass('hidden');
  //   $('.responsive_columns').hide();
  //   $('.responsive_columns_list').show();
  // } else {
  //   $('.member_content_position_list').addClass('hidden');
  //   $('.responsive_columns').show();
  //   $('.responsive_columns_list').hide();
  // }

  // var withoutPaginationLayout = ['carousel'];

  // if (withoutPaginationLayout.indexOf(select_value_layout) !== -1) {
  //   $(".sptp-pagination-group").addClass("hidden");
  // } else {
  //   $('.sptp-pagination-group').removeClass('hidden');
  // }

  $(document).on(
    "click",
    ".sptp-layout-preset .spf--sibling.spf--image",
    function (event) {
      event.stopPropagation();
      var select_value = $(this)
        .find("input")
        .val();

      if (select_value !== "carousel") {
        $(".spf-nav-metabox li.spf-menu-item-carousel-controls").hide();
        $(".spf-nav-metabox li.spf-menu-item-general-settings a").click();
      } else {
        $(".spf-nav-metabox li.spf-menu-item-carousel-controls").show();
      }

  //     if (withoutPaginationLayout.indexOf(select_value) !== -1) {
  //       $(".sptp-pagination-group").addClass("hidden");
  //     } else {
  //       $('.sptp-pagination-group').removeClass('hidden');
  //     }

  //     if (select_value == "list") {
  //       $('.member_content_position_list').removeClass('hidden');
  //       $('.member_content_position').addClass('hidden');
  //       $('.responsive_columns').hide();
  //       $('.responsive_columns_list').show();
  //     } else {
  //       $('.member_content_position_list').addClass('hidden');
  //       $('.member_content_position').removeClass('hidden');
  //       $('.responsive_columns_list').hide();
  //       $('.responsive_columns').show();
  //     }
    }
  );

  $(".sptp-generator-tabs .spf-wrapper").css("visibility", "visible");
  $(".sptp-generator-tabs .spf-wrapper li").css("opacity", 1);

  $(document).on("click", "#copy-shortcode, #copy-tag", function () {
    var $temp = $("<input>");
    $("body").append($temp);
    $temp
      .val(
        $(this)
          .parent()
          .find("input")
          .val()
      )
      .select();
    document.execCommand("copy");
    $(this).append('<span class="copy-alert">copied</span>');
    setTimeout(function () {
      $(".copy-alert")
        .fadeOut()
        .empty();
    }, 1000);
    $temp.remove();
  });

  // $("._sptp_output input[type='text']").click(function () {
  //   $(this).select();
  // });
  $('.sptp-shortcode-selectable, .post-type-sptp_generator .column-shortcode input').click(function (e) {
    e.preventDefault();
    /* Get the text field */
    var copyText = $(this);
    /* Select the text field */
    copyText.select();
    document.execCommand("copy");
    jQuery(".sptp-after-copy-text").animate({
      opacity: 1,
      bottom: 25
    }, 300);
    setTimeout(function () {
      jQuery(".sptp-after-copy-text").animate({
        opacity: 0,
      }, 200);
      jQuery(".sptp-after-copy-text").animate({
        bottom: 0
      }, 0);
    }, 2000);
  });
});
