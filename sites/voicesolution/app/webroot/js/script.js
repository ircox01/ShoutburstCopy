/********************************************************
 *
 * Custom Javascript code for Enkel Bootstrap theme
 * Written by Themelize.me (http://themelize.me)
 *
 *******************************************************/
$(document).ready(function() {

  //IE placeholders
  $('[placeholder]').focus(function() {
    var input = $(this);
    if (input.val() == input.attr('placeholder')) {
      if (this.originalType) {
        this.type = this.originalType;
        delete this.originalType;
      }
      input.val('');
      input.removeClass('placeholder');
    }
  }).blur(function() {
    var input = $(this);
    if (input.val() == '') {
      input.addClass('placeholder');
      input.val(input.attr('placeholder'));
    }
  }).blur();  
  
  //Bootstrap tooltip
  // invoke by adding _tooltip to a tags (this makes it validate)
  $('body').tooltip({
    selector: "a[class*=_tooltip]"
  });
    
  //Bootstrap popover
  // invoke by adding _popover to a tags (this makes it validate)
  $('body').popover({
    selector: "a[class*=_popover]",
    trigger: "hover"
  });
  
  //show hide elements
  $('.show-hide').each(function() {
    $(this).click(function() {
      var state = 'open'; //assume target is closed & needs opening
      var target = $(this).attr('data-target');
      var targetState = $(this).attr('data-target-state');
      
      //allows trigger link to say target is open & should be closed
      if (typeof targetState !== 'undefined' && targetState !== false) {
        state = targetState;
      }
      
      if (state == 'undefined') {
        state = 'open';
      }
      
      $(target).toggleClass('show-hide-'+ state);
      $(this).toggleClass(state);      
    });
  });
  

  


  //jQuery Quicksand plugin
  //@based on: http://www.evoluted.net/thinktank/web-development/jquery-quicksand-tutorial-filtering
  var $filters = $('#quicksand-categories');
  var $filterType = $filters.find('li.active a').attr('class');
  var $holder = $('ul#quicksand');
  var $data = $holder.clone();

  // react to filters being used
  $filters.find('li a').click(function(e) {
    $filters.find('li').removeClass('active');
    var $filterType = $(this).attr('class');
    $(this).parent().addClass('active');
    if ($filterType == 'all') {
      var $filteredData = $data.find('li');
    } 
    else {
      var $filteredData = $data.find('li[data-type=' + $filterType + ']');
    }

    // call quicksand and assign transition parameters
    $holder.quicksand($filteredData, {
      duration: 800,
    });
    e.preventDefault();
  });
  
});


// A jQuery based placeholder polyfill
$(document).ready(function(){
  function add() {
    if($(this).val() === ''){
      $(this).val($(this).attr('placeholder')).addClass('placeholder');
    }
  }

  function remove() {
    if($(this).val() === $(this).attr('placeholder')){
      $(this).val('').removeClass('placeholder');
    }
  }

  // Create a dummy element for feature detection
  //if (!('placeholder' in $('<input>')[0])) {

    // Select the elements that have a placeholder attribute
    $('input[placeholder], textarea[placeholder]').blur(add).focus(remove).each(add);

    // Remove the placeholder text before the form is submitted
    $('form').submit(function(){
      $(this).find('input[placeholder], textarea[placeholder]').each(remove);
    });
  //}
});
