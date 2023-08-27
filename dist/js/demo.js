/* eslint-disable camelcase */
(function ($) {
  "use strict";

  function capitalizeFirstLetter(string) {
    return string.charAt(0).toUpperCase() + string.slice(1);
  }

  var $sidebar = $(".control-sidebar");
  var $container = $("<div />", {
    class: "p-3 control-sidebar-content",
  });

  $sidebar.append($container);

  // Checkboxes

  $container.append('<h5>Personaliza Hernan Store</h5><hr class="mb-2"/>');

  var $dark_mode_checkbox = $("<input />", {
    type: "checkbox",
    value: 1,
    id: "dark",
    checked: $("body").hasClass("dark-mode"),
    class: "mr-1",
  }).on("click", function () {
    if ($(this).is(":checked")) {
      $("body").addClass("dark-mode");
      window.localStorage.setItem("isDarkActive", true);
    } else {
      $("body").removeClass("dark-mode");
      window.localStorage.setItem("isDarkActive", false);
    }
  });
  var $dark_mode_container = $("<div />", { class: "mb-4" })
    .append($dark_mode_checkbox)
    .append('<label for="dark">Modo oscuro</label>');
  $container.append($dark_mode_container);

  $container.append("<h6>Opciones de la cebecera</h6>");
  var $header_fixed_checkbox = $("<input />", {
    type: "checkbox",
    value: 1,
    id: "menuFixed",
    checked: $("body").hasClass("layout-navbar-fixed"),
    class: "mr-1",
  }).on("click", function () {
    if ($(this).is(":checked")) {
      $("body").addClass("layout-navbar-fixed");
      window.localStorage.setItem("menuFixed", true);
    } else {
      $("body").removeClass("layout-navbar-fixed");
      window.localStorage.setItem("menuFixed", false);
    }
  });
  var $header_fixed_container = $("<div />", { class: "mb-1" })
    .append($header_fixed_checkbox)
    .append('<label for="menuFixed">Fijo</label>');
  $container.append($header_fixed_container);

  var $no_border_checkbox = $("<input />", {
    type: "checkbox",
    value: 1,
    id: "menuBorder",
    checked: $(".main-header").hasClass("border-bottom-0"),
    class: "mr-1",
  }).on("click", function () {
    if ($(this).is(":checked")) {
      $(".main-header").addClass("border-bottom-0");
      window.localStorage.setItem("menuBorder", false);
    } else {
      $(".main-header").removeClass("border-bottom-0");
      window.localStorage.setItem("menuBorder", true);
    }
  });
  var $no_border_container = $("<div />", { class: "mb-4" })
    .append($no_border_checkbox)
    .append('<label for="menuBorder">Sin borde</label>');
  $container.append($no_border_container);

  $container.append("<h6>Opciones menú lateral</h6>");

  var $sidebar_collapsed_checkbox = $("<input />", {
    type: "checkbox",
    value: 1,
    id: "onlyIcons",
    checked: $("body").hasClass("sidebar-collapse"),
    class: "mr-1",
  }).on("click", function () {
    if ($(this).is(":checked")) {
      $("body").addClass("sidebar-collapse");
      window.localStorage.setItem("onlyIcons", true);
      $(window).trigger("resize");
    } else {
      $("body").removeClass("sidebar-collapse");
      window.localStorage.setItem("onlyIcons", false);
      $(window).trigger("resize");
    }
  });
  var $sidebar_collapsed_container = $("<div />", { class: "mb-1" })
    .append($sidebar_collapsed_checkbox)
    .append('<label for="onlyIcons">Solo iconos</label>');
  $container.append($sidebar_collapsed_container);

  $(document).on(
    "collapsed.lte.pushmenu",
    '[data-widget="pushmenu"]',
    function () {
      $sidebar_collapsed_checkbox.prop("checked", true);
    }
  );
  $(document).on("shown.lte.pushmenu", '[data-widget="pushmenu"]', function () {
    $sidebar_collapsed_checkbox.prop("checked", false);
  });

  var $sidebar_fixed_checkbox = $("<input />", {
    type: "checkbox",
    value: 1,
    id: "sidebarFixed",
    checked: $("body").hasClass("layout-fixed"),
    class: "mr-1",
  }).on("click", function () {
    if ($(this).is(":checked")) {
      $("body").addClass("layout-fixed");
      window.localStorage.setItem("sidebarFixed", true);
      $(window).trigger("resize");
    } else {
      $("body").removeClass("layout-fixed");
      window.localStorage.setItem("sidebarFixed", false);
      $(window).trigger("resize");
    }
  });
  var $sidebar_fixed_container = $("<div />", { class: "mb-1" })
    .append($sidebar_fixed_checkbox)
    .append('<label for="sidebarFixed">Fijo</label>');
  $container.append($sidebar_fixed_container);

  var $sidebar_mini_checkbox = $("<input />", {
    type: "checkbox",
    value: 1,
    checked: $("body").hasClass("sidebar-mini"),
    class: "mr-1",
  }).on("click", function () {
    if ($(this).is(":checked")) {
      $("body").addClass("sidebar-mini");
    } else {
      $("body").removeClass("sidebar-mini");
    }
  });

  var $flat_sidebar_checkbox = $("<input />", {
    type: "checkbox",
    value: 1,
    id: "navLegacy",
    checked: $(".nav-sidebar").hasClass("nav-flat"),
    class: "mr-1",
  }).on("click", function () {
    if ($(this).is(":checked")) {
      $(".nav-sidebar").addClass("nav-flat");
      window.localStorage.setItem("navLegacy", true);
    } else {
      $(".nav-sidebar").removeClass("nav-flat");
      window.localStorage.setItem("navLegacy", false);
    }
  });
  var $flat_sidebar_container = $("<div />", { class: "mb-1" })
    .append($flat_sidebar_checkbox)
    .append('<label for="navLegacy">Diseño plano</label>');
  $container.append($flat_sidebar_container);

  var $compact_sidebar_checkbox = $("<input />", {
    type: "checkbox",
    value: 1,
    id: "navCompact",
    checked: $(".nav-sidebar").hasClass("nav-compact"),
    class: "mr-1",
  }).on("click", function () {
    if ($(this).is(":checked")) {
      $(".nav-sidebar").addClass("nav-compact");
      window.localStorage.setItem("navCompact", true);
    } else {
      $(".nav-sidebar").removeClass("nav-compact");
      window.localStorage.setItem("navCompact", false);
    }
  });
  var $compact_sidebar_container = $("<div />", { class: "mb-1" })
    .append($compact_sidebar_checkbox)
    .append('<label for="navCompact">Compacto</label>');
  $container.append($compact_sidebar_container);

  var $no_expand_sidebar_checkbox = $("<input />", {
    type: "checkbox",
    value: 1,
    id: "sidebarNoExpand",
    checked: $(".main-sidebar").hasClass("sidebar-no-expand"),
    class: "mr-1",
  }).on("click", function () {
    if ($(this).is(":checked")) {
      $(".main-sidebar").addClass("sidebar-no-expand");
      window.localStorage.setItem("sidebarNoExpand", true);
    } else {
      $(".main-sidebar").removeClass("sidebar-no-expand");
      window.localStorage.setItem("sidebarNoExpand", false);
    }
  });
  var $no_expand_sidebar_container = $("<div />", { class: "mb-4" })
    .append($no_expand_sidebar_checkbox)
    .append(
      '<label for="sidebarNoExpand" class="text-sm">No expandir al pasar el cursor</label>'
    );
  $container.append($no_expand_sidebar_container);

  $container.append("<h6>Disminuir tamaño</h6>");

  var $text_sm_body_checkbox = $("<input />", {
    type: "checkbox",
    value: 1,
    id: "textSmAll",
    checked: $("body").hasClass("text-sm"),
    class: "mr-1",
  }).on("click", function () {
    if ($(this).is(":checked")) {
      $("body").addClass("text-sm");
      window.localStorage.setItem("textSmAll", true);
    } else {
      $("body").removeClass("text-sm");
      window.localStorage.setItem("textSmAll", false);
    }
  });
  var $text_sm_body_container = $("<div />", { class: "mb-1" })
    .append($text_sm_body_checkbox)
    .append('<label for="textSmAll">Todo</label>');
  $container.append($text_sm_body_container);

  var $text_sm_header_checkbox = $("<input />", {
    type: "checkbox",
    value: 1,
    id: "textSmHeader",
    checked: $(".main-header").hasClass("text-sm"),
    class: "mr-1",
  }).on("click", function () {
    if ($(this).is(":checked")) {
      $(".main-header").addClass("text-sm");
      window.localStorage.setItem("textSmHeader", true);
    } else {
      $(".main-header").removeClass("text-sm");
      window.localStorage.setItem("textSmHeader", false);
    }
  });
  var $text_sm_header_container = $("<div />", { class: "mb-1" })
    .append($text_sm_header_checkbox)
    .append('<label for="textSmHeader">Cabecera</label>');
  $container.append($text_sm_header_container);

  var $text_sm_brand_checkbox = $("<input />", {
    type: "checkbox",
    value: 1,
    id: "textSmLogo",
    checked: $(".brand-link").hasClass("text-sm"),
    class: "mr-1",
  }).on("click", function () {
    if ($(this).is(":checked")) {
      $(".brand-link").addClass("text-sm");
      window.localStorage.setItem("textSmLogo", true);
    } else {
      $(".brand-link").removeClass("text-sm");
      window.localStorage.setItem("textSmLogo", false);
    }
  });
  var $text_sm_brand_container = $("<div />", { class: "mb-1" })
    .append($text_sm_brand_checkbox)
    .append('<label for="textSmLogo">Logo</label>');
  $container.append($text_sm_brand_container);

  var $text_sm_sidebar_checkbox = $("<input />", {
    type: "checkbox",
    value: 1,
    id: "textSmSidebar",
    checked: $(".nav-sidebar").hasClass("text-sm"),
    class: "mr-1",
  }).on("click", function () {
    if ($(this).is(":checked")) {
      $(".nav-sidebar").addClass("text-sm");
      window.localStorage.setItem("textSmSidebar", true);
    } else {
      $(".nav-sidebar").removeClass("text-sm");
      window.localStorage.setItem("textSmSidebar", false);
    }
  });
  var $text_sm_sidebar_container = $("<div />", { class: "mb-1" })
    .append($text_sm_sidebar_checkbox)
    .append('<label for="textSmSidebar">Menú lateral</label>');
  $container.append($text_sm_sidebar_container);

  var $text_sm_footer_checkbox = $("<input />", {
    type: "checkbox",
    value: 1,
    id: "textSmFooter",
    checked: $(".main-footer").hasClass("text-sm"),
    class: "mr-1",
  }).on("click", function () {
    if ($(this).is(":checked")) {
      $(".main-footer").addClass("text-sm");
      window.localStorage.setItem("textSmFooter", true);
    } else {
      $(".main-footer").removeClass("text-sm");
      window.localStorage.setItem("textSmFooter", false);
    }
  });
  var $text_sm_footer_container = $("<div />", { class: "mb-4" })
    .append($text_sm_footer_checkbox)
    .append('<label for="textSmFooter">Pie de página</label>');
  $container.append($text_sm_footer_container);
})(jQuery);

