/**
 * @file
 * Provides jQuery behaviors.
 */


(function ($) {
  /**
   * Test jQuery by adding a test="test" attribute to all anchor tags.
   */
  Drupal.behaviors.testLinks = {
    attach: function (context, settings) {


      function pagePadding() {
        var headerHeight = $( '#masthead-wrap' ).height() - 1;
        $( '#page' ).css( 'padding-top', headerHeight );
      }

      // Call pagePadding() after a page load completely.
      $( window ).load( pagePadding );

      // Takes the focused menu item and shows its child item
      $('.page_item').focusin(function() {
        $(this).children().css('left', 'auto');
      });

      //Removes the above when not focused
      $('.page_item').focusout(function() {
        $(this).children().css('left', '');
      });

      // Takes the focused menu item and shows its child item
      $('.menu-item').focusin(function() {
        $(this).children().css('left', 'auto');
      });

      //Removes the above when not focused
      $('.menu-item').focusout(function() {
        $(this).children().css('left', '');
      });

      var $masthead = $( '#masthead' ),
        timeout = false;

      $.fn.smallMenu = function() {
        $masthead.find( '.site-navigation' ).removeClass( 'main-navigation' ).addClass( 'main-small-navigation' );
        $masthead.find( '.site-navigation h1' ).removeClass( 'assistive-text' ).addClass( 'menu-toggle' );

        $( '.menu-toggle' ).unbind( 'click' ).click( function() {
          $masthead.find( '.menu' ).toggle();
          $( this ).toggleClass( 'toggled-on' );
        } );
      };

      // Check viewport width on first load.
      if ( $( window ).width() < 600 )
        $.fn.smallMenu();

      // Check viewport width when user resizes the browser window.
      $( window ).resize( function() {
        var browserWidth = $( window ).width();

        if ( false !== timeout )
          clearTimeout( timeout );

        timeout = setTimeout( function() {
          if ( browserWidth < 600 ) {
            $.fn.smallMenu();
          } else {
            $masthead.find( '.site-navigation' ).removeClass( 'main-small-navigation' ).addClass( 'main-navigation' );
            $masthead.find( '.site-navigation h1' ).removeClass( 'menu-toggle' ).addClass( 'assistive-text' );
            $masthead.find( '.menu' ).removeAttr( 'style' );
          }
        }, 200 );
      } );

      var container = $( '.site-navigation' );

      // Fix child menus for touch devices.
      function fixMenuTouchTaps( container ) {
        var touchStartFn,
          parentLink = container.find( '.menu-item-has-children > a, .page_item_has_children > a' );

        if ( 'ontouchstart' in window ) {
          touchStartFn = function( e ) {
            var menuItem = this.parentNode;

            if ( !menuItem.classList.contains( 'focus' ) ) {
              e.preventDefault();
              for( var i = 0; i < menuItem.parentNode.children.length; ++i ) {
                if ( menuItem === menuItem.parentNode.children[i] ) {
                  continue;
                }
                menuItem.parentNode.children[i].classList.remove( 'focus' );
              }
              menuItem.classList.add( 'focus' );
            } else {
              menuItem.classList.remove( 'focus' );
            }
          };

          for ( var i = 0; i < parentLink.length; ++i ) {
            parentLink[i].addEventListener( 'touchstart', touchStartFn, false );
          }
        }
      }

      fixMenuTouchTaps( container );

    }
  };

})(jQuery);
