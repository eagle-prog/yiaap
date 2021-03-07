var transitionProp = getStyleProperty('transition');
var transitionEndEvent = {
  WebkitTransition: 'webkitTransitionEnd',
  MozTransition: 'transitionend',
  OTransition: 'otransitionend',
  transition: 'transitionend'
}[ transitionProp ];

$( function() {

  var $container = $('.masonry').masonry({
    columnWidth: '.grid-sizer',
    gutter: '.gutter-sizer',
    itemSelector: '.item'
  });

  $container.on( 'click', '.item-onoff-half.settings_trigger', function( event ) {
    var $this = $(this);
    
    var previousContentSize = getSize( this );
    // disable transition
    this.style[ transitionProp ] = 'none';
    // set current size
    $this.css({
      width: previousContentSize.width,
      height: previousContentSize.height
    });

    var $itemElem = $this.parent().toggleClass('is-expanded-half');

    // force redraw
    var redraw = this.offsetWidth;

    // renable default transition
    this.style[ transitionProp ] = '';

    // reset 100%/100% sizing after transition end
    if ( transitionProp ) {
      var _this = this;
      var onTransitionEnd = function() {
        _this.style.width = '';
        _this.style.height = '';
      };
      $this.one( transitionEndEvent, onTransitionEnd );
    }

    // set new size
    var size = getSize( $itemElem[0] );
    $this.css({
      width: size.width,
      height: size.height /2
    });

    $container.masonry();

  });

  $container.on( 'click', '.item-onoff-fourts', function( event ) {
    var $this = $(this);
    var previousContentSize = getSize( this );
    // disable transition
    this.style[ transitionProp ] = 'none';
    // set current size
    $this.css({
      width: previousContentSize.width,
      height: previousContentSize.height
    });

    var $itemElem = $this.parent().toggleClass('is-expanded-fourts');

    // force redraw
    var redraw = this.offsetWidth;

    // renable default transition
    this.style[ transitionProp ] = '';

    // reset 100%/100% sizing after transition end
    if ( transitionProp ) {
      var _this = this;
      var onTransitionEnd = function() {
        _this.style.width = '';
        _this.style.height = '';
      };
      $this.one( transitionEndEvent, onTransitionEnd );
    }

    // set new size
    var size = getSize( $itemElem[0] );
    $this.css({
      width: size.width,
      height: size.height /2
    });

    $container.masonry();

  });
  
});