window.addEventListener("load", () => {
  const isDarkActiveLocalStorage = localStorage.getItem("isDarkActive");

  if (isDarkActiveLocalStorage === null) {
    const prefersDarkScheme = window.matchMedia(
      "(prefers-color-scheme: dark)"
    ).matches;
    localStorage.setItem("isDarkActive", prefersDarkScheme);
  }

  const options = [
    {
      key: "isDarkActive",
      class: "dark-mode",
      checkboxId: "dark",
      targetElement: document.body,
    },
    {
      key: "menuFixed",
      class: "layout-navbar-fixed",
      checkboxId: "menuFixed",
      targetElement: document.body,
    },
    {
      key: "menuBorder",
      class: "border-bottom-0",
      checkboxId: "menuBorder",
      targetElement: document.querySelector(".main-header"),
    },
    {
      key: "sidebarFixed",
      class: "layout-fixed",
      checkboxId: "sidebarFixed",
      targetElement: document.body,
    },
    {
      key: "onlyIcons",
      class: "sidebar-collapse",
      checkboxId: "onlyIcons",
      targetElement: document.body,
    },
    {
      key: "navLegacy",
      class: "nav-legacy",
      checkboxId: "navLegacy",
      targetElement: document.querySelector(".nav-sidebar"),
    },
    {
      key: "navCompact",
      class: "nav-compact",
      checkboxId: "navCompact",
      targetElement: document.querySelector(".nav-sidebar"),
    },
    {
      key: "sidebarNoExpand",
      class: "sidebar-no-expand",
      checkboxId: "sidebarNoExpand",
      targetElement: document.querySelector(".main-sidebar"),
    },
    {
      key: "textSmAll",
      class: "text-sm",
      checkboxId: "textSmAll",
      targetElement: document.body,
    },
    {
      key: "textSmHeader",
      class: "text-sm",
      checkboxId: "textSmHeader",
      targetElement: document.querySelector(".main-header"),
    },
    {
      key: "textSmLogo",
      class: "text-sm",
      checkboxId: "textSmLogo",
      targetElement: document.querySelector(".main-sidebar > a"),
    },
    {
      key: "textSmSidebar",
      class: "text-sm",
      checkboxId: "textSmSidebar",
      targetElement: document.querySelector(".nav-sidebar.nav "),
    },
    {
      key: "textSmFooter",
      class: "text-sm",
      checkboxId: "textSmFooter",
      targetElement: document.querySelector(".main-footer"),
    },
  ];

  options.forEach((option) => {
    const optionValue = window.localStorage.getItem(option.key);
    const checkboxElement = document.getElementById(option.checkboxId);

    if (optionValue === "true") {
      option.targetElement.classList.add(option.class);
      checkboxElement.checked = true;
    } else {
      option.targetElement.classList.remove(option.class);
      checkboxElement.checked = false;
    }
  });
});
