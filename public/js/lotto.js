jQuery(document).ready(function($) {
      $(".clickablerow").click(function() {
            window.document.location = $(this).attr("href");
      });
      
      $(".clickToEditSkills").click(function() {
            window.document.location = $(this).attr("href");
      });
      
});