/**
 * AdminLTE Demo Menu
 * ------------------
 * You should not use this file in production.
 * This file is for demo purposes only.
 */

/* eslint-disable camelcase */

(function ($) {
  'use strict'

  setTimeout(function () {
    if (window.___browserSync___ === undefined && Number(localStorage.getItem('AdminLTE:Demo:MessageShowed')) < Date.now()) {
      localStorage.setItem('AdminLTE:Demo:MessageShowed', (Date.now()) + (15 * 60 * 1000))
      // eslint-disable-next-line no-alert
      // alert('You load AdminLTE\'s "demo.js", \nthis file is only created for testing purposes!')
    }
  }, 1000)

  function capitalizeFirstLetter(string) {
    return string.charAt(0).toUpperCase() + string.slice(1)
  }

  function createSkinBlock(colors, callback, noneSelected) {
    var $block = $('<select />', {
      class: noneSelected ? 'custom-select mb-3 border-0' : 'custom-select mb-3 text-light border-0 ' + colors[0].replace(/accent-|navbar-/, 'bg-')
    })

    if (noneSelected) {
      var $default = $('<option />', {
        text: 'None Selected'
      })

      $block.append($default)
    }

    colors.forEach(function (color) {
      var $color = $('<option />', {
        class: (typeof color === 'object' ? color.join(' ') : color).replace('navbar-', 'bg-').replace('accent-', 'bg-'),
        text: capitalizeFirstLetter((typeof color === 'object' ? color.join(' ') : color).replace(/navbar-|accent-|bg-/, '').replace('-', ' '))
      })

      $block.append($color)
    })
    if (callback) {
      $block.on('change', callback)
    }

    return $block
  }

  var $sidebar = $('.control-sidebar')
  var $container = $('<div />', {
    class: 'p-3 control-sidebar-content'
  })

  $sidebar.append($container)

  // Checkboxes

  $container.append(
    '<h5>Customize AdminLTE</h5><hr class="mb-2"/>'
  )

  var $dark_mode_checkbox = $('<input />', {
    type: 'checkbox',
    value: 1,
    checked: $('body').hasClass('dark-mode'),
    class: 'mr-1'
  }).on('click', function () {
    if ($(this).is(':checked')) {
      $('body').addClass('dark-mode')
    } else {
      $('body').removeClass('dark-mode')
    }
  })
  var $dark_mode_container = $('<div />', { class: 'mb-4' }).append($dark_mode_checkbox).append('<span>Modo oscuro</span>')
  $container.append($dark_mode_container)

  $container.append('<h6>Opciones de la cebecera</h6>')
  var $header_fixed_checkbox = $('<input />', {
    type: 'checkbox',
    value: 1,
    checked: $('body').hasClass('layout-navbar-fixed'),
    class: 'mr-1'
  }).on('click', function () {
    if ($(this).is(':checked')) {
      $('body').addClass('layout-navbar-fixed')
    } else {
      $('body').removeClass('layout-navbar-fixed')
    }
  })
  var $header_fixed_container = $('<div />', { class: 'mb-1' }).append($header_fixed_checkbox).append('<span>Fijo</span>')
  $container.append($header_fixed_container)


  var $no_border_checkbox = $('<input />', {
    type: 'checkbox',
    value: 1,
    checked: $('.main-header').hasClass('border-bottom-0'),
    class: 'mr-1'
  }).on('click', function () {
    if ($(this).is(':checked')) {
      $('.main-header').addClass('border-bottom-0')
    } else {
      $('.main-header').removeClass('border-bottom-0')
    }
  })
  var $no_border_container = $('<div />', { class: 'mb-4' }).append($no_border_checkbox).append('<span>Sin borde</span>')
  $container.append($no_border_container)

  $container.append('<h6>Opciones menú lateral</h6>')

  var $sidebar_collapsed_checkbox = $('<input />', {
    type: 'checkbox',
    value: 1,
    checked: $('body').hasClass('sidebar-collapse'),
    class: 'mr-1'
  }).on('click', function () {
    if ($(this).is(':checked')) {
      $('body').addClass('sidebar-collapse')
      $(window).trigger('resize')
    } else {
      $('body').removeClass('sidebar-collapse')
      $(window).trigger('resize')
    }
  })
  var $sidebar_collapsed_container = $('<div />', { class: 'mb-1' }).append($sidebar_collapsed_checkbox).append('<span>Solo iconos</span>')
  $container.append($sidebar_collapsed_container)

  $(document).on('collapsed.lte.pushmenu', '[data-widget="pushmenu"]', function () {
    $sidebar_collapsed_checkbox.prop('checked', true)
  })
  $(document).on('shown.lte.pushmenu', '[data-widget="pushmenu"]', function () {
    $sidebar_collapsed_checkbox.prop('checked', false)
  })

  var $sidebar_fixed_checkbox = $('<input />', {
    type: 'checkbox',
    value: 1,
    checked: $('body').hasClass('layout-fixed'),
    class: 'mr-1'
  }).on('click', function () {
    if ($(this).is(':checked')) {
      $('body').addClass('layout-fixed')
      $(window).trigger('resize')
    } else {
      $('body').removeClass('layout-fixed')
      $(window).trigger('resize')
    }
  })
  var $sidebar_fixed_container = $('<div />', { class: 'mb-1' }).append($sidebar_fixed_checkbox).append('<span>Fijo</span>')
  $container.append($sidebar_fixed_container)

  var $sidebar_mini_checkbox = $('<input />', {
    type: 'checkbox',
    value: 1,
    checked: $('body').hasClass('sidebar-mini'),
    class: 'mr-1'
  }).on('click', function () {
    if ($(this).is(':checked')) {
      $('body').addClass('sidebar-mini')
    } else {
      $('body').removeClass('sidebar-mini')
    }
  })
  

  var $flat_sidebar_checkbox = $('<input />', {
    type: 'checkbox',
    value: 1,
    checked: $('.nav-sidebar').hasClass('nav-flat'),
    class: 'mr-1'
  }).on('click', function () {
    if ($(this).is(':checked')) {
      $('.nav-sidebar').addClass('nav-flat')
    } else {
      $('.nav-sidebar').removeClass('nav-flat')
    }
  })
  var $flat_sidebar_container = $('<div />', { class: 'mb-1' }).append($flat_sidebar_checkbox).append('<span>Diseño plano</span>')
  $container.append($flat_sidebar_container)


  var $compact_sidebar_checkbox = $('<input />', {
    type: 'checkbox',
    value: 1,
    checked: $('.nav-sidebar').hasClass('nav-compact'),
    class: 'mr-1'
  }).on('click', function () {
    if ($(this).is(':checked')) {
      $('.nav-sidebar').addClass('nav-compact')
    } else {
      $('.nav-sidebar').removeClass('nav-compact')
    }
  })
  var $compact_sidebar_container = $('<div />', { class: 'mb-1' }).append($compact_sidebar_checkbox).append('<span>Compacto</span>')
  $container.append($compact_sidebar_container)


  var $no_expand_sidebar_checkbox = $('<input />', {
    type: 'checkbox',
    value: 1,
    checked: $('.main-sidebar').hasClass('sidebar-no-expand'),
    class: 'mr-1'
  }).on('click', function () {
    if ($(this).is(':checked')) {
      $('.main-sidebar').addClass('sidebar-no-expand')
    } else {
      $('.main-sidebar').removeClass('sidebar-no-expand')
    }
  })
  var $no_expand_sidebar_container = $('<div />', { class: 'mb-4' }).append($no_expand_sidebar_checkbox).append('<span>No expandir al pasar el cursor</span>')
  $container.append($no_expand_sidebar_container)

  $container.append('<h6>Opciones pie de página</h6>')
  var $footer_fixed_checkbox = $('<input />', {
    type: 'checkbox',
    value: 1,
    checked: $('body').hasClass('layout-footer-fixed'),
    class: 'mr-1'
  }).on('click', function () {
    if ($(this).is(':checked')) {
      $('body').addClass('layout-footer-fixed')
    } else {
      $('body').removeClass('layout-footer-fixed')
    }
  })
  var $footer_fixed_container = $('<div />', { class: 'mb-4' }).append($footer_fixed_checkbox).append('<span>Fijo</span>')
  $container.append($footer_fixed_container)

  $container.append('<h6>Disminuir tamaño</h6>')

  var $text_sm_body_checkbox = $('<input />', {
    type: 'checkbox',
    value: 1,
    checked: $('body').hasClass('text-sm'),
    class: 'mr-1'
  }).on('click', function () {
    if ($(this).is(':checked')) {
      $('body').addClass('text-sm')
    } else {
      $('body').removeClass('text-sm')
    }
  })
  var $text_sm_body_container = $('<div />', { class: 'mb-1' }).append($text_sm_body_checkbox).append('<span>Todo</span>')
  $container.append($text_sm_body_container)

  var $text_sm_header_checkbox = $('<input />', {
    type: 'checkbox',
    value: 1,
    checked: $('.main-header').hasClass('text-sm'),
    class: 'mr-1'
  }).on('click', function () {
    if ($(this).is(':checked')) {
      $('.main-header').addClass('text-sm')
    } else {
      $('.main-header').removeClass('text-sm')
    }
  })
  var $text_sm_header_container = $('<div />', { class: 'mb-1' }).append($text_sm_header_checkbox).append('<span>Cabecera</span>')
  $container.append($text_sm_header_container)

  var $text_sm_brand_checkbox = $('<input />', {
    type: 'checkbox',
    value: 1,
    checked: $('.brand-link').hasClass('text-sm'),
    class: 'mr-1'
  }).on('click', function () {
    if ($(this).is(':checked')) {
      $('.brand-link').addClass('text-sm')
    } else {
      $('.brand-link').removeClass('text-sm')
    }
  })
  var $text_sm_brand_container = $('<div />', { class: 'mb-1' }).append($text_sm_brand_checkbox).append('<span>Logo</span>')
  $container.append($text_sm_brand_container)

  var $text_sm_sidebar_checkbox = $('<input />', {
    type: 'checkbox',
    value: 1,
    checked: $('.nav-sidebar').hasClass('text-sm'),
    class: 'mr-1'
  }).on('click', function () {
    if ($(this).is(':checked')) {
      $('.nav-sidebar').addClass('text-sm')
    } else {
      $('.nav-sidebar').removeClass('text-sm')
    }
  })
  var $text_sm_sidebar_container = $('<div />', { class: 'mb-1' }).append($text_sm_sidebar_checkbox).append('<span>Menú lateral</span>')
  $container.append($text_sm_sidebar_container)

  var $text_sm_footer_checkbox = $('<input />', {
    type: 'checkbox',
    value: 1,
    checked: $('.main-footer').hasClass('text-sm'),
    class: 'mr-1'
  }).on('click', function () {
    if ($(this).is(':checked')) {
      $('.main-footer').addClass('text-sm')
    } else {
      $('.main-footer').removeClass('text-sm')
    }
  })
  var $text_sm_footer_container = $('<div />', { class: 'mb-4' }).append($text_sm_footer_checkbox).append('<span>Pie de página</span>')
  $container.append($text_sm_footer_container)

})(jQuery)
