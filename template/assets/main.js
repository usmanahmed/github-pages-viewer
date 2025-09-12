$(document).ready(function () {
  // Variables
  var $title = $("title");
  var $search_form = $("form#search");
  var $side_links_ul = $("#side-list");
  var $nav_links = $("header a");
  var $main = $("#content");
  var $aside = $("aside");

  // Main Nav AJAX Loader
  $nav_links.on("click", function (e) {
    if (!e.ctrlKey) {
      e.preventDefault();

      $search_form.find("input").val("");
      $nav_links.removeClass("active");
      $(this).addClass("active");

      var stateObj = { foo: $(this).text() };
      history.replaceState(stateObj, $(this).text(), $(this).attr("href"));

      var page_id = $(this).data("id");

      var page_data = JSON.parse(localStorage.getItem('page_' + page_id));

      if (page_data != null) {
        
        loadPageData(page_data);
        
      } else {
        var permalink = $(this).attr("href");
  
        $.ajax({
          url: permalink + "?json=true",
          type: "get",
          dataType: "json",
          cache: true,
          async: false,
          success: function (response) {
            if (response.success) {
              loadPageData(response.data);
            }
          },
        });
      }

    }
  });


  // handle links with @href started with '#' only
  $main.on("click", 'a[href^="#"]', function (e) {
    // target element id
    var id = $(this).attr("href");

    // target element
    var $id = $(id);
    if ($id.length === 0) {
      return;
    }

    e.preventDefault();

    // top position relative to the document
    var pos = $id.offset().top - 80;

    // animated top scrolling
    $("body, html").animate({ scrollTop: pos });
  });


  // Creating Table of content (TOC)
  function loadPageData(data) {
    $title.html(data.main.heading + " &#8211; " + site_name);
    
    var main_content =
      data.main.breadcrumbs +
      "<h1>" +
      data.main.heading;
    if (data.main.ID) {
      main_content =
        main_content +
        ' <a class="edit" href="/wp-admin/post.php?post=' +
        data.main.ID +
        '&action=edit">&#9998;</a>';
    }
    main_content =
      main_content +
      '</h1><div id="the-content">' +
      data.main.content +
      "</div>";
    $main.html(main_content);

    $('a[href^="https://"]')
      .not("a[href*=devdocs]")
      .attr("target", "_blank");

    if ($("code").length) {
      Prism.highlightAll("code");
    }

    $aside.find("#side-list").html(data.aside);

    scrollLink = $("a[href*=\\#]");

    createTOC();
  }


  // Creating Table of content (TOC)
  function createTOC() {
    sec_h3 = $("h3[id]");

    if (sec_h3.length) {
      var toc = '<ul class="page-toc">';
      $.each(sec_h3, function (i, obj) {
        obj = $(obj);
        toc += '<a href="#' + obj.attr("id") + '">' + obj.text() + "</a>";
      });
      toc += "</ul>";
      $main.prepend(toc);
    }
  }
  createTOC();

  // Embed SVGs
  embedSVGs();
  function embedSVGs() {
    var svgs = jQuery('img[src*=".svg"].embed');
    jQuery(svgs).each(function () {
      var $img = jQuery(this);
      var imgID = $img.attr("id");
      var imgClass = $img.attr("class");
      var imgURL = $img.attr("src");

      jQuery.get(
        imgURL,
        function (data) {
          // Get the SVG tag, ignore the rest
          var $svg = jQuery(data).find("svg");

          // Add replaced image's ID to the new SVG
          if (typeof imgID !== "undefined") {
            $svg = $svg.attr("id", imgID);
          }
          // Add replaced image's classes to the new SVG
          if (typeof imgClass !== "undefined") {
            $svg = $svg.attr("class", imgClass + " replaced-svg");
          }

          // Remove any invalid XML tags as per http://validator.w3.org
          $svg = $svg.removeAttr("xmlns:a");

          // Replace image with new SVG
          $img.replaceWith($svg);
        },
        "xml"
      );
    });
  }

  // Sidebar Nav AJAX Loader
  $side_links_ul.on("click", ".page-link", function (e) {
    if (!e.ctrlKey) {
      e.preventDefault();
      $search_form.find("input").val("");
      $side_links_ul.find(".page-link").removeClass("active");
      $(this).addClass("active");

      var stateObj = { foo: $(this).text() };
      var page_id = $(this).data("id");
      history.replaceState(stateObj, $(this).text(), $(this).attr("href"));

      var page_data = JSON.parse(localStorage.getItem('page_' + page_id));
      if (page_data != null) {
        $main.html(page_data);
      } else {
        var permalink = $(this).attr("href");
        $.ajax({
          url: permalink + "?json=true",
          type: "get",
          dataType: "json",
          cache: true,
          async: false,
          success: function (response) {
            if (response.success) {
              $main.html(response.data);
            }
          },
        });
      }

      $('a[href^="https://"]')
      .not("a[href*=devdocs]")
      .attr("target", "_blank");

      scrollLink = $("a[href*=\\#]");
      createTOC();
      Prism.highlightAll();

    }
  });

  $("#container aside #side-list").on("click", "ul.level-1 > li", function (e) {
    $("#container aside #side-list > ul > li")
      .children("ul.level-2")
      .css("height", "0");
    $(this).children("ul").css("height", "auto");
  });

  $("#container aside #side-list a.active")
    .parents("ul.level-2")
    .css("height", "auto");

  // Add target="_blank" to all external links
  $('a[href^="https://"]').not("a[href*=devdocs]").attr("target", "_blank");


  // Fetch all data to localStorage
  $('#fetch-data').on('click', function(e) {
    $.ajax({
      url: "https://docs.usman.pw/?json=all",
      type: "get",
      dataType: "json",
      cache: false,
      success: function (response) {
        if (response.success) {
          for (const [key, value] of Object.entries(response.data)) {
            localStorage.setItem("page_" + key, JSON.stringify(value));
          }
        }
        console.info('Entries have been fetched successfully!')
      },
    });
  })
});
