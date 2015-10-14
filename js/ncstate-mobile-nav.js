window.mobile_nav = {};

(function(window, document, mobile_nav){

  'use strict';

  mobile_nav.init = function(){

    // caching jQuery objects for resuse
    
    mobile_nav.vars = {
      $win : $(window),
      $body : $('body'),
      $main: $("#mobile-nav-slide-out")
    };

    // init all the things

    self.initMenu();
    self.initMenuControl();
    self.initMenuState();
  };

  var self = {

    // ********************************************************************************
    // Main Init Methods 
    // ********************************************************************************

    initMenu: function(){
      $('#menu-toggle').click(self.handleMenuToggle);
    },

    initMenuControl: function(){
      $('.has-more > button').click(self.handleMoreBtn);
      $('.has-dropdown > button').click(self.handleDropdownBtn);
      $('#full-nav').click(self.handleFullNav);
    },

    initMenuState: function(){
      $('.has-dropdown button').each(function() {
        if( $(this).parent().hasClass('current-menu-item') || $(this).parent().hasClass('current-menu-ancestor') ) {
          $(this).click();
        }
      });

      if ( !! $("#mobile-nav").data('sub') ) {
        var sub = $("#mobile-nav").data('sub');
        self.handleMoreBtn(sub);
      }
    },

    // ********************************************************************************
    // Helpers 
    // ********************************************************************************

    handleMenuToggle: function(){
      if (mobile_nav.vars.$body.hasClass('mobile-nav-shown')) {
        mobile_nav.vars.$main.toggle("fast", function(){
          mobile_nav.vars.$body.removeClass('mobile-nav-shown');
        });
      }
      else {
        window.setTimeout(function(){mobile_nav.vars.$main.toggle();}, 300);
        mobile_nav.vars.$body.addClass('mobile-nav-shown');
      }
    },

    transitionLevels: function(){
      $('#level-2').fadeToggle(300);
      $('#mobile-nav').toggleClass('level-2-shown');
      if (mobile_nav.vars.$body.hasClass('mobile-nav-shown')) {
        window.setTimeout(function(){
            $('html, body').animate({scrollTop : 0});
          }, 300);
      }
    },

    handleMoreBtn: function(sub){
      sub = jQuery.type(sub) === "string" ? sub : $(this).data('sub');
      $('#level-2 li[id$=-sub]').hide();
      $(sub).show();
      self.transitionLevels();
    },

    handleDropdownBtn: function(){
      $(this).nextAll('ul').slideToggle('fast');
      $(this).parent().toggleClass('is-open');
    },

    handleFullNav: function(e){
      self.transitionLevels();
      e.preventDefault();
    }

  };

})(window, document, window.mobile_nav);

$(document).ready(function() {
// initialize js layer
window.mobile_nav.init();
